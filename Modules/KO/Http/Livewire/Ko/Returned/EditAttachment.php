<?php

namespace Modules\KO\Http\Livewire\Ko\Returned;

use App\Enums\CompanyType;
use App\Enums\KO\KoStatus;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\KO\Entities\KoAttachment;
use Modules\KO\Entities\KoProposal;
use Modules\KO\Entities\KoSpipCategory;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EditAttachment extends Component
{
    use WithFileUploads, LivewireAlert;

    public $ko_proposal = [];

    public $stnk;
    public $nota_pajak;
    public $surat_pengantar;
    public $re_manufacture;
    public $oem;
    public $dokumen_sertifikat;
    public $inspeksi_p3k;
    public $kir;
    public $uji_pjit;
    public $pra_komisioning;
    public $setting_radio;
    public $slo;
    public $komisioning_internal;
    public $com;

    public function rules() {
        $fields = $this->ko_proposal->koUnit->koSpipUnit->attachment_field;

        $nonEmptyFields = [];
        if (Schema::hasTable('ko_attachments')) {
            $columns = Schema::getColumnListing('ko_attachments');

            foreach ($columns as $column) {
                $count = $this->ko_proposal->koAttachment ? $this->ko_proposal->koAttachment->whereNotNull($column)->count() : 0;

                if ($count > 0) {
                    $nonEmptyFields[] = $column;
                }
            }
        }

        $fields = array_diff($fields,$nonEmptyFields);

        $rules = array_fill_keys($fields, 'required|mimes:pdf');
        return $rules;
    }

    public function mount($id): void
    {
        $this->ko_proposal = KoProposal::find($id);
    }

    public function store($isDraft = 0): bool|RedirectResponse|Redirector
    {
        if (!empty($this->rules())) {
            $this->validate();
        }
        try {
            DB::beginTransaction();

            $data = [];
            $data['ko_proposal_id'] = $this->ko_proposal->id;

            $blobResponses = [];
            $attachmentFields = [
                'stnk', 'nota_pajak', 'surat_pengantar', 're_manufacture', 'oem',
                'dokumen_sertifikat', 'inspeksi_p3k', 'kir', 'uji_pjit',
                'pra_komisioning', 'setting_radio', 'slo', 'komisioning_internal', 'com'
            ];

            foreach ($attachmentFields as $field) {
                if ($this->$field) {
                    $file = $this->$field;
                    $filename = $file->getClientOriginalName();
                    $filePathTemp = $file->getRealPath();
                    $directPath = 'ko/attachment/' . $this->ko_proposal->id . '/' . $field;

                    $blobResult = uploadToBlobStorage($filename, $filePathTemp, $directPath);

                    if ($blobResult['fileBlobUrl']) {
                        $data[$field] = $blobResult['fileBlobUrl'];
                        $blobResponses[$field] = $blobResult['blobResponse'];
                    } else {
                        $path = 'ko/attachment/' . $this->ko_proposal->id;
                        $full_path = Storage::disk('public')->put($path, $file);
                        $data[$field] = $full_path;
                    }
                }
            }

            // Gabungkan/update data response jika sebelumnya sudah ada
            if (!empty($blobResponses)) {
                $oldResponses = [];
                if ($this->ko_proposal->koAttachment && $this->ko_proposal->koAttachment->blob_response) {
                    $oldResponses = json_decode($this->ko_proposal->koAttachment->blob_response, true) ?? [];
                }
                $data['blob_response'] = json_encode(array_merge($oldResponses, $blobResponses));
            }

            if ($this->ko_proposal->koAttachment) {
                $koAttachment = $this->ko_proposal->koAttachment->update($data);
            } else {
                $koAttachment = KoAttachment::create($data);
            }

            if ($isDraft != 1) {
                $this->ko_proposal->update([
                    'status' => $this->ko_proposal->admin_proposal_verified == 1 ? KoStatus::CoordinatorProposalVerification()->value : KoStatus::AdminProposalVerification()->value
                ]);
            }

            DB::commit();
            $this->flash('success','Berhasil mengupdate data!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return redirect()->route('ko::ko.index');
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Gagal',
                'icon' => 'error',
                'text' => json_encode([
                    'message' => $exception->getMessage(),
                    'line' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                ])
            ]);
            return false;
        }
    }

    public function render()
    {
        return view('ko::livewire.ko.returned.edit-attachment')->extends('ko::layouts.no-header');
    }
}
