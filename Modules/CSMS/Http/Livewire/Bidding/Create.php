<?php

namespace Modules\CSMS\Http\Livewire\Bidding;

use App\Enums\CSMS\CsmsStatus;
use App\Enums\CompanyType;
use App\Models\BusinessEntity;
use App\Models\Company;
use Auth;
use Carbon\Carbon;
use DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mail;
use Modules\CSMS\Entities\CsmsMasterDataChecklist;
use Modules\CSMS\Entities\Bidding;
use Modules\CSMS\Enums\ServiceCriteria;
use Modules\CSMS\Enums\BiddingStatus;
use Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
{
    use WithFileUploads, LivewireAlert;

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

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'searchUpdated' => 'searchUpdated',
    ];

    public function mount()
    {
        foreach ($this->ChecklistCsms as $value) {
            $this->{'checklist_csms_value_' . $value['id']} = null;
            $this->{'checklist_csms_file_' . $value['id']} = null;
            $this->{'checklist_csms_note_' . $value['id']} = null;
            $this->{'files_data_' . $value['id']} = [];
        }
    }

    public function updated($propertyName, $value)
    {
        foreach ($this->ChecklistCsms as $v) {
            if ($propertyName == 'checklist_csms_file_' . $v['id']) {
                if (is_object($value[0])) {
                    $this->addFile($v['id']);
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
    }

    public function removeFile($id, $index)
    {
        unset($this->{'files_data_' . $id}[$index]);
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

    public function save($published, $status)
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
                    if ($this->{'checklist_csms_value_' . $value['id']} == 'Ya') {

                        $this->validate(['checklist_csms_file_' . $value['id'] => 'required']);
                        // $this->validate(['checklist_csms_note_' . $value['id'] => 'required']);
                    }
                }
            }

            DB::beginTransaction();

            $BiddingData = [
                'maker_id' => Auth::user()->id,
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
                'requested' => ($status == CsmsStatus::OnReviewOHS) ? CsmsStatus::RequestedOHS : CsmsStatus::Draft,
                'published' => ($status == CsmsStatus::OnReviewOHS) ? CsmsStatus::Publish : CsmsStatus::Draft,
                'date' => Carbon::now(),
            ];

            $bidding = Bidding::create($BiddingData);
            // dd($bidding);

            foreach ($this->ChecklistCsms as $value) {
                $checklist = $bidding->checklists()->create([
                    'bidding_id' => $bidding->id,
                    'question_id' => $value['id'],
                    'point' => $value['point'],
                    'sub_point' => $value['sub_point'],
                    'crtiteria' => $value['crtiteria'],
                    'legal_base' => $value['legal_base'],
                    'note' => $value['note'],
                    'value' => $this->{'checklist_csms_value_' . $value['id']},
                    'comment' => $this->{'checklist_csms_note_' . $value['id']},
                ]);
                // dd($checklist);

                foreach ($this->{'files_data_' . $value['id']} as $key => $file) {
                    $path = 'csms/bidding/attachments/' . $bidding->id;

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
                    // dd($x);
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
            } else {
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
        return view('csms::livewire.bidding.create')->extends('csms::layouts.no-header');
    }
}
