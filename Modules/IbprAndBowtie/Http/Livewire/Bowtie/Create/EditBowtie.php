<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Bowtie\Create;

use App\Enums\CompanyType;
use App\Models\Company;
use App\Models\Department;
use App\Models\IbprBowty\Bowtie;
use App\Models\IbprBowty\BowtieCca;
use App\Models\IbprBowty\BowtieEvent;
use App\Models\IbprBowty\BowtieLossCalculation;
use App\Models\IbprBowty\BowtiePerformanceStandard;
use App\Models\IbprBowty\BowtieTeam;
use App\Models\Section;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class EditBowtie extends Component
{
    public $bowtie;
    public $bowtie_id;
    public $section_id;
    public $readonly = false;
    public $companies = [];
    public $contractors = [];
    public $users = [];
    public $pja = [];
    public $ohs = [];
    public $departments = [];
    public $sections = [];
    public $sub_contractors = [];
    public $risk_title;
    public $open_multiselect = false;
    public $ccow;
    public $ccow_id;
    public $iup;
    public $department_id;
    public $kriteria = 'BOWTIE';
    public $contractor_id;
    public $sub_contractor_id;
    public $pja_id;
    public $ohs_id;
    public $teamsObj = [];
    public $teams = [];
    public $team_names = [];
    public $request_date;
    public $next_date;
    public $document_no;
    public $event = [];
    public $event_id;
    public $cca = [];
    public $performance_standard = [];
    public $lost_callculation = [];
    public $obesrvation;
    public $implementation_test_efectivity;
    public $index_edit = null;
    protected $listeners = [
        'event_formula_level_of_risk' => 'formula_level_of_risk',
        'event_formula_level_of_risk_residual' => 'formula_level_of_risk_residual',
        'event_unset_index_edit' => 'unset_index_edit',
        //'event_ccow_on_change' => 'ccow_on_change',
        'check_event' => 'check_event',
    ];

    public function mount($id)
    {
        $this->bowtie_id = $id;
        $this->ccow = Company::where('type', CompanyType::Internal()->value)->get();

        $this->pja = User::get();
        $this->ohs = User::get();

        $this->cca = BowtieCca::where('bowtie_id', $this->bowtie_id)->get();
        $this->performance_standard = BowtiePerformanceStandard::where('bowtie_id', $this->bowtie_id)->get();
        $this->lost_callculation = BowtieLossCalculation::where('bowtie_id', $this->bowtie_id)->get();

        $this->users = User::get();
        $this->departments = Department::get();
        $this->sections = Section::get();

        $this->bowtie = Bowtie::find($id);
        $this->contractors = Company::where('type', CompanyType::Contractor()->value)->where('parent_company_id', $this->bowtie->ccow_id)->get();

        $this->sub_contractors = Company::where('type', CompanyType::SubContractor()->value)->where('parent_company_id', $this->bowtie->contractor_id)->get();

        $this->ccow_id = $this->bowtie->ccow_id;
        $this->iup = $this->bowtie->iup;
        $this->department_id = $this->bowtie->department_id;
        $this->kriteria = $this->bowtie->kriteria;
        $this->contractor_id = $this->bowtie->contractor_id;
        $this->sub_contractor_id = $this->bowtie->sub_contractor_id;
        $this->pja_id = $this->bowtie->pja_id;
        $this->ohs_id = $this->bowtie->ohs_id;
        $this->teams = array_column($this->bowtie->teams->toArray(), 'user_name');
        $this->risk_title = $this->bowtie->risk_title;
        $this->team_names = implode(',', $this->teams);
        $this->request_date = $this->bowtie->request_date;
        $this->next_date = $this->bowtie->next_date;
        $this->document_no = $this->bowtie->document_no;
        $this->event = $this->bowtie->events;
    }

    public function check_event()
    {
        $this->event = BowtieEvent::where('bowtie_id', $this->bowtie_id)->get();
        $this->cca = BowtieCca::where('bowtie_id', $this->bowtie_id)->get();
        $this->performance_standard = BowtiePerformanceStandard::where('bowtie_id', $this->bowtie_id)->get();
        $this->lost_callculation = BowtieLossCalculation::where('bowtie_id', $this->bowtie_id)->get();
    }

    public function updated()
    {
        DB::beginTransaction();
        $user = User::find(Auth::user()->id);

        $this->bowtie->update([
            'ccow_id' => $this->ccow_id,
            'iup' => $this->iup,
            'department_id' => $user->department_id,
            'kriteria' => $this->kriteria,
            'risk_title' => $this->risk_title,
            'contractor_id' => $this->contractor_id,
            'sub_contractor_id' => $this->sub_contractor_id,
            'pja_id' => $this->pja_id,
            'ohs_id' => $this->ohs_id,
            'request_date' => Carbon::parse($this->request_date)->format('Y-m-d'),
            'next_date' => Carbon::parse($this->next_date)->format('Y-m-d'),
            'document_no' => $this->document_no,
        ]);

        $outputArray = [];
        BowtieTeam::where('bowtie_id', $this->bowtie_id)->delete();
        foreach ($this->teams as $value) {
            if ($value !== '') {

                $outputArray = [
                    'id' => Str::uuid()->toString(),
                    'bowtie_id' => $this->bowtie_id,
                    'user_name' => $value,
                ];
                BowtieTeam::insert($outputArray);
            }
        }
        DB::commit();
    }

    public function updatedCcowId()
    {
        $company = Company::find($this->ccow_id);
        $no_doc = Bowtie::where('ccow_id', '!=', null)->count() + 1;

        $this->contractors = Company::where('type', 'CONTRACTOR')->where('parent_company_id', $this->ccow_id)->get();
        $this->sub_contractors = [];
        $this->contractor_id = null;
        $this->sub_contractor_id = null;

        $this->document_no = 'BT-' . $company->document_code . '-' . Carbon::parse($this->request_date)->format('dmY') . '-' . str_pad($no_doc, 3, '0', STR_PAD_LEFT);
        $this->iup = $company->type;

        $this->bowtie->update([
            'document_no' => $this->document_no
        ]);
    }

    public function updatedContractorId()
    {
        $this->sub_contractors = Company::where('type', 'SUBCONTRACTOR')->where('parent_company_id', $this->contractor_id)->get();
        $this->sub_contractor_id = null;

        $company = Company::find($this->contractor_id);
        $no_doc = Bowtie::where('ccow_id', '!=', null)->count() + 1;

        $this->document_no = 'BT-' . $company->document_code . '-' . Carbon::parse($this->request_date)->format('dmY') . '-' . str_pad($no_doc, 3, '0', STR_PAD_LEFT);
        $this->iup = $company->type;
    }

    public function updatedSubContractorId()
    {
        $company = Company::find($this->sub_contractor_id);
        $no_doc = Bowtie::where('ccow_id', '!=', null)->count() + 1;

        $this->document_no = 'BT-' . $company->document_code . '-' . Carbon::parse($this->request_date)->format('dmY') . '-' . str_pad($no_doc, 3, '0', STR_PAD_LEFT);
        $this->iup = $company->type;
    }

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function rules()
    {
        return [
            'ccow_id' => 'required',
            'iup' => 'required',
            'request_date' => 'required',
            'document_no' => 'required',
        ];
    }

    public function goto_list_ibpr(Request $request)
    {
        DB::beginTransaction();
        try {

            $user = User::find(Auth::user()->id);
            $this->bowtie->update([
                'ccow_id' => $this->ccow_id,
                'iup' => $this->iup,
                'department_id' => $user->department_id,
                'kriteria' => $this->kriteria,
                'risk_title' => $this->risk_title,
                'contractor_id' => $this->contractor_id,
                'sub_contractor_id' => $this->sub_contractor_id,
                'pja_id' => $this->pja_id,
                'ohs_id' => $this->ohs_id,
                'request_date' => Carbon::parse($this->request_date)->format('Y-m-d'),
                'next_date' => Carbon::parse($this->next_date)->format('Y-m-d'),
                'document_no' => $this->document_no,
                'revisi_number' => 0,
                'created_by' => Auth::user()->id,
            ]);

            $outputArray = [];

            BowtieTeam::where('bowtie_id', $this->bowtie_id)->delete();
            foreach ($this->teams as $value) {
                if ($value !== '') {

                    $outputArray = [
                        'id' => Str::uuid()->toString(),
                        'bowtie_id' => $this->bowtie_id,
                        'user_name' => $value,
                    ];
                    BowtieTeam::insert($outputArray);
                }
            }

            DB::commit();

            $request->session()->put('route', '/ibpr-and-bowtie/bowtie/detail/edit/' . $this->bowtie_id);
            return redirect()->route('ibpr-and-bowtie::bowtie.event-list', [$this->bowtie->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }


    public function save_bowtie($status = 'DRAFT')
    {
        DB::beginTransaction();
        try {
            $user = User::find(Auth::user()->id);
            $this->validate();
            $this->bowtie->update([
                'ccow_id' => $this->ccow_id,
                'iup' => $this->iup,
                'department_id' => $user->department_id,
                'kriteria' => $this->kriteria,
                'risk_title' => $this->risk_title,
                'contractor_id' => $this->contractor_id,
                'sub_contractor_id' => $this->sub_contractor_id,
                'pja_id' => $this->pja_id,
                'ohs_id' => $this->ohs_id,
                'request_date' => Carbon::parse($this->request_date)->format('Y-m-d'),
                'next_date' => Carbon::parse($this->next_date)->format('Y-m-d'),
                'document_no' => $this->document_no,
                'revisi_number' => 0,
                'status' => $status,
                'created_by' => Auth::user()->id,
            ]);

            $outputArray = [];
            BowtieTeam::where('bowtie_id', $this->bowtie_id)->delete();
            foreach ($this->teams as $value) {
                if ($value !== '') {

                    $outputArray = [
                        'id' => Str::uuid()->toString(),
                        'bowtie_id' => $this->bowtie_id,
                        'user_name' => $value,
                    ];
                    BowtieTeam::insert($outputArray);
                }
            }

            DB::commit();
            return redirect()->route('ibpr-and-bowtie::bowtie.detail-bowtie', [$this->bowtie->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function update_bowtie()
    {
        DB::beginTransaction();
        try {
            $user = User::find(Auth::user()->id);
            $this->validate();
            $this->bowtie->update([
                'ccow_id' => $this->ccow_id,
                'iup' => $this->iup,
                'department_id' => $user->department_id,
                'kriteria' => $this->kriteria,
                'contractor_id' => $this->contractor_id,
                'risk_title' => $this->risk_title,
                'sub_contractor_id' => $this->sub_contractor_id,
                'pja_id' => $this->pja_id,
                'ohs_id' => $this->ohs_id,
                'request_date' => Carbon::parse($this->request_date)->format('Y-m-d'),
                'next_date' => Carbon::parse($this->next_date)->format('Y-m-d'),
                'document_no' => $this->document_no,
                'revisi_number' => 0,
                'created_by' => Auth::user()->id,
            ]);

            $outputArray = [];
            BowtieTeam::where('bowtie_id', $this->bowtie_id)->delete();
            foreach ($this->teams as $value) {
                if ($value != '' && $value != 0) {
                    $outputArray = [
                        'id' => Str::uuid()->toString(),
                        'bowtie_id' => $this->bowtie_id,
                        'user_name' => $value,
                    ];
                    BowtieTeam::insert($outputArray);
                }
            }

            DB::commit();
            return redirect()->route('ibpr-and-bowtie::bowtie.detail-bowtie', [$this->bowtie->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function change_teams($id, $name)
    {
        if (in_array($id, $this->teams)) {
            $this->teams = array_values(array_diff($this->teams, [$id]));
            $this->team_names = array_values(array_diff($this->team_names, [$name]));
        } else {
            $this->teams[] = $id;
            $this->team_names[] = $name;
        }
    }

    public function toggle_multi_select()
    {
        $this->open_multiselect = !$this->open_multiselect;
    }

    public function cancel()
    {
        $this->bowtie->delete();
        // return redirect()->route('bowtie-and-bowtie::bowtie.active.list-active-bowtie-and-bowtie');
    }

    public function render()
    {

        return view('ibprandbowtie::livewire.ibpr-and-bowtie.bowtie.create.edit')->extends('ibprandbowtie::layouts.no-header');;
    }


    public function goto_list_cca(Request $request)
    {
        $request->session()->put('route', '/ibpr-and-bowtie/bowtie/detail/edit/' . $this->bowtie_id);

        return redirect()->route('ibpr-and-bowtie::bowtie.cca-list', [$this->bowtie_id]);
    }

    public function goto_list_performance(Request $request)
    {
        $request->session()->put('route', '/ibpr-and-bowtie/bowtie/detail/edit/' . $this->bowtie_id);

        return redirect()->route('ibpr-and-bowtie::bowtie.perpormnace-standard-list', [$this->bowtie_id]);
    }

    public function goto_list_lost_callculation(Request $request)
    {
        $request->session()->put('route', '/ibpr-and-bowtie/bowtie/detail/edit/' . $this->bowtie_id);

        return redirect()->route('ibpr-and-bowtie::bowtie.lost-callculation-list', [$this->bowtie_id]);
    }
}
