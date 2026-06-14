<?php

namespace Modules\CSMS\Http\Livewire\PostBidding;

use App\Enums\CSMS\CsmsStatus;
use App\Models\Company;
use Carbon\Carbon;
use DB;
use Livewire\Component;
use Modules\CSMS\Entities\CsmsMasterDataChecklist;
use Modules\CSMS\Entities\Bidding;
use Modules\CSMS\Entities\CsmsChecklist;
use Modules\CSMS\Entities\CsmsChecklistAttacment;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use PDF;

class Detail extends Component
{
    use LivewireAlert;
    public Bidding $bidding;
    public $created_at, $updated_at, $criteria, $ccow_id, $business_entity_id, $company_name, $address, $company_site, $license_number, $service_criteria, $company_id, $person_in_charge;
    public $questionnaire = [], $company_nickname, $scope_of_business, $contract_period, $number_of_workers, $number_of_spv_pop, $number_of_spv_pom, $number_of_spv_pou, $number_of_spv_imp_smkp, $number_of_spv_auditor_smkp, $equipped_name, $equipped_position, $equipped_telephone, $equipped_email,  $questionnaire_file, $risk_category;
    public $maker;

    public function mount(Bidding $bidding)
    {
        $this->bidding = $bidding;
        $this->maker = User::find($bidding->maker_id);

        $this->created_at = Carbon::parse($bidding->created_at)->format('d F Y');
        $this->updated_at = Carbon::parse($bidding->updated_at)->format('d F Y');

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

        $questionnaire = json_decode($bidding->questionnaire);
        // dd($bidding);
        $this->company_nickname = $questionnaire && property_exists($questionnaire, 'company_nickname') ? $questionnaire->company_nickname : null;
        $this->scope_of_business = $questionnaire && property_exists($questionnaire, 'scope_of_business') ? $questionnaire->scope_of_business : null;
        $this->contract_period = $questionnaire && property_exists($questionnaire, 'contract_period') ? $questionnaire->contract_period : null;
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
        $this->risk_category;

        // dd($questionnaire->company_nickname);
        foreach ($bidding->checklists as $v) {
            $this->{'checklist_csms_value_' . $v->question_id} = $v->value;
            $this->{'checklist_csms_file_' . $v->question_id} = null;
            $this->{'checklist_csms_note_' . $v->question_id} = $v->comment;
            $this->{'files_data_' . $v->question_id} = [];
            $this->{'oldFiles_' . $v->question_id} = $v->files;
        }
    }

    public function approve($status, $requested)
    {
        try {
            DB::beginTransaction();

            if ($status == CsmsStatus::Approved) {
                if ($this->bidding->criteria == CsmsStatus::Renewal) {
                    $parent = Bidding::find($this->bidding->parent_id);
                    $parent->status = CsmsStatus::Inactive;
                    $parent->requested = CsmsStatus::Approved;
                    $parent->revision = $parent->revision + 1;
                    $parent->is_obsolate = true;
                    $parent->save();
                }

                if ($this->bidding->criteria == CsmsStatus::Inactive) {
                    $parent = Bidding::find($this->bidding->parent_id);
                    $parent->status = CsmsStatus::Inactive;
                    $parent->requested = CsmsStatus::Approved;
                    $parent->save();

                    $status = CsmsStatus::Inactive;
                }
            }

            $this->bidding->status = $status;
            $this->bidding->requested = $requested;
            // $this->bidding->published = CsmsStatus::Publish;
            $this->bidding->save();

            if (
                $this->bidding->criteria == CsmsStatus::PostBidding
                && $this->bidding->status == CsmsStatus::Approved
                && $this->bidding->requested == CsmsStatus::Approved
                && $this->bidding->published == CsmsStatus::Publish
            ) {
                $this->backoffice_sync();
            }

            // dd($this->bidding);
            DB::commit();

            $this->flash('success', 'Data berhasil di simpan!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            redirect()->route('csms::approval.post-bidding');
        } catch (\Throwable $th) {

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Error',
                'icon' => 'error',
                'text' => $th->getMessage(),
            ]);
        }
    }

    public function backoffice_sync()
    {
        $this->validate([
            'company_name' => 'required',
            'company_nickname' => 'required',
            'address' => 'required',
            'equipped_email' => 'required',
            'equipped_telephone' => 'required',
            'service_criteria' => 'required',
            'ccow_id' => 'required'
        ]);

        DB::beginTransaction();
        $company = Company::where('company_name', $this->company_name)->count();

        if (!$company) {
            $cc = Company::create([
                'company_name' => $this->company_name,
                'document_code' => $this->company_nickname,
                'address' => $this->address,
                'email' => $this->equipped_email,
                'phone_number' => $this->equipped_telephone,
                'type' => $this->service_criteria->value,
                'parent_company_id' => $this->ccow_id,
            ]);
        }

        DB::commit();
    }

    public function getSyncStatusProperty()
    {
        $company = Company::where('company_name', $this->company_name)->count();

        return ($company) ? FALSE : TRUE;
    }

    public function return_maker()
    {
        DB::beginTransaction();
        // $this->bidding->status = CsmsStatus::OnReviewOHS;
        $this->bidding->requested = CsmsStatus::Rejected;
        // $this->bidding->published = CsmsStatus::Publish;

        $this->bidding->save();

        // $this->toPica();
        DB::commit();

        $this->flash('success', 'Data berhasil di simpan!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);

        redirect()->route('csms::approval.post-bidding');
    }


    public function certificate($id)
    {
        $now = Carbon::now();
        $count = Bidding::whereIn('criteria', [CsmsStatus::PostBidding, CsmsStatus::Renewal, CsmsStatus::Inactive])
            ->whereIn('status', [CsmsStatus::Approved])
            ->whereIn('requested', [CsmsStatus::Approved])
            ->where('published', CsmsStatus::Publish)
            ->where(DB::raw('YEAR(created_at)'), '=', $now->format('Y'))
            ->count();

        $bidding = Bidding::find($id);

        $docNumber = 'F-'.$bidding->ccow->document_code.'-IMS-' . $now->format('y') . '-' . (sprintf("%03d", ($count + 1))) . '';
        $q = json_decode($bidding->questionnaire);

        $qrcode = preg_replace(
                    "~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~",
                    "\\0",
                    "https://qrcode.tec-it.com/API/QRCode?data=APLIKASI ADARO INTEGRATED MANAGEMENT SYSTEM (AIMS)\n\n\nmenyatakan bahwa:\n\nPemenuhan CSMS ".$bidding->company_name.", adalah CCOW dari PT ".$bidding->ccow->company_name." dinyatakan benar dan tercatat di sistem kami.&chs=180x180&choe=UTF-8&chld=L|2");

        $data = [
            'document_number' => $docNumber,
            'document_revision' => '1.0',
            'document_date' => $now->format('d-m-Y'),
            'document_date_end' => $now->addYear(2)->format('d-m-Y'),

            'ccow' => $bidding->ccow->company_name,
            'company_name' => $bidding->company_name,
            'company_address' => $bidding->address,

            // 'bidding' => $bidding,
            'company_business_entity' => $bidding->business_entity->name,
            'company_license_number' => $bidding->license_number,
            'company_license_date_start' => '-',
            'company_license_date_end' => '-',
            'company_license_suitability' => 'Sesuai',

            'company_service_criteria' => $bidding->service_criteria->value,
            'company_pjo_name' => $bidding->pjo ? $bidding->pjo->name : '-',
            'company_pjo_phone' => $bidding->pjo ? $bidding->pjo->phone : '-',

            'qrcode' => $qrcode,

            // 'q' => $q,
            // 'company_scope_of_business' => $q->scope_of_business,
        ];
        // dd($data);

        $pdfContent = PDF::loadView('csms::livewire.post-bidding.pdf.certificate', ['data' => $data])->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "F-MAC-IMS-08-001 Kuesioner CSMS_rev2.0 - " . $bidding->id . ".pdf"
        );
    }

    public function toPica()
    {
        foreach ($this->bidding->inspection_data as $InspectionData) {

            if (isset($InspectionDataValue)) {

                $InspectionData->label_id = $this->bidding->id;

                if ($this->bidding->inspect_criteria == 'food-hygiene') {
                    if ($InspectionDataValue < 10) {
                        $pica = $this->toPica($this->bidding, $InspectionData, $InspectionDataValue);
                    }
                }

                if ($this->bidding->inspect_criteria == 'workplace' || $this->bidding->inspect_criteria == 'area-maintank' || $this->bidding->inspect_criteria == 'area-jetty') {
                    if ($InspectionDataValue == 'Tidak') {
                        $pica = $this->toPica($this->bidding, $InspectionData, $InspectionDataValue);
                    }
                }

                if ($this->bidding->inspect_criteria == 'k3-apar' || $this->bidding->inspect_criteria == 'k3-apab' || $this->bidding->inspect_criteria == 'k3-hydrant' || $this->bidding->inspect_criteria == 'k3-hose-rail' || $this->bidding->inspect_criteria == 'k3-eye-wash') {
                    if ($InspectionDataValue == 'Tidak Standard' || $InspectionDataValue == 'Tidak Ada' || $InspectionDataValue == 'Warna Demarkasi Pudar' || $InspectionDataValue == 'Perlu Penggantian' || $InspectionDataValue == 'Terdapat Penghalang') {
                        $pica = $this->toPica($this->bidding, $InspectionData, $InspectionDataValue);
                    }
                }

                // END PICA
            }
        }
    }

    public function renewal_bidding()
    {
        try {
            DB::beginTransaction();

            $post_bidding = $this->bidding->replicate();
            $post_bidding->criteria = CsmsStatus::Renewal;
            $post_bidding->parent_id = $this->bidding->id;

            $post_bidding->requested = CsmsStatus::RequestedOHS;
            $post_bidding->published = CsmsStatus::Draft;
            $post_bidding->status = CsmsStatus::OnReviewOHS;

            $post_bidding->push();

            DB::commit();

            $this->flash('success', 'Data berhasil di simpan!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('csms::renewal.create', $post_bidding->id);
        } catch (\Throwable $th) {

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Error',
                'icon' => 'error',
                'text' => $th->getMessage(),
            ]);
        }
    }

    public function inactive_bidding()
    {
        try {
            DB::beginTransaction();

            $this->bidding->criteria = CsmsStatus::Inactive;
            $this->bidding->requested = CsmsStatus::Approved;
            $this->bidding->status = CsmsStatus::Inactive;

            $this->bidding->save();

            DB::commit();

            $this->flash('success', 'Data berhasil di simpan!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('csms::post-bidding.ongoing');
        } catch (\Throwable $th) {

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Error',
                'icon' => 'error',
                'text' => $th->getMessage(),
            ]);
        }
    }

    public function obsolete_bidding()
    {
        try {
            DB::beginTransaction();

            $this->bidding->requested = CsmsStatus::Approved;
            $this->bidding->status = CsmsStatus::Obsolate;

            $this->bidding->save();

            DB::commit();

            $this->flash('success', 'Data berhasil di simpan!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('csms::post-bidding.ongoing');
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
        return view('csms::livewire.post-bidding.detail')->extends('csms::layouts.no-header');
    }
}
