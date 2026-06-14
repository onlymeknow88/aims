<?php

namespace Modules\CSMS\Http\Livewire\PostBidding;

use App\Enums\CSMS\CsmsStatus;
use App\Enums\CSMS\RiskCategory;
use App\Enums\CompanyType;
use App\Models\BusinessEntity;
use App\Models\Company;
use App\Models\Employee;
use Auth;
use PDF;
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

    public $bidding_id, $post_bidding;
    public $mode, $ccow, $criteria = 'POST BIDDING', $ccow_id, $business_entity_id, $company_name, $address, $company_site, $license_number, $service_criteria, $classification, $company_id, $person_in_charge;
    public $questionnaire = [], $company_nickname, $scope_of_business, $contract_period, $date_contract_period_end, $date_contract_period_start, $number_of_workers, $number_of_spv_pop, $number_of_spv_pom, $number_of_spv_pou, $number_of_spv_imp_smkp, $number_of_spv_auditor_smkp, $equipped_name, $equipped_position, $equipped_telephone, $equipped_email, $questionnaire_file, $risk_category;
    public $companyType = null;

    protected $messages = [
        'ccow_id.required' => 'Harus pilih salah satu CCOW',
    ];

    public function mount(Bidding $bidding)
    {
        $this->post_bidding = $bidding;

        $this->bidding_id = $bidding->parent_id;
        $this->criteria = $bidding->criteria;
        $this->ccow_id = $bidding->ccow_id;
        $this->business_entity_id = $bidding->business_entity_id;
        $this->company_name = $bidding->company_name;
        $this->address = $bidding->address;
        $this->company_site = $bidding->company_site;
        $this->license_number = $bidding->license_number;
        $this->service_criteria = $bidding->service_criteria;
        $this->classification = $bidding->classification;
        $this->company_id = $bidding->company_id;
        $this->person_in_charge = $bidding->person_in_charge;

        $questionnaire = json_decode($bidding->questionnaire);
        $this->company_nickname = $questionnaire && property_exists($questionnaire, 'company_nickname') ? $questionnaire->company_nickname : null;
        $this->scope_of_business = $questionnaire && property_exists($questionnaire, 'scope_of_business') ? $questionnaire->scope_of_business : null;
        // $this->contract_period = $questionnaire && property_exists($questionnaire, 'contract_period') ? $questionnaire->contract_period : null;
        $this->date_contract_period_start = $questionnaire && property_exists($questionnaire, 'date_contract_period_start') ? $questionnaire->date_contract_period_start : null;
        $this->date_contract_period_end = $questionnaire && property_exists($questionnaire, 'date_contract_period_end') ? $questionnaire->date_contract_period_end : null;
        $this->number_of_workers = $questionnaire && property_exists($questionnaire, 'number_of_workers') ? $questionnaire->number_of_workers : null;
        $this->number_of_spv_pop = $questionnaire && property_exists($questionnaire, 'number_of_spv_pop') ? $questionnaire->number_of_spv_pop : null;
        $this->number_of_spv_pom = $questionnaire && property_exists($questionnaire, 'number_of_spv_pom') ? $questionnaire->number_of_spv_pom : null;
        $this->number_of_spv_pou = $questionnaire && property_exists($questionnaire, 'number_of_spv_pou') ? $questionnaire->number_of_spv_pou : null;
        $this->number_of_spv_imp_smkp = $questionnaire && property_exists($questionnaire, 'number_of_spv_imp_smkp') ? $questionnaire->number_of_spv_imp_smkp : null;
        $this->number_of_spv_auditor_smkp = $questionnaire && property_exists($questionnaire, 'number_of_spv_auditor_smkp') ? $questionnaire->number_of_spv_auditor_smkp : null;
        $this->equipped_name = $questionnaire && property_exists($questionnaire, 'equipped_name') ? $questionnaire->equipped_name : null;
        $this->equipped_position = $questionnaire && property_exists($questionnaire, 'equipped_position') ? $questionnaire->equipped_position : null;
        $this->equipped_telephone = $questionnaire && property_exists($questionnaire, 'equipped_telephone') ? $questionnaire->equipped_telephone : null;
        $this->equipped_email = $questionnaire && property_exists($questionnaire, 'equipped_email') ? $questionnaire->equipped_email : null;
        $this->questionnaire_file = $questionnaire && property_exists($questionnaire, 'questionnaire_file') ? $questionnaire->questionnaire_file : null;
        $this->risk_category = $bidding->risk_category;

        foreach ($bidding->checklists as $v) {
            $this->{'checklist_csms_value_' . $v->question_id} = $v->value;
            $this->{'checklist_csms_file_' . $v->question_id} = null;
            $this->{'checklist_csms_note_' . $v->question_id} = $v->comment;
            $this->{'files_data_' . $v->question_id} = [];
            $this->{'oldFiles_' . $v->question_id} = $v->files;
        }

        // $this->getChecklistCsmsProperty();
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

        $this->questionnaire = [
            'company_nickname' => $this->company_nickname,
            'scope_of_business' => $this->scope_of_business,
            // 'contract_period' => $this->contract_period,
            'number_of_workers' => $this->number_of_workers,
            'date_contract_period_start' => $this->date_contract_period_start,
            'date_contract_period_end' => $this->date_contract_period_end,
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
    }

    public function exportQuestionnaire()
    {
        if (!$this->questionnaire) {
            $this->questionnaire = [];
            $this->questionnaire = json_decode($this->post_bidding->questionnaire, true);
        }

        foreach ($this->questionnaire as $key => $value) {

            if (empty($value)) {
                $this->alert('error', '' . $key . ' Belum Terisi', [
                    'position' => 'top-end',
                    'timer' => 3000,
                    'toast' => true,
                ]);
                return false;
            }
        }

        $count_bidding = Bidding::count();

        $date = Carbon::parse($this->bidding->date);

        $this->questionnaire['document_rev'] = '1.0';
        $this->questionnaire['document_date'] = $date->format('d-m-Y');
        $this->questionnaire['date'] = $date->format('d F Y');
        $this->questionnaire['criteria'] = $this->criteria;
        $this->questionnaire['ccow'] = Company::find($this->ccow_id)->first()->company_name;
        $this->questionnaire['company_name'] = $this->company_name;
        $this->questionnaire['company_parent'] = Company::find($this->company_id) ? Company::find($this->company_id)->first()->company_name : '-';
        $this->questionnaire['business_entity'] = BusinessEntity::find($this->business_entity_id)->first()->name;
        $this->questionnaire['address'] = $this->address;
        $this->questionnaire['license_number'] = $this->license_number;
        $this->questionnaire['service_criteria'] = $this->service_criteria->value;
        $this->questionnaire['classification'] = $this->classification;
        $this->questionnaire['document_number'] = '' . (sprintf("%04d", ($count_bidding + 1))) . '-CSMS-' . Company::find($this->ccow_id)->first()->document_code . '-' . $this->questionnaire['company_nickname'] . '-' . $date->format('m/y') . '';

        // dd($this->questionnaire);

        $pdfContent = PDF::loadView('csms::livewire.post-bidding.pdf.questionnaire', ['data' => $this->questionnaire])->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "F-MAC-IMS-08-001 Kuesioner CSMS_rev2.0 - " . $this->questionnaire['company_nickname'] . ".pdf"
        );
    }

    public function getBiddingsProperty()
    {
        return Bidding::where('criteria', CsmsStatus::Bidding)
            ->where('status', CsmsStatus::Approved)
            ->where('requested', CsmsStatus::Approved)
            ->where('published', CsmsStatus::Publish)
            ->whereNull('parent_id')
            ->get();
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

    public function updatedRiskCategory()
    {
        $this->getChecklistCsmsProperty();
    }

    public function getChecklistCsmsProperty()
    {
        if ($this->risk_category == RiskCategory::Rendah) {
            return CsmsMasterDataChecklist::where('point', 'POST KUALIFIKASI')
                ->whereIn('ordinal_number', [1, 2, 3, 4, 8, 17, 18, 25, 27])
                ->get();
        } elseif ($this->risk_category == RiskCategory::Menengah) {
            return CsmsMasterDataChecklist::where('point', 'POST KUALIFIKASI')
                ->whereIn('ordinal_number', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 19, 20, 23, 24, 25, 26, 27, 29, 30, 31, 32, 33, 34])
                ->get();
        } else {
            return CsmsMasterDataChecklist::where('point', 'POST KUALIFIKASI')->get();
        }
    }

    public function save($published, $requested, $status)
    {
        try {
            $this->validate([
                'bidding_id' => 'required',
            ]);

            if ($status == CsmsStatus::OnReviewOHS) {

                $this->validate([
                    'company_nickname' => 'required',
                    'scope_of_business' => 'required',
                    // 'contract_period' => 'required',
                    'date_contract_period_end' => 'required',
                    'date_contract_period_start' => 'required',
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
                    if ($this->{'checklist_csms_value_' . $value['id']} == 'Ya') {

                        $this->validate(['checklist_csms_file_' . $value['id'] => 'required']);
                        // $this->validate(['checklist_csms_note_' . $value['id'] => 'required']);
                    }
                }
            }

            DB::beginTransaction();

            // $this->bidding->update([
            //     'risk_category' => $this->risk_category,

            //     'requested' => CsmsStatus::RequestedOHS,
            //     'published' => $published,
            //     'status' => $status,
            // ]);

            $this->post_bidding->risk_category = $this->risk_category;

            // STATUS
            $this->post_bidding->requested = $published == CsmsStatus::Draft ? CsmsStatus::Draft : CsmsStatus::RequestedOHS;
            $this->post_bidding->published = $published;
            $this->post_bidding->status = $status;
            $this->post_bidding->classification = $this->classification;
            $this->post_bidding->risk_category = $this->risk_category;

            $this->post_bidding->questionnaire = json_encode($this->questionnaire);

            $this->post_bidding->save();
            // dd($this->post_bidding);
            // dd($this->post_bidding->checklists);
            foreach ($this->post_bidding->checklists as $v) {
                $checklist = CsmsChecklist::find($v->id);

                $checklist->update([
                    'value' => $this->{'checklist_csms_value_' . $v->question_id},
                    'comment' => $this->{'checklist_csms_note_' . $v->question_id},
                ]);

                if ($this->{'files_data_' . $v->question_id}) {

                    foreach ($this->{'files_data_' . $v->question_id} as $file) {
                        $path = 'csms/post-bidding/attachments/' . $this->bidding->id;
                        $full_path = Storage::disk('public')->putFileAs($path, $file['file'], $file['name']);
                        $x = $checklist->files()->create([
                            'file' => $full_path,
                            'size' => $file['size'],
                            'name' => $file['name'],
                            'type' => $file['extension']
                        ]);
                        // dd($x);
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
                return redirect()->route('csms::post-bidding.ongoing');
            } elseif ($status == CsmsStatus::Approved) {
                return redirect()->route('csms::post-bidding.active');
            } elseif ($status == CsmsStatus::Draft) {
                return redirect()->route('csms::post-bidding.draft');
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
        return view('csms::livewire.post-bidding.edit')->extends('csms::layouts.no-header');
    }
}
