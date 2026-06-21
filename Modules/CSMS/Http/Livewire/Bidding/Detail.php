<?php

namespace Modules\CSMS\Http\Livewire\Bidding;

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
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Detail extends Component
{
    use LivewireAlert;
    public Bidding $bidding;
    public $created_at, $updated_at, $criteria, $ccow_id, $business_entity_id, $company_name, $address, $company_site, $license_number, $service_criteria, $company_id, $person_in_charge;
    public $maker;


    protected $listeners = [
        'refreshComponent' => '$refresh',
    ];

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

        foreach ($bidding->checklists as $v) {
            $this->{'checklist_csms_value_' . $v->question_id} = $v->value;
            $this->{'checklist_csms_file_' . $v->question_id} = null;
            $this->{'checklist_csms_note_' . $v->question_id} = $v->comment;
            $this->{'files_data_' . $v->question_id} = [];
            $this->{'oldFiles_' . $v->question_id} = $v->files;
        }
    }

    public function downloadFile($id)
    {
        $file = CsmsChecklistAttacment::findOrFail($id);

        // Check if the file exists in the storage
        $check = Storage::disk('public')->exists($file->file);
        if ($check) {
            return response()->download(storage_path('app/public/' . $file->file));
        } else {
            return abort(404);
        }
    }

    public function approve($status, $requested)
    {
        DB::beginTransaction();
        $this->bidding->status = $status;
        $this->bidding->requested = $requested;
        // $this->bidding->published = CsmsStatus::Publish;
        $this->bidding->save();

        // dd($this->bidding);
        // $this->toPica();
        DB::commit();

        $this->flash('success', 'Data berhasil di simpan!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);

        redirect()->route('csms::approval.bidding');
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

        redirect()->route('csms::approval.bidding');
    }

    public function backoffice_sync()
    {
        DB::beginTransaction();

        $document_code = NULL;
        $email = '' . preg_replace('/\s+/', '', strtolower($this->company_name)) . '@gmail.com';
        $phone_number = '123456789';

        $cc = Company::create([
            'company_name' => $this->company_name,
            'document_code' => $document_code,
            'address' => $this->address,
            'email' => $email,
            'phone_number' => $phone_number,
            'type' => $this->service_criteria->value,
            'parent_company_id' => $this->ccow_id,
        ]);

        $this->bidding->company_id = $cc->id;
        $this->bidding->save();
        $this->company_id = $cc->id;

        // dd($cc);

        DB::commit();

        $this->alert('success', 'Data berhasil di simpan ke Back Office!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);

        $this->emit('refreshComponent');

        // redirect()->route('csms::approval.bidding');
    }

    public function getSyncStatusProperty()
    {
        if ($this->bidding->status->value !== CsmsStatus::Approved) {
            return false;
        }

        $company = Company::where('company_name', $this->company_name)->count();


        return ($company) ? FALSE : TRUE;
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

    public function render()
    {
        return view('csms::livewire.bidding.detail')->extends('csms::layouts.no-header');
    }
}
