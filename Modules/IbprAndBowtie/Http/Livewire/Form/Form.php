<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Form;

use App\Enums\CompanyType;
use App\Models\Company;
use App\Models\Department;
use App\Models\IbprBowty\Bowtie;
use App\Models\IbprBowty\Ibpr;
use App\Models\IbprBowty\IbprForm;
use App\Models\IbprBowty\IbprFormBowtie;
use App\Models\IbprBowty\IbprMasterBahaya;
use App\Models\IbprBowty\IbprMasterHirarki;
use App\Models\IbprBowty\IbprTeam;
use App\Models\IbprBowty\Pica;
use App\Models\Section;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

// use Illuminate\Support\Facades\DB;

class Form extends Component
{
    protected $listeners = [
        'event_formula_level_of_risk' => 'formula_level_of_risk',
        'event_formula_level_of_risk_residual' => 'formula_level_of_risk_residual',
        'event_unset_index_edit' => 'unset_index_edit',
        'event_ccow_on_change' => 'ccow_on_change',
    ];

    public $ibpr;
    public $ibpr_id;
    public $section_id;
    public $readonly = false;
    public $companies = [];
    public $contractors = [];
    public $users = [];
    public $pja = [];
    public $pjo = [];
    public $pjs = [];
    public $departments = [];
    public $sections = [];
    public $sub_contractors = [];

    public $open_multiselect = false;

    public $ccow;
    public $ccow_id;
    public $iup;
    public $department_id;
    public $kriteria = 'IBPR';
    public $contractor_id;
    public $sub_contractor_id;
    public $pjs_id;
    public $pja_id;
    public $pjo_id;
    public $teamsObj = [];
    public $teams = [];
    public $team_names = [];
    public $request_date;
    public $next_date;
    public $document_no;
    public $form = [];

    public $activity;
    public $sub_activity;
    public $kondition;
    public $safety;
    public $incident_risk;
    public $safety_opportunity;
    public $relevant_legislation;
    public $preliminary_consequence_k3;
    public $preliminary_consequence_lh;
    public $preliminary_consequence_kp;
    public $preliminary_consequence_ksl;
    public $preliminary_consequence_kk;
    public $preliminary_frequence;
    public $preliminary_level_of_risk;
    public $preliminary_level_of_risk_label;
    public $preliminary_main_risk;
    public $modal_of_current;
    public $modal_of_current_arr = [];
    public $note;
    public $effective_control;
    public $residual_consequence_k3;
    public $residual_consequence_lh;
    public $residual_consequence_kp;
    public $residual_consequence_ksl;
    public $residual_consequence_kk;
    public $residual_frequence;
    public $residual_level_of_risk;
    public $residual_level_of_risk_label;
    public $residual_main_risk;
    public $follow_risk;
    public $notes = [];

    public $index_edit = null;
    public $bowtie = [];
    public $ibprHirarki = [];
    public $ibprBahaya = [];

    public $risk_titles = [
        [
            'name' => ''
        ],
    ];

    public function mount()
    {
        $this->ccow = Company::where('type', CompanyType::Internal()->value)->get();

        $this->pja = User::all();
        $this->pjo = User::all();
        $this->pjs = User::all();
        $this->users = User::get();
        $this->departments = Department::get();
        $this->sections = Section::get();

        $this->bowtie = Bowtie::whereIn('status', ['Disetujui', 'Temporary'])->get();
        $this->ibprHirarki = IbprMasterHirarki::all();
        $this->ibprBahaya = IbprMasterBahaya::all();

        $this->ibpr = Ibpr::create();
        $this->ibpr_id = $this->ibpr->id;
    }

    public function onSelect($index, $event)
    {
        if ($event !== 'Select') {
            $this->risk_titles[$index]['name'] = $event;
            $this->risk_titles[] = [
                'name' => ''
            ];
        } else {
            if (count($this->risk_titles) > 1) {
                unset($this->risk_titles[$index]);
            }
        }
    }

    public function updatedCcowId()
    {
        $company = Company::find($this->ccow_id);
        $no_doc = Ibpr::where('ccow_id', '!=', null)->count() + 1;

        $this->contractors = Company::where('type', 'CONTRACTOR')->where('parent_company_id', $this->ccow_id)->get();
        $this->sub_contractors = [];
        $this->contractor_id = null;
        $this->sub_contractor_id = null;

        $this->document_no = $company->document_code . '-' . Carbon::parse($this->request_date)->format('dmY') . '-' . str_pad($no_doc, 6, '0', STR_PAD_LEFT);
        $this->iup = $company->type;
    }

    public function updatedContractorId()
    {
        $this->sub_contractors = Company::where('type', 'SUBCONTRACTOR')->where('parent_company_id', $this->contractor_id)->get();
        $this->sub_contractor_id = null;

        $company = Company::find($this->contractor_id);
        $no_doc = Ibpr::where('ccow_id', '!=', null)->count() + 1;

        $this->document_no = $company->document_code . '-' . Carbon::parse($this->request_date)->format('dmY') . '-' . str_pad($no_doc, 6, '0', STR_PAD_LEFT);
        $this->iup = $company->type;
    }

    public function updatedSubContractorId()
    {
        $company = Company::find($this->sub_contractor_id);
        $no_doc = Ibpr::where('ccow_id', '!=', null)->count() + 1;

        $this->document_no = $company->document_code . '-' . Carbon::parse($this->request_date)->format('dmY') . '-' . str_pad($no_doc, 6, '0', STR_PAD_LEFT);
        $this->iup = $company->type;
    }

    public function hydrate()
    {
        $this->emit('select2');
        $this->emit('loadSelect2Hydrate');
    }

    public function push_form()
    {
        $rules = [
            'activity' => 'required',
            'sub_activity' => 'required',
            'kondition' => 'required',
            'safety' => 'required',
            'incident_risk' => 'required',
            'relevant_legislation' => 'required',
//            'preliminary_consequence_k3' => 'required',
//            'preliminary_consequence_kp' => 'required',
//            'preliminary_consequence_ksl' => 'required',
//            'preliminary_consequence_kk' => 'required',
            'preliminary_frequence' => 'required',
            'preliminary_level_of_risk' => 'required',
            'preliminary_main_risk' => 'required',
//            'effective_control' => 'required',
//            'residual_consequence_k3' => 'required',
//            'residual_consequence_kp' => 'required',
//            'residual_consequence_ksl' => 'required',
//            'residual_consequence_kk' => 'required',
//            'residual_frequence' => 'required',
//            'residual_level_of_risk' => 'required',
//            'residual_main_risk' => 'required',
//            'follow_risk' => 'required',
        ];

        $messages = [
            'activity' => 'activity required',
            'sub_activity' => 'sub_activity required',
            'kondition' => 'kondition required',
            'safety' => 'safety required',
            'incident_risk' => 'incident_risk required',
            'relevant_legislation' => 'relevant_legislation required',
            'preliminary_consequence_k3' => 'required',
            'preliminary_consequence_kp' => 'required',
            'preliminary_consequence_ksl' => 'required',
            'preliminary_consequence_kk' => 'required',
            'preliminary_frequence' => 'preliminary_frequence required',
            'preliminary_level_of_risk' => 'preliminary_level_of_risk required',
            'preliminary_main_risk' => 'preliminary_main_risk required',
            'effective_control' => 'effective_control required',
            'residual_consequence_k3' => 'residual_consequence_k3 required',
            'residual_consequence_kp' => 'residual_consequence_kp required',
            'residual_consequence_ksl' => 'residual_consequence_ksl required',
            'residual_consequence_kk' => 'residual_consequence_kk required',
            'residual_frequence' => 'residual_frequence required',
            'residual_level_of_risk' => 'residual_level_of_risk required',
            'residual_main_risk' => 'residual_main_risk required',
            'follow_risk' => 'follow_risk required',
        ];


        $this->validate($rules, $messages);
        try {
            DB::beginTransaction();

            $object = [
                'ibpr_id' => $this->ibpr_id,
                'activity' => $this->activity,
                'sub_activity' => $this->sub_activity,
                'kondition' => $this->kondition,
                'safety' => $this->safety,
                'incident_risk' => $this->incident_risk,
                'safety_opportunity' => $this->safety_opportunity,
                'relevant_legislation' => $this->relevant_legislation,
                'preliminary_consequence_k3' => $this->preliminary_consequence_k3,
                'preliminary_consequence_kp' => $this->preliminary_consequence_kp,
                'preliminary_consequence_ksl' => $this->preliminary_consequence_ksl,
                'preliminary_consequence_kk' => $this->preliminary_consequence_kk,
                'preliminary_frequence' => $this->preliminary_frequence,
                'preliminary_level_of_risk' => $this->preliminary_level_of_risk,
                'preliminary_main_risk' => $this->preliminary_main_risk,
                'modal_of_current' => $this->modal_of_current,
                'effective_control' => $this->effective_control,
                'residual_consequence_k3' => $this->residual_consequence_k3,
                'residual_consequence_kp' => $this->residual_consequence_kp,
                'residual_consequence_ksl' => $this->residual_consequence_ksl,
                'residual_consequence_kk' => $this->residual_consequence_kk,
                'residual_frequence' => $this->residual_frequence,
                'residual_level_of_risk' => $this->residual_level_of_risk,
                'residual_main_risk' => $this->residual_main_risk,
                'follow_risk' => $this->follow_risk,
            ];

            if (!is_null($this->index_edit)) {
                $this->form[$this->index_edit] = $object;
            } else {
                $createFormIbpr = IbprForm::create($object);

                $risk_titles = array_filter($this->risk_titles, function ($title) {
                    return $title['name'] !== '';
                });

                foreach ($risk_titles as $key => $risk_title) {
                    $bowtie = Bowtie::where('risk_title', $risk_title['name'])->first();

                    $risk = IbprFormBowtie::create([
                        'form_id' => $createFormIbpr->id,
                        'name' => $risk_title['name'],
                        'note' => $this->notes[$key] ?? null,
                        'bowtie_id' => $bowtie->id ?? null
                    ]);

                    if ($this->preliminary_level_of_risk === 'H') {
                        $pica = Pica::create([
                            'ibpr_form_id' => $createFormIbpr->id,
                            'ibpr_form_risk_id' => $risk->id,
                            'status' => 'Open'
                        ]);
                    }
                }
            }

            // Clear the temporary variable
            $this->activity = '';
            $this->sub_activity = '';
            $this->safety = '';
            $this->kondition = '';
            $this->incident_risk = '';
            $this->safety_opportunity = '';
            $this->relevant_legislation = '';
            $this->preliminary_consequence_k3 = null;
            $this->preliminary_consequence_kp = null;
            $this->preliminary_consequence_ksl = null;
            $this->preliminary_consequence_kk = null;
            $this->preliminary_frequence = null;
            $this->preliminary_level_of_risk = null;
            $this->preliminary_main_risk = null;
            $this->modal_of_current = '';
            $this->effective_control = '';
            $this->residual_consequence_k3 = null;
            $this->residual_consequence_kp = null;
            $this->residual_consequence_ksl = null;
            $this->residual_consequence_kk = null;
            $this->residual_frequence = null;
            $this->residual_level_of_risk = null;
            $this->residual_main_risk = null;
            $this->follow_risk = '';

            $this->form = IbprForm::where('ibpr_id', $this->ibpr_id)->get();

            DB::commit();
            $this->emit('closeModal');
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function unset_index_edit()
    {
        $this->index_edit = null;
    }

    public function open_modal_edit($index)
    {
        $this->index_edit = $index;
        $form_ibpr = $this->form[$index];

        $this->activity = $form_ibpr['activity'];
        $this->sub_activity = $form_ibpr['sub_activity'];
        $this->safety = $form_ibpr['safety'];
        $this->kondition = $form_ibpr['kondition'];
        $this->incident_risk = $form_ibpr['incident_risk'];
        $this->safety_opportunity = $form_ibpr['safety_opportunity'];
        $this->relevant_legislation = $form_ibpr['relevant_legislation'];
        $this->preliminary_consequence_k3 = $form_ibpr['preliminary_consequence_k3'];
        $this->preliminary_consequence_kp = $form_ibpr['preliminary_consequence_kp'];
        $this->preliminary_consequence_ksl = $form_ibpr['preliminary_consequence_ksl'];
        $this->preliminary_consequence_kk = $form_ibpr['preliminary_consequence_kk'];
        $this->preliminary_frequence = $form_ibpr['preliminary_frequence'];
        $this->preliminary_level_of_risk = $form_ibpr['preliminary_level_of_risk'];
        $this->preliminary_main_risk = $form_ibpr['preliminary_main_risk'];
        $this->modal_of_current = $form_ibpr['modal_of_current'];
        $this->effective_control = $form_ibpr['effective_control'];
        $this->residual_consequence_k3 = $form_ibpr['residual_consequence_k3'];
        $this->residual_consequence_kp = $form_ibpr['residual_consequence_kp'];
        $this->residual_consequence_ksl = $form_ibpr['residual_consequence_ksl'];
        $this->residual_consequence_kk = $form_ibpr['residual_consequence_kk'];
        $this->residual_frequence = $form_ibpr['residual_frequence'];
        $this->residual_level_of_risk = $form_ibpr['residual_level_of_risk'];
        $this->residual_main_risk = $form_ibpr['residual_main_risk'];
        $this->follow_risk = $form_ibpr['follow_risk'];

        $this->emit('openModal');
    }

    public function delete_form($index)
    {
        unset($this->form[$index]);
    }

    public function change_consequences($value, $type)
    {
        if ($type === 'preliminary_consequence_k3') $this->preliminary_consequence_k3 = $value;
        if ($type === 'preliminary_consequence_kp') $this->preliminary_consequence_kp = $value;
        if ($type === 'preliminary_consequence_ksl') $this->preliminary_consequence_ksl = $value;
        if ($type === 'preliminary_consequence_kk') $this->preliminary_consequence_kk = $value;
        if ($type === 'residual_consequence_k3') $this->residual_consequence_k3 = $value;
        if ($type === 'residual_consequence_kp') $this->residual_consequence_kp = $value;
        if ($type === 'residual_consequence_ksl') $this->residual_consequence_ksl = $value;
        if ($type === 'residual_consequence_kk') $this->residual_consequence_kk = $value;

        $arr_preliminary = [$this->preliminary_consequence_k3, $this->preliminary_consequence_kp, $this->preliminary_consequence_ksl, $this->preliminary_consequence_kk];
        $max_preliminary = max($arr_preliminary);

        $arr_residual = [$this->residual_consequence_k3, $this->residual_consequence_kp, $this->residual_consequence_ksl, $this->residual_consequence_kk];
        $max_residual = max($arr_residual);

        if ($this->preliminary_frequence !== '' && $max_preliminary) {
            if ($this->preliminary_frequence === 'A' && $max_preliminary === 1) $this->preliminary_level_of_risk = 'M';
            if ($this->preliminary_frequence === 'A' && $max_preliminary === 2) $this->preliminary_level_of_risk = 'H';
            if ($this->preliminary_frequence === 'A' && $max_preliminary === 3) $this->preliminary_level_of_risk = 'H';
            if ($this->preliminary_frequence === 'A' && $max_preliminary === 4) $this->preliminary_level_of_risk = 'C';
            if ($this->preliminary_frequence === 'A' && $max_preliminary === 5) $this->preliminary_level_of_risk = 'C';

            if ($this->preliminary_frequence === 'B' && $max_preliminary === 1) $this->preliminary_level_of_risk = 'M';
            if ($this->preliminary_frequence === 'B' && $max_preliminary === 2) $this->preliminary_level_of_risk = 'M';
            if ($this->preliminary_frequence === 'B' && $max_preliminary === 3) $this->preliminary_level_of_risk = 'H';
            if ($this->preliminary_frequence === 'B' && $max_preliminary === 4) $this->preliminary_level_of_risk = 'H';
            if ($this->preliminary_frequence === 'B' && $max_preliminary === 5) $this->preliminary_level_of_risk = 'C';

            if ($this->preliminary_frequence === 'C' && $max_preliminary === 1) $this->preliminary_level_of_risk = 'L';
            if ($this->preliminary_frequence === 'C' && $max_preliminary === 2) $this->preliminary_level_of_risk = 'M';
            if ($this->preliminary_frequence === 'C' && $max_preliminary === 3) $this->preliminary_level_of_risk = 'H';
            if ($this->preliminary_frequence === 'C' && $max_preliminary === 4) $this->preliminary_level_of_risk = 'H';
            if ($this->preliminary_frequence === 'C' && $max_preliminary === 5) $this->preliminary_level_of_risk = 'C';

            if ($this->preliminary_frequence === 'D' && $max_preliminary === 1) $this->preliminary_level_of_risk = 'L';
            if ($this->preliminary_frequence === 'D' && $max_preliminary === 2) $this->preliminary_level_of_risk = 'L';
            if ($this->preliminary_frequence === 'D' && $max_preliminary === 3) $this->preliminary_level_of_risk = 'M';
            if ($this->preliminary_frequence === 'D' && $max_preliminary === 4) $this->preliminary_level_of_risk = 'M';
            if ($this->preliminary_frequence === 'D' && $max_preliminary === 5) $this->preliminary_level_of_risk = 'H';

            if ($this->preliminary_frequence === 'H' && $max_preliminary === 1) $this->preliminary_level_of_risk = 'L';
            if ($this->preliminary_frequence === 'H' && $max_preliminary === 2) $this->preliminary_level_of_risk = 'L';
            if ($this->preliminary_frequence === 'H' && $max_preliminary === 3) $this->preliminary_level_of_risk = 'M';
            if ($this->preliminary_frequence === 'H' && $max_preliminary === 4) $this->preliminary_level_of_risk = 'M';
            if ($this->preliminary_frequence === 'H' && $max_preliminary === 5) $this->preliminary_level_of_risk = 'H';

            if ($this->preliminary_level_of_risk === 'C') $this->preliminary_level_of_risk_label = 'C (Tingkat Risiko Kritikal)';
            if ($this->preliminary_level_of_risk === 'H') $this->preliminary_level_of_risk_label = 'H (Tingkat Risiko Tinggi)';
            if ($this->preliminary_level_of_risk === 'M') $this->preliminary_level_of_risk_label = 'M (Tingkat Risiko Menengah)';
            if ($this->preliminary_level_of_risk === 'L') $this->preliminary_level_of_risk_label = 'L (Tingkat Risiko Rendah)';
        }

        if ($this->residual_frequence !== '' && $max_residual) {
            if ($this->residual_frequence === 'A' && $max_residual === 1) $this->residual_level_of_risk = 'M';
            if ($this->residual_frequence === 'A' && $max_residual === 2) $this->residual_level_of_risk = 'H';
            if ($this->residual_frequence === 'A' && $max_residual === 3) $this->residual_level_of_risk = 'H';
            if ($this->residual_frequence === 'A' && $max_residual === 4) $this->residual_level_of_risk = 'C';
            if ($this->residual_frequence === 'A' && $max_residual === 5) $this->residual_level_of_risk = 'C';

            if ($this->residual_frequence === 'B' && $max_residual === 1) $this->residual_level_of_risk = 'M';
            if ($this->residual_frequence === 'B' && $max_residual === 2) $this->residual_level_of_risk = 'M';
            if ($this->residual_frequence === 'B' && $max_residual === 3) $this->residual_level_of_risk = 'H';
            if ($this->residual_frequence === 'B' && $max_residual === 4) $this->residual_level_of_risk = 'H';
            if ($this->residual_frequence === 'B' && $max_residual === 5) $this->residual_level_of_risk = 'C';

            if ($this->residual_frequence === 'C' && $max_residual === 1) $this->residual_level_of_risk = 'L';
            if ($this->residual_frequence === 'C' && $max_residual === 2) $this->residual_level_of_risk = 'M';
            if ($this->residual_frequence === 'C' && $max_residual === 3) $this->residual_level_of_risk = 'H';
            if ($this->residual_frequence === 'C' && $max_residual === 4) $this->residual_level_of_risk = 'H';
            if ($this->residual_frequence === 'C' && $max_residual === 5) $this->residual_level_of_risk = 'C';

            if ($this->residual_frequence === 'D' && $max_residual === 1) $this->residual_level_of_risk = 'L';
            if ($this->residual_frequence === 'D' && $max_residual === 2) $this->residual_level_of_risk = 'L';
            if ($this->residual_frequence === 'D' && $max_residual === 3) $this->residual_level_of_risk = 'M';
            if ($this->residual_frequence === 'D' && $max_residual === 4) $this->residual_level_of_risk = 'M';
            if ($this->residual_frequence === 'D' && $max_residual === 5) $this->residual_level_of_risk = 'H';

            if ($this->residual_frequence === 'H' && $max_residual === 1) $this->residual_level_of_risk = 'L';
            if ($this->residual_frequence === 'H' && $max_residual === 2) $this->residual_level_of_risk = 'L';
            if ($this->residual_frequence === 'H' && $max_residual === 3) $this->residual_level_of_risk = 'M';
            if ($this->residual_frequence === 'H' && $max_residual === 4) $this->residual_level_of_risk = 'M';
            if ($this->residual_frequence === 'H' && $max_residual === 5) $this->residual_level_of_risk = 'H';

            if ($this->residual_level_of_risk === 'C') $this->residual_level_of_risk_label = 'C (Tingkat Risiko Kritikal)';
            if ($this->residual_level_of_risk === 'H') $this->residual_level_of_risk_label = 'H (Tingkat Risiko Tinggi)';
            if ($this->residual_level_of_risk === 'M') $this->residual_level_of_risk_label = 'M (Tingkat Risiko Menengah)';
            if ($this->residual_level_of_risk === 'L') $this->residual_level_of_risk_label = 'L (Tingkat Risiko Rendah)';
        }

        if ($this->preliminary_level_of_risk !== '' && $this->preliminary_level_of_risk === 'C') {
            $this->preliminary_main_risk = 'Ya';
            $this->emit('chooseModaelOfCurrent', 'Ya');
        }
        if ($this->preliminary_level_of_risk !== '' && $this->preliminary_level_of_risk !== 'C') {
            $this->preliminary_main_risk = 'Tidak';
            $this->emit('chooseModaelOfCurrent', 'Tidak');
        }

        if ($this->residual_level_of_risk !== '' && $this->residual_level_of_risk === 'C') {
            $this->residual_main_risk = 'Ya';
            $this->emit('chooseModaelOfCurrent', 'Ya');
        }
        if ($this->residual_level_of_risk !== '' && $this->residual_level_of_risk !== 'C') {
            $this->residual_main_risk = 'Tidak';
            $this->emit('chooseModaelOfCurrent', 'Tidak');
        }

        $this->emit('closeAllToooltip');
        $this->emit('chooseModaelOfCurrent');
    }

    public function formula_level_of_risk($preliminary_frequence)
    {
        $arr_preliminary = [$this->preliminary_consequence_k3, $this->preliminary_consequence_kp, $this->preliminary_consequence_ksl, $this->preliminary_consequence_kk];
        $max_preliminary = max($arr_preliminary);

        if ($this->preliminary_frequence !== '' && $max_preliminary) {
            if ($preliminary_frequence === 'A' && $max_preliminary === 1) $this->preliminary_level_of_risk = 'M';
            if ($preliminary_frequence === 'A' && $max_preliminary === 2) $this->preliminary_level_of_risk = 'H';
            if ($preliminary_frequence === 'A' && $max_preliminary === 3) $this->preliminary_level_of_risk = 'H';
            if ($preliminary_frequence === 'A' && $max_preliminary === 4) $this->preliminary_level_of_risk = 'C';
            if ($preliminary_frequence === 'A' && $max_preliminary === 5) $this->preliminary_level_of_risk = 'C';

            if ($preliminary_frequence === 'B' && $max_preliminary === 1) $this->preliminary_level_of_risk = 'M';
            if ($preliminary_frequence === 'B' && $max_preliminary === 2) $this->preliminary_level_of_risk = 'M';
            if ($preliminary_frequence === 'B' && $max_preliminary === 3) $this->preliminary_level_of_risk = 'H';
            if ($preliminary_frequence === 'B' && $max_preliminary === 4) $this->preliminary_level_of_risk = 'H';
            if ($preliminary_frequence === 'B' && $max_preliminary === 5) $this->preliminary_level_of_risk = 'C';

            if ($preliminary_frequence === 'C' && $max_preliminary === 1) $this->preliminary_level_of_risk = 'L';
            if ($preliminary_frequence === 'C' && $max_preliminary === 2) $this->preliminary_level_of_risk = 'M';
            if ($preliminary_frequence === 'C' && $max_preliminary === 3) $this->preliminary_level_of_risk = 'H';
            if ($preliminary_frequence === 'C' && $max_preliminary === 4) $this->preliminary_level_of_risk = 'H';
            if ($preliminary_frequence === 'C' && $max_preliminary === 5) $this->preliminary_level_of_risk = 'C';

            if ($preliminary_frequence === 'D' && $max_preliminary === 1) $this->preliminary_level_of_risk = 'L';
            if ($preliminary_frequence === 'D' && $max_preliminary === 2) $this->preliminary_level_of_risk = 'L';
            if ($preliminary_frequence === 'D' && $max_preliminary === 3) $this->preliminary_level_of_risk = 'M';
            if ($preliminary_frequence === 'D' && $max_preliminary === 4) $this->preliminary_level_of_risk = 'M';
            if ($preliminary_frequence === 'D' && $max_preliminary === 5) $this->preliminary_level_of_risk = 'H';

            if ($preliminary_frequence === 'E' && $max_preliminary === 1) $this->preliminary_level_of_risk = 'L';
            if ($preliminary_frequence === 'E' && $max_preliminary === 2) $this->preliminary_level_of_risk = 'L';
            if ($preliminary_frequence === 'E' && $max_preliminary === 3) $this->preliminary_level_of_risk = 'M';
            if ($preliminary_frequence === 'E' && $max_preliminary === 4) $this->preliminary_level_of_risk = 'M';
            if ($preliminary_frequence === 'E' && $max_preliminary === 5) $this->preliminary_level_of_risk = 'H';

            if ($this->preliminary_level_of_risk === 'C') $this->preliminary_level_of_risk_label = 'C (Tingkat Risiko Kritikal)';
            if ($this->preliminary_level_of_risk === 'H') $this->preliminary_level_of_risk_label = 'H (Tingkat Risiko Tinggi)';
            if ($this->preliminary_level_of_risk === 'M') $this->preliminary_level_of_risk_label = 'M (Tingkat Risiko Menengah)';
            if ($this->preliminary_level_of_risk === 'L') $this->preliminary_level_of_risk_label = 'L (Tingkat Risiko Rendah)';
        }

        if ($this->preliminary_level_of_risk !== '' && $this->preliminary_level_of_risk === 'C') {
            $this->preliminary_main_risk = 'Ya';
            $this->emit('chooseModaelOfCurrent', 'Ya');
        }
        if ($this->preliminary_level_of_risk !== '' && $this->preliminary_level_of_risk !== 'C') {
            $this->preliminary_main_risk = 'Tidak';
            $this->emit('chooseModaelOfCurrent', 'Tidak');
        }
    }

    public function formula_level_of_risk_residual($residual_frequence)
    {
        $arr_residual = [$this->residual_consequence_k3, $this->residual_consequence_kp, $this->residual_consequence_ksl, $this->residual_consequence_kk];
        $max_residual = max($arr_residual);

        if ($this->residual_frequence !== '' && $max_residual) {
            if ($residual_frequence === 'A' && $max_residual === 1) $this->residual_level_of_risk = 'M';
            if ($residual_frequence === 'A' && $max_residual === 2) $this->residual_level_of_risk = 'H';
            if ($residual_frequence === 'A' && $max_residual === 3) $this->residual_level_of_risk = 'H';
            if ($residual_frequence === 'A' && $max_residual === 4) $this->residual_level_of_risk = 'C';
            if ($residual_frequence === 'A' && $max_residual === 5) $this->residual_level_of_risk = 'C';

            if ($residual_frequence === 'B' && $max_residual === 1) $this->residual_level_of_risk = 'M';
            if ($residual_frequence === 'B' && $max_residual === 2) $this->residual_level_of_risk = 'M';
            if ($residual_frequence === 'B' && $max_residual === 3) $this->residual_level_of_risk = 'H';
            if ($residual_frequence === 'B' && $max_residual === 4) $this->residual_level_of_risk = 'H';
            if ($residual_frequence === 'B' && $max_residual === 5) $this->residual_level_of_risk = 'C';

            if ($residual_frequence === 'C' && $max_residual === 1) $this->residual_level_of_risk = 'L';
            if ($residual_frequence === 'C' && $max_residual === 2) $this->residual_level_of_risk = 'M';
            if ($residual_frequence === 'C' && $max_residual === 3) $this->residual_level_of_risk = 'H';
            if ($residual_frequence === 'C' && $max_residual === 4) $this->residual_level_of_risk = 'H';
            if ($residual_frequence === 'C' && $max_residual === 5) $this->residual_level_of_risk = 'C';

            if ($residual_frequence === 'D' && $max_residual === 1) $this->residual_level_of_risk = 'L';
            if ($residual_frequence === 'D' && $max_residual === 2) $this->residual_level_of_risk = 'L';
            if ($residual_frequence === 'D' && $max_residual === 3) $this->residual_level_of_risk = 'M';
            if ($residual_frequence === 'D' && $max_residual === 4) $this->residual_level_of_risk = 'M';
            if ($residual_frequence === 'D' && $max_residual === 5) $this->residual_level_of_risk = 'H';

            if ($residual_frequence === 'E' && $max_residual === 1) $this->residual_level_of_risk = 'L';
            if ($residual_frequence === 'E' && $max_residual === 2) $this->residual_level_of_risk = 'L';
            if ($residual_frequence === 'E' && $max_residual === 3) $this->residual_level_of_risk = 'M';
            if ($residual_frequence === 'E' && $max_residual === 4) $this->residual_level_of_risk = 'M';
            if ($residual_frequence === 'E' && $max_residual === 5) $this->residual_level_of_risk = 'H';

            if ($this->residual_level_of_risk === 'C') $this->residual_level_of_risk_label = 'C (Tingkat Risiko Kritikal)';
            if ($this->residual_level_of_risk === 'H') $this->residual_level_of_risk_label = 'H (Tingkat Risiko Tinggi)';
            if ($this->residual_level_of_risk === 'M') $this->residual_level_of_risk_label = 'M (Tingkat Risiko Menengah)';
            if ($this->residual_level_of_risk === 'L') $this->residual_level_of_risk_label = 'L (Tingkat Risiko Rendah)';
        }

        if ($this->residual_level_of_risk !== '' && $this->residual_level_of_risk === 'C') {
            $this->residual_main_risk = 'Ya';
        }
        if ($this->residual_level_of_risk !== '' && $this->residual_level_of_risk !== 'C') {
            $this->residual_main_risk = 'Tidak';
        }
    }

    public function rules()
    {
        return [
            'ccow_id' => 'required',
            'iup' => 'required',
            'department_id' => 'required',
            'section_id' => 'required',
            'kriteria' => 'required',
            'request_date' => 'required',
            'document_no' => 'required',
        ];
    }

    public function goto_list_ibpr(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->validate();
            $this->ibpr->update([
                'ccow_id' => $this->ccow_id,
                'iup' => $this->iup,
                'department_id' => $this->department_id,
                'section_id' => $this->section_id,
                'kriteria' => $this->kriteria,
                'contractor_id' => $this->contractor_id,
                'sub_contractor_id' => $this->sub_contractor_id,
                'pja_id' => $this->pja_id,
                //'pjo_id' => $this->pjo_id,
                'request_date' => Carbon::parse($this->request_date)->format('Y-m-d'),
                'next_date' => Carbon::parse($this->next_date)->format('Y-m-d'),
                'document_no' => $this->document_no,
                'revisi_number' => 0,
                'status' => 'DRAFT',
                //'created_by' => Auth::user()->id,
            ]);

            $outputArray = [];
            foreach ($this->teams as $value) {
                if ($value !== '') {
                    $outputArray = [
                        'id' => Str::uuid()->toString(),
                        'ibpr_id' => $this->ibpr_id,
                        'user_name' => $value,
                    ];
                    IbprTeam::insert($outputArray);
                }
            }

            DB::commit();
            $request->session()->put('route', '/ibpr-and-bowtie/ibpr/active/edit/' . $this->ibpr_id);
            return redirect()->route('ibpr-and-bowtie::ibpr.active.list-form-active-ibpr-and-bowtie', [$this->ibpr->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function save_ibpr($status = 'DRAFT')
    {
        DB::beginTransaction();
        try {
            $this->validate();
            $this->ibpr->update([
                'ccow_id' => $this->ccow_id,
                'iup' => $this->iup,
                'department_id' => $this->department_id,
                'section_id' => $this->section_id,
                'kriteria' => $this->kriteria,
                'contractor_id' => $this->contractor_id,
                'sub_contractor_id' => $this->sub_contractor_id,
                'pja_id' => $this->pja_id,
                //'pjo_id' => $this->pjo_id,
                'request_date' => Carbon::parse($this->request_date)->format('Y-m-d'),
                'next_date' => Carbon::parse($this->next_date)->format('Y-m-d'),
                'document_no' => $this->document_no,
                'revisi_number' => 0,
                'status' => $status,
                'created_by' => Auth::user()->id,
            ]);

            $outputArray = [];
            foreach ($this->teams as $value) {
                if ($value !== '') {

                    $outputArray = [
                        'id' => Str::uuid()->toString(),
                        'ibpr_id' => $this->ibpr_id,
                        'user_name' => $value,
                    ];
                    IbprTeam::insert($outputArray);
                }
            }

            if ($status === 'DRAFT') {
                $status_redirect = 'DRAFT';
            } else {
                $status_redirect = 'ACTIVE';
            }
            DB::commit();
            return redirect()->route('ibpr-and-bowtie::ibpr.active.list-active-ibpr-and-bowtie', ['status' => $status_redirect]);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
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
        $this->ibpr->delete();
        return redirect()->route('ibpr-and-bowtie::ibpr.active.list-active-ibpr-and-bowtie');
    }

    public function render()
    {
        return view('ibprandbowtie::livewire.ibpr-and-bowtie.form.form')->extends('ibprandbowtie::layouts.no-header');
    }
}
