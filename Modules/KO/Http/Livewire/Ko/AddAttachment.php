<?php

namespace Modules\KO\Http\Livewire\Ko;

use App\Enums\CompanyType;
use App\Enums\KO\KoStatus;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Modules\KO\Entities\KoAttachment;
use Modules\KO\Entities\KoProposal;
use Modules\KO\Entities\KoSpipCategory;
use Mail;
use App\Mail\KO\ProposalUpdated;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AddAttachment extends Component
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

    public $files;

    public function rules() {
        $fields = $this->ko_proposal->koUnit->koSpipUnit->attachment_field ?? [];
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

            if ($this->stnk) {
                $path = 'ko/attachment/' . $this->ko_proposal->id;
                $full_path = Storage::disk('public')->put($path, $this->stnk);
                $data['stnk'] = $full_path;
            }

            if ($this->nota_pajak) {
                $path = 'ko/attachment/' . $this->ko_proposal->id;
                $full_path = Storage::disk('public')->put($path, $this->nota_pajak);
                $data['nota_pajak'] = $full_path;
            }

            if ($this->surat_pengantar) {
                $path = 'ko/attachment/' . $this->ko_proposal->id;
                $full_path = Storage::disk('public')->put($path, $this->surat_pengantar);
                $data['surat_pengantar'] = $full_path;
            }

            if ($this->re_manufacture) {
                $path = 'ko/attachment/' . $this->ko_proposal->id;
                $full_path = Storage::disk('public')->put($path, $this->re_manufacture);
                $data['re_manufacture'] = $full_path;
            }

            if ($this->oem) {
                $path = 'ko/attachment/' . $this->ko_proposal->id;
                $full_path = Storage::disk('public')->put($path, $this->oem);
                $data['oem'] = $full_path;
            }

            if ($this->dokumen_sertifikat) {
                $path = 'ko/attachment/' . $this->ko_proposal->id;
                $full_path = Storage::disk('public')->put($path, $this->dokumen_sertifikat);
                $data['dokumen_sertifikat'] = $full_path;
            }

            if ($this->inspeksi_p3k) {
                $path = 'ko/attachment/' . $this->ko_proposal->id;
                $full_path = Storage::disk('public')->put($path, $this->inspeksi_p3k);
                $data['inspeksi_p3k'] = $full_path;
            }

            if ($this->kir) {
                $path = 'ko/attachment/' . $this->ko_proposal->id;
                $full_path = Storage::disk('public')->put($path, $this->kir);
                $data['kir'] = $full_path;
            }

            if ($this->uji_pjit) {
                $path = 'ko/attachment/' . $this->ko_proposal->id;
                $full_path = Storage::disk('public')->put($path, $this->uji_pjit);
                $data['uji_pjit'] = $full_path;
            }

            if ($this->pra_komisioning) {
                $path = 'ko/attachment/' . $this->ko_proposal->id;
                $full_path = Storage::disk('public')->put($path, $this->pra_komisioning);
                $data['pra_komisioning'] = $full_path;
            }

            if ($this->setting_radio) {
                $path = 'ko/attachment/' . $this->ko_proposal->id;
                $full_path = Storage::disk('public')->put($path, $this->setting_radio);
                $data['setting_radio'] = $full_path;
            }

            if ($this->slo) {
                $path = 'ko/attachment/' . $this->ko_proposal->id;
                $full_path = Storage::disk('public')->put($path, $this->slo);
                $data['slo'] = $full_path;
            }

            if ($this->komisioning_internal) {
                $path = 'ko/attachment/' . $this->ko_proposal->id;
                $full_path = Storage::disk('public')->put($path, $this->komisioning_internal);
                $data['komisioning_internal'] = $full_path;
            }

            if ($this->com) {
                $path = 'ko/attachment/' . $this->ko_proposal->id;
                $full_path = Storage::disk('public')->put($path, $this->com);
                $data['com'] = $full_path;
            }

            $koAttachment = KoAttachment::create($data);

            if ($isDraft != 1) {
                $this->ko_proposal->update([
                    'status' => KoStatus::AdminProposalVerification()->value
                ]);

                Mail::to($this->ko_proposal->pjo->email)->send(new ProposalUpdated($this->ko_proposal));
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
        return view('ko::livewire.ko.add-attachment')->extends('ko::layouts.no-header');
    }
}
