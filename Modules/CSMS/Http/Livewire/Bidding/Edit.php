<?php

namespace Modules\CSMS\Http\Livewire\Bidding;

use App\Enums\CSMS\CsmsStatus;
use App\Enums\CompanyType;
use App\Models\BusinessEntity;
use App\Models\Company;
use App\Models\Employee;
use Auth;
use Carbon\Carbon;
use DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mail;
use Modules\CSMS\Entities\CsmsMasterDataChecklist;
use Modules\CSMS\Entities\Bidding;
use Modules\CSMS\Entities\CsmsChecklist;
use Modules\CSMS\Entities\CsmsChecklistAttacment;
use Modules\CSMS\Enums\ServiceCriteria;
use Modules\CSMS\Enums\BiddingStatus;
use Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Edit extends Component
{
    use WithFileUploads, LivewireAlert;

    public Bidding $bidding;

    public $criteria = CsmsStatus::Bidding, $ccow_id, $business_entity_id, $company_name, $address, $company_site, $license_number, $service_criteria, $company_id, $person_in_charge;
    public $companyType = null;

    protected $messages = [
        'criteria.required' => 'Harus pilih salah satu Kriteria CSMS',
        'ccow_id.required' => 'Harus pilih salah satu CCOW',

        'business_entity_id' => 'Harus pilih salah satu Jenis Badan Usaha',
        'company_name' => 'Nama Perusahaan wajib diisi',
        'address' => 'Alamat Perusahaan wajib diisi',
        'company_site' => 'Site Perusahaan wajib diisi',
        'license_number' => 'Nomor Ijin Badan Usaha wajib diisi',
        'service_criteria' => 'Harus pilih salah satu Kriteria Jasa Perusahaan',
        'person_in_charge' => 'Penanggung Jawab Bidder wajib diisi',
        'company_id.required' => 'Harus pilih salah satu Perusahaan Induk',
    ];

    public function mount(Bidding $bidding)
    {
        $this->bidding = $bidding;

        $this->criteria = $bidding->criteria;
        $this->ccow_id = $bidding->ccow_id;
        $this->business_entity_id = $bidding->business_entity_id;
        $this->company_name = $bidding->company_name;
        $this->address = $bidding->address;
        $this->company_site = $bidding->company_site;
        $this->license_number = $bidding->license_number;
        $this->service_criteria = $bidding->service_criteria;
        $this->company_id = $bidding->company_id;
        $this->person_in_charge = $bidding->person_in_charge;

        foreach ($bidding->checklists as $v) {
            $this->{'checklist_csms_value_' . $v->question_id} = $v->value;
            $this->{'checklist_csms_file_' . $v->question_id} = null;
            $this->{'checklist_csms_note_' . $v->question_id} = $v->comment;
            $this->{'files_data_' . $v->question_id} = [];
            $this->{'oldFiles_' . $v->question_id} = $v->files;
        }
    }

    public function updated($propertyName, $value)
    {
        foreach ($this->bidding->checklists as $v) {
            if ($propertyName == 'checklist_csms_file_' . $v->question_id) {
                if ($v) {
                    $this->addFile($v->question_id);
                }
            }
        }
    }

    public function addFile($id)
    {
        $this->{'files_data_' . $id}[] = [
            'file' => $this->{'checklist_csms_file_' . $id}[0],
            'name' => $this->{'checklist_csms_file_' . $id}[0]->getClientOriginalName(),
            'size' => changeByte($this->{'checklist_csms_file_' . $id}[0]->getSize()),
            'extension' => $this->{'checklist_csms_file_' . $id}[0]->getClientOriginalExtension(),
        ];
        // dd($this->{'files_data_' . $id});
    }

    public function removeFile($id, $index)
    {
        unset($this->{'files_data_' . $id}[$index]);

        $this->alert('warning', 'File dihapus.', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);

        $this->emit('refreshComponent');
    }

    public function deleteOldFile($id, $question_id, $key)
    {
        try {
            DB::beginTransaction();
            CsmsChecklistAttacment::find($id)->delete();
            DB::commit();

            unset($this->{'oldFiles_' . $question_id}[$key]);

            $this->alert('warning', 'File dihapus.', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            $this->emit('refreshComponent');
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

    public function hydrate()
    {
        $this->emit('select2');
        $this->emit('datetimepicker-input');
        $this->emit('form-check-input');
    }

    public function getCompanyBusinessTypesProperty()
    {
        return BusinessEntity::get();
    }

    public function getServiceCriteriasProperty()
    {
        return CompanyType::asSelectArray();
    }

    public function getCompanyParentsProperty()
    {
        return Company::where('type', CompanyType::Contractor)->get();
    }

    public function getCcowsProperty()
    {
        return Company::where('type', CompanyType::Internal)->get();
    }

    public function getChecklistCsmsProperty()
    {
        return CsmsMasterDataChecklist::where('point', 'BIDDING PROCESS')->get();
    }

    public function save($published, $requested, $status)
    {
        try {
            $this->validate([
                'criteria' => 'required',
                'ccow_id' => 'required',
                'business_entity_id' => 'required',
                'company_name' => 'required',
                'address' => 'required',
                'company_site' => 'required',
                'license_number' => 'required',
                'service_criteria' => 'required',
                'person_in_charge' => 'required',
            ]);

            if ($this->service_criteria == ServiceCriteria::SubContractor->value) {
                $this->validate([
                    'company_id' => 'required',
                ]);
            }
            if ($status == CsmsStatus::OnReviewOHS) {

                foreach ($this->ChecklistCsms as $value) {
                    $this->validate(['checklist_csms_value_' . $value['id'] => 'required']);
                }
            }

            DB::beginTransaction();

            $this->bidding->update([
                // 'maker_id' => Auth::user()->id,
                'criteria' => $this->criteria,
                'ccow_id' => $this->ccow_id,
                'company_id' => $this->company_id,
                'business_entity_id' => $this->business_entity_id,
                'company_name' => $this->company_name,
                'address' => $this->address,
                'company_site' => $this->company_site,
                'license_number' => $this->license_number,
                'service_criteria' => $this->service_criteria,
                'person_in_charge' => $this->person_in_charge,
                'status' => $status,
                'requested' => $requested,
                'published' => $published,
                'date' => Carbon::now(),
            ]);

            foreach ($this->bidding->checklists as $v) {
                $checklist = CsmsChecklist::find($v->id);

                $checklist->update([
                    'value' => $this->{'checklist_csms_value_' . $v->question_id},
                    'comment' => $this->{'checklist_csms_note_' . $v->question_id},
                ]);

                if ($this->{'files_data_' . $v->question_id}) {

                    foreach ($this->{'files_data_' . $v->question_id} as $file) {

                        $path = 'csms/bidding/attachments/' . $this->bidding->id;

                        $checklist->files()->delete();

                        if ($file && Storage::exists($path . '/' . $file['name'])) {
                            Storage::delete($path . '/' . $file['name']);
                        }

                        $filename = $file['name'];
                        $filePathTemp = $file['file']->getRealPath();
                        $blobResult = uploadToBlobStorage($filename, $filePathTemp, $path);

                        $full_path = $blobResult['fileBlobPathName'] ?? ($path . '/' . $filename);
                        $blobUrl = $blobResult['fileBlobUrl'] ?? null;
                        $blobResponse = $blobResult['blobResponse'] ? json_encode($blobResult['blobResponse']) : null;

                        $x = $checklist->files()->create([
                            'file' => $full_path,
                            'blob_url' => $blobUrl,
                            'blob_response' => $blobResponse,
                            'size' => $file['size'],
                            'name' => $file['name'],
                            'type' => $file['extension']
                        ]);
                    }
                }
            }

            // dd('stop');
            DB::commit();

            $this->flash('success', 'Data berhasil di simpan!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            if ($status == CsmsStatus::OnReviewOHS) {
                return redirect()->route('csms::bidding.ongoing');
            } elseif ($status == CsmsStatus::Approved) {
                return redirect()->route('csms::bidding.active');
            } elseif ($status == CsmsStatus::Draft) {
                return redirect()->route('csms::bidding.draft');
            } else {
                // if (condition) {
                // }
                return redirect()->route('csms::bidding.draft');
            }
        } catch (\Throwable $th) {

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Error',
                'icon' => 'error',
                'text' => $th->getMessage(),
            ]);
        }
    }

    public function render()
    {
        return view('csms::livewire.bidding.edit')->extends('csms::layouts.no-header');
    }
}
