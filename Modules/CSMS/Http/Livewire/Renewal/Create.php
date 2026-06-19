<?php

namespace Modules\CSMS\Http\Livewire\Renewal;

use App\Enums\CSMS\CsmsStatus;
use App\Enums\CSMS\RiskCategory;
use App\Enums\CompanyType;
use App\Models\BusinessEntity;
use App\Models\Company;
use App\Models\Employee;
use Auth;
use Carbon\Carbon;
use Complex\Functions;
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

class Create extends Component
{
    use WithFileUploads, LivewireAlert;

    public $bidding_id, $bidding;
    public $mode, $ccow, $criteria = CsmsStatus::Renewal, $ccow_id, $business_entity_id, $company_name, $address, $company_site, $license_number, $service_criteria, $company_id, $person_in_charge;
    public $company_nickname, $scope_of_business, $contract_period, $number_of_workers, $number_of_spv_pop, $number_of_spv_pom, $number_of_spv_pou, $number_of_spv_imp_smkp, $number_of_spv_auditor_smkp, $equipped_name, $equipped_position, $equipped_telephone, $equipped_email, $risk_category;
    public $companyType = null;

    protected $messages = [
        'ccow_id.required' => 'Harus pilih salah satu CCOW',
    ];

    public function mount($id)
    {
        $this->bidding = Bidding::find($id);

        $this->bidding_id = $this->bidding->parent->company_name . ' - ' . $this->bidding->parent->service_criteria->value . ' - ' . $this->bidding->parent->ccow->company_name;
        $this->ccow_id = $this->bidding->ccow_id;
        $this->business_entity_id = $this->bidding->business_entity_id;
        $this->company_name = $this->bidding->company_name;
        $this->address = $this->bidding->address;
        $this->company_site = $this->bidding->company_site;
        $this->license_number = $this->bidding->license_number;
        $this->service_criteria = $this->bidding->service_criteria;
        $this->company_id = $this->bidding->company_id;
        $this->person_in_charge = $this->bidding->person_in_charge;
        $this->emit('refreshComponent');

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
        // dd($this->{'files_data_' . $id});
    }

    public function removeFile($id, $index)
    {
        unset($this->{'files_data_' . $id}[$index]);

        // $this->alert('warning', 'File dihapus.', [
        //     'position' => 'top-end',
        //     'timer' => 3000,
        //     'toast' => true,
        // ]);

        // $this->emit('refreshComponent');
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
        $this->emit('x-kplh-texteditor');
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

    public function updatedRiskCategory()
    {
        $this->getChecklistCsmsProperty();
    }

    public function getChecklistCsmsProperty()
    {
        if ($this->risk_category == RiskCategory::Rendah) {
            return CsmsMasterDataChecklist::where('point', 'PERPANJANGAN SERTIFIKASI CSMS')
                ->whereIn('ordinal_number', [1, 2, 3, 4, 7, 16, 18, 24, 26])
                ->get();
        } elseif ($this->risk_category == RiskCategory::Menengah) {
            return CsmsMasterDataChecklist::where('point', 'PERPANJANGAN SERTIFIKASI CSMS')
                ->whereIn('ordinal_number', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 18, 19, 22, 23, 24, 25, 26, 28, 29, 30, 31, 32, 33])
                ->get();
        } else {
            return CsmsMasterDataChecklist::where('point', 'PERPANJANGAN SERTIFIKASI CSMS')->whereNot('id', 56)->get();
        }
    }

    public function save($published, $status)
    {
        try {
            $this->validate([
                'bidding_id' => 'required',
            ]);

            if ($status == CsmsStatus::OnReviewOHS) {

                $this->validate([
                    'company_nickname' => 'required',
                    'scope_of_business' => 'required',
                    'contract_period' => 'required',
                    'number_of_workers' => 'required',
                    'number_of_spv_pop' => 'required',
                    'number_of_spv_pom' => 'required',
                    'number_of_spv_pou' => 'required',
                    'number_of_spv_imp_smkp' => 'required',
                    'number_of_spv_auditor_smkp' => 'required',
                    'equipped_name' => 'required',
                    'equipped_position' => 'required',
                    'equipped_telephone' => 'required',
                    'equipped_email' => 'required',

                    'risk_category' => 'required',
                ]);

                foreach ($this->ChecklistCsms as $value) {
                    $this->validate(['checklist_csms_value_' . $value['id'] => 'required']);
                    if ($this->{'checklist_csms_value_' . $value['id']} == 'Tidak') {

                        $this->validate(['checklist_csms_file_' . $value['id'] => 'required']);
                        $this->validate(['checklist_csms_note_' . $value['id'] => 'required']);
                    }
                }
            }

            DB::beginTransaction();

            $post_bidding = $this->bidding;
            $post_bidding->risk_category = $this->risk_category;

            // STATUS
            $post_bidding->requested = CsmsStatus::RequestedOHS;
            $post_bidding->published = $published;
            $post_bidding->status = $status;

            $questionnaire = [
                'company_nickname' => $this->company_nickname,
                'scope_of_business' => $this->scope_of_business,
                'contract_period' => $this->contract_period,
                'number_of_workers' => $this->number_of_workers,
                'number_of_spv_pop' => $this->number_of_spv_pop,
                'number_of_spv_pom' => $this->number_of_spv_pom,
                'number_of_spv_pou' => $this->number_of_spv_pou,
                'number_of_spv_imp_smkp' => $this->number_of_spv_imp_smkp,
                'number_of_spv_auditor_smkp' => $this->number_of_spv_auditor_smkp,
                'equipped_name' => $this->equipped_name,
                'equipped_position' => $this->equipped_position,
                'equipped_telephone' => $this->equipped_telephone,
                'equipped_email' => $this->equipped_email,
            ];

            $post_bidding->questionnaire = json_encode($questionnaire);

            $post_bidding->save();

            // dd($post_bidding);

            foreach ($this->ChecklistCsms as $value) {
                $checklist = $post_bidding->checklists()->create([
                    'bidding_id' => $post_bidding->id,
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
                    $path = 'csms/post-bidding/attachments/' . $post_bidding->id;

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
                return redirect()->route('csms::post-bidding.ongoing');
            } else {
                return redirect()->route('csms::post-bidding.draft');
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
        return view('csms::livewire.renewal.create')->extends('csms::layouts.no-header');
    }
}
