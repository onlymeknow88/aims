<?php
namespace Modules\IbprAndBowtie\Http\Livewire\Iadl\Form;

use App\Models\IbprBowty\BowtieEvent;
use App\Models\IbprBowty\Iadl;
use App\Models\IbprBowty\IadlForm;
use App\Models\IbprBowty\IadlTeam;
use App\Models\IbprBowty\Ibpr;
use App\Models\IbprBowty\IbprMasterHirarki;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Contractor;
use App\Models\Employee;
use App\Models\User;
use Livewire\Component;
use App\Enums\CompanyType;
use App\Models\Company;
use App\Models\AreaManager;
use App\Models\Department;
use App\Models\Section;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\IbprAndBowtie\Http\Livewire\Exports\ExportIadl;
// use Illuminate\Support\Facades\DB;

class FormIadl extends Component
{
    protected $listeners = [
        'event_formula_level_of_risk' => 'formula_level_of_risk',
        'event_formula_level_of_risk_residual' => 'formula_level_of_risk_residual',
        'event_unset_index_edit' => 'unset_index_edit',
        'event_ccow_on_change' => 'ccow_on_change',
    ];

    public $iadl;
    public $iadl_id;
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
    public $kriteria = 'IADL';
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

    public $index_edit = null;
    public $events = [];

    public $ibprHirarki = [];

    public function mount(){
        $this->ccow = Company::where('type', CompanyType::Internal()->value)->get();

        $this->pja = User::all();
        $this->pjo = User::all();
        $this->pjs = User::all();
        $this->users = User::get();
        $this->departments = Department::get();
        $this->sections = Section::get();

        $this->ibprHirarki = IbprMasterHirarki::all();

        $this->events = BowtieEvent::whereHas('bowtie', function ($query) {
            $query->whereIn('status', ['Disetujui','Temporary']);
        })->get();

        $this->iadl = Iadl::create();
        $this->iadl_id = $this->iadl->id;
    }

    public function updatedCcowId($ccow_id) {
        $company = Company::find($ccow_id);
        $no_doc = Iadl::where('ccow_id', '!=', null)->count() + 1;

        $this->contractors = Company::where('type', 'CONTRACTOR')->where('parent_company_id', $this->ccow_id)->get();
        $this->sub_contractors = [];
        $this->contractor_id = null;
        $this->sub_contractor_id = null;

        $this->document_no = $company->document_code .'-'.  Carbon::parse($this->request_date)->format('dmY') . '-'. str_pad($no_doc, 6, '0', STR_PAD_LEFT);
        $this->iup = $company->type;

    }

    public function updatedContractorId()
    {
        $this->sub_contractors = Company::where('type', 'SUBCONTRACTOR')->where('parent_company_id', $this->contractor_id)->get();
        $this->sub_contractor_id = null;

        $company = Company::find($this->contractor_id);
        $no_doc = Iadl::where('ccow_id', '!=', null)->count() + 1;

        $this->document_no = $company->document_code .'-'.  Carbon::parse($this->request_date)->format('dmY') . '-'. str_pad($no_doc, 6, '0', STR_PAD_LEFT);
        $this->iup = $company->type;
    }

    public function updatedSubContractorId()
    {
        $company = Company::find($this->sub_contractor_id);
        $no_doc = Iadl::where('ccow_id', '!=', null)->count() + 1;

        $this->document_no = $company->document_code .'-'.  Carbon::parse($this->request_date)->format('dmY') . '-'. str_pad($no_doc, 6, '0', STR_PAD_LEFT);
        $this->iup = $company->type;
    }

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function push_form() {
        try {
            $rules = [
                'activity' => 'required',
                'sub_activity' => 'required',
                'kondition' => 'required',
                'safety' => 'required',
                'incident_risk' => 'required',
                'relevant_legislation' => 'required',
                'preliminary_consequence_lh' => 'required',
                'preliminary_frequence' => 'required',
                'preliminary_level_of_risk' => 'required',
                'preliminary_main_risk' => 'required',
                'modal_of_current' => 'required',
                'effective_control' => 'required',
            ];

            $messages = [
                'activity' => 'required',
                'sub_activity' => 'required',
                'kondition' => 'required',
                'safety' => 'required',
                'incident_risk' => 'required',
                'relevant_legislation' => 'required',
                'preliminary_consequence_lh' => 'required',
                'preliminary_frequence' => 'required',
                'preliminary_level_of_risk' => 'required',
                'preliminary_main_risk' => 'required',
                'modal_of_current' => 'required',
                'effective_control' => 'required',
            ];

            $this->validate($rules, $messages);

            $object = [
                'iadl_id' => $this->iadl_id,
                'activity' => $this->activity,
                'sub_activity' => $this->sub_activity,
                'kondition' => $this->kondition,
                'safety' => $this->safety,
                'incident_risk' => $this->incident_risk,
                'safety_opportunity' => $this->safety_opportunity,
                'relevant_legislation' => $this->relevant_legislation,
                'preliminary_consequence_lh' => $this->preliminary_consequence_lh,
                'preliminary_frequence' => $this->preliminary_frequence,
                'preliminary_level_of_risk' => $this->preliminary_level_of_risk,
                'preliminary_main_risk' => $this->preliminary_main_risk,
                'modal_of_current' => $this->modal_of_current,
                'effective_control' => $this->effective_control,
                'residual_consequence_lh' => $this->residual_consequence_lh,
//                'residual_frequence' => $this->residual_frequence,
                'residual_level_of_risk' => $this->residual_level_of_risk,
                'residual_main_risk' => $this->residual_main_risk,
                'follow_risk' => $this->follow_risk,
            ];

            if(!is_null($this->index_edit)) {
                $this->form[$this->index_edit] = $object;
            } else {
                $createIadlForm = IadlForm::create($object);

                if ($this->preliminary_level_of_risk === 'H') {
                    $createIadlForm->pica()->createMany([
                        [
                            'status' => 'Open'
                        ]
                    ]);
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
            $this->preliminary_consequence_lh = null;
            $this->preliminary_frequence = null;
            $this->preliminary_level_of_risk = null;
            $this->preliminary_main_risk = null;
            $this->modal_of_current = '';
            $this->effective_control = '';
            $this->residual_consequence_lh = null;
            $this->residual_frequence = null;
            $this->residual_level_of_risk = null;
            $this->residual_main_risk = null;
            $this->follow_risk = '';

            $this->form = IadlForm::where('iadl_id', $this->iadl_id)->get();

            $this->emit('closeModal');
        } catch (\Exception $e) {
            throw $e;
       }
    }

    public function unset_index_edit(){
        $this->index_edit = null;
    }

    public function open_modal_edit($index){
        $this->index_edit = $index;
        $form_iadl = $this->form[$index];

        $this->activity = $form_iadl['activity'];
        $this->sub_activity = $form_iadl['sub_activity'];
        $this->safety = $form_iadl['safety'];
        $this->kondition = $form_iadl['kondition'];
        $this->incident_risk = $form_iadl['incident_risk'];
        $this->safety_opportunity = $form_iadl['safety_opportunity'];
        $this->relevant_legislation = $form_iadl['relevant_legislation'];
        $this->preliminary_consequence_lh = $form_iadl['preliminary_consequence_lh'];
        $this->preliminary_frequence = $form_iadl['preliminary_frequence'];
        $this->preliminary_level_of_risk = $form_iadl['preliminary_level_of_risk'];
        $this->preliminary_main_risk = $form_iadl['preliminary_main_risk'];
        $this->modal_of_current = $form_iadl['modal_of_current'];
        $this->effective_control = $form_iadl['effective_control'];
        $this->residual_consequence_lh = $form_iadl['residual_consequence_lh'];
        $this->residual_frequence = $form_iadl['residual_frequence'];
        $this->residual_level_of_risk = $form_iadl['residual_level_of_risk'];
        $this->residual_main_risk = $form_iadl['residual_main_risk'];
        $this->follow_risk = $form_iadl['follow_risk'];

        $this->emit('openModal');
    }

    public function delete_form($index) {
        unset($this->form[$index]);
    }


    public function change_consequences($value, $type) {
        if ($type === 'preliminary_consequence_lh') $this->preliminary_consequence_lh = $value;
        if ($type === 'residual_consequence_lh') $this->residual_consequence_lh = $value;

        $arr_preliminary = [$this->preliminary_consequence_lh];
        $max_preliminary = max($arr_preliminary);

        $arr_residual = [$this->residual_consequence_lh];
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

    public function formula_level_of_risk($preliminary_frequence){
        $arr_preliminary = [$this->preliminary_consequence_lh];
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

    public function formula_level_of_risk_residual($residual_frequence){
        $arr_residual = [$this->residual_consequence_lh];
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

    public function rules(){
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


    public function goto_list_iadl(Request $request){
        DB::beginTransaction();
       try {
        $this->validate();
        $this->iadl->update([
            'ccow_id' => $this->ccow_id,
            'iup' => $this->iup,
            'department_id' => $this->department_id,
            'section_id' => $this->section_id,
            'kriteria' => $this->kriteria,
            'contractor_id' => $this->contractor_id,
            'sub_contractor_id' => $this->sub_contractor_id,
            'pja_id' => $this->pja_id,
            'pjo_id' => $this->pjo_id,
            'request_date' =>  Carbon::parse($this->request_date)->format('Y-m-d'),
            'next_date' => Carbon::parse($this->next_date)->format('Y-m-d'),
            'document_no' => $this->document_no,
            'revisi_number' => 0,
            'status' => 'DRAFT',
            'created_by' => Auth::user()->id,
        ]);

        $outputArray = [];
        foreach ($this->teams as $value) {
            if ($value !== '') {
             $outputArray = [
                 'id' => Str::uuid()->toString(),
                 'iadl_id' => $this->iadl_id,
                 'user_name' => $value,
             ];
             IadlTeam::insert($outputArray);
            }
         }

         DB::commit();
         $request->session()->put('route', '/ibpr-and-bowtie/iadl/active/edit/' . $this->iadl_id);
         return redirect()->route('ibpr-and-bowtie::iadl.active.list-form-active-iadl-and-bowtie', [$this->iadl->id]);
       } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
       }
    }

    public function save_ibpr($status = 'DRAFT'){
        DB::beginTransaction();
       try {
        $this->validate();
        $this->iadl->update([
            'ccow_id' => $this->ccow_id,
            'iup' => $this->iup,
            'department_id' => $this->department_id,
            'section_id' => $this->section_id,
            'kriteria' => $this->kriteria,
            'contractor_id' => $this->contractor_id,
            'sub_contractor_id' => $this->sub_contractor_id,
            'pja_id' => $this->pja_id,
            'pjo_id' => $this->pjo_id,
            'request_date' =>  Carbon::parse($this->request_date)->format('Y-m-d'),
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
                 'iadl_id' => $this->iadl_id,
                 'user_name' => $value,
             ];
             IadlTeam::insert($outputArray);
            }
         }

         if($status === 'DRAFT') {
            $status_redirect = 'Draft';
         } else {
            $status_redirect = 'ACTIVE';
         }

         DB::commit();
        return redirect()->route('ibpr-and-bowtie::iadl.active.list-active-iadl-and-bowtie', ['status' => $status_redirect]);
       } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
       }
    }

    public function change_teams($id, $name) {
        if(in_array($id, $this->teams)) {
            $this->teams = array_values(array_diff($this->teams, [$id]));
            $this->team_names = array_values(array_diff($this->team_names, [$name]));
        } else {
            $this->teams[] = $id;
            $this->team_names[] = $name;
        }
    }

    public function toggle_multi_select() {
        $this->open_multiselect = !$this->open_multiselect;
    }

    public function cancel() {
        $this->ibpr->delete();
        return redirect()->route('ibpr-and-bowtie::iadl.active.list-active-ibpr-and-bowtie');
    }

    public function render()
    {

        return view('ibprandbowtie::livewire.ibpr-and-bowtie.iadl.form.form')->extends('ibprandbowtie::layouts.no-header');;
    }

    public function exportIadl(Request $request, $id)
    {
        return (new ExportIadl($id))->download('export_iadl'.'-'.now().'.xlsx');
    }
}
