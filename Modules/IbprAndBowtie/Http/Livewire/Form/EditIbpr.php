<?php
namespace Modules\IbprAndBowtie\Http\Livewire\Form;

use App\Models\IbprBowty\BowtieEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\IbprBowty\IbprForm;
use Illuminate\Support\Str;
use App\Models\Contractor;
use App\Models\Employee;
use App\Models\IbprBowty\Ibpr;
use App\Models\IbprBowty\IbprTeam;
use App\Models\User;
use Livewire\Component;
use App\Enums\CompanyType;
use App\Models\Company;
use App\Models\AreaManager;
use App\Models\Department;
use App\Models\Section;
use Carbon\Carbon;
// use Illuminate\Support\Facades\DB;

class EditIbpr extends Component
{
    protected $listeners = [
        'event_formula_level_of_risk' => 'formula_level_of_risk',
        'event_formula_level_of_risk_residual' => 'formula_level_of_risk_residual',
    ];

    public $ibpr_id;
    public $field;
    public $ibpr;
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

    public $events = [];

    public function mount($id){
        $this->ibpr_id = $id;
        $this->ibpr = Ibpr::with(['teams', 'forms'])->find($id);

        $this->ccow = Company::where('type', CompanyType::Internal()->value)->get();
        $this->pja = User::get();
        $this->pjo = User::get();
        $this->pjs = User::get();
        $this->users = User::get();
        $this->departments = Department::get();
        $this->sections = Section::get();
        $this->contractors = Company::where('type', CompanyType::Contractor()->value)->where('parent_company_id', $this->ibpr->ccow_id)->get();
        $this->sub_contractors = Company::where('type', CompanyType::SubContractor()->value)->where('parent_company_id', $this->ibpr->contractor_id)->get();

        $this->events = BowtieEvent::whereHas('bowtie', function ($query) {
            $query->where('status', 'Disetujui');
        })->get();

        $this->ccow_id = $this->ibpr->ccow_id;
        $this->iup = $this->ibpr->iup;
        $this->department_id = $this->ibpr->department_id;
        $this->kriteria = $this->ibpr->kriteria;
        $this->contractor_id = $this->ibpr->contractor_id;
        $this->sub_contractor_id = $this->ibpr->sub_contractor_id;
        $this->pja_id = $this->ibpr->pja_id;
        $this->teams = array_column($this->ibpr->teams->toArray(), 'user_name');
        $this->team_names = implode(',', $this->teams);
        $this->request_date = $this->ibpr->request_date;
        $this->next_date = $this->ibpr->next_date;
        $this->document_no = $this->ibpr->document_no;
        $this->section_id = $this->ibpr->section_id;
        $this->form = $this->ibpr->forms;
    }

    public function updatedCcowId()
    {
        $company = Company::find($this->ccow_id);
        $no_doc = Ibpr::where('ccow_id', '!=', null)->count() + 1;

        $this->contractors = Company::where('type', 'CONTRACTOR')->where('parent_company_id', $this->ccow_id)->get();
        $this->sub_contractors = [];
        $this->contractor_id = null;
        $this->sub_contractor_id = null;

        $this->document_no = $company->document_code .'-'.  Carbon::parse($this->request_date)->format('dmY') . '-'. str_pad($no_doc, 6, '0', STR_PAD_LEFT);
        $this->iup = $company->type;
    }

    public function updatedContractorId()
    {
        $this->sub_contractors = Company::where('type', 'SUBCONTRACTOR')->get();
        $this->sub_contractor_id = null;
    }

    public function hydrate()
    {
        $this->emit('select2');
    }


    public function push_form() {
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
            'preliminary_consequence_lh' => $this->preliminary_consequence_lh,
            'preliminary_consequence_kp' => $this->preliminary_consequence_kp,
            'preliminary_consequence_ksl' => $this->preliminary_consequence_ksl,
            'preliminary_consequence_kk' => $this->preliminary_consequence_kk,
            'preliminary_frequence' => $this->preliminary_frequence,
            'preliminary_level_of_risk' => $this->preliminary_level_of_risk,
            'preliminary_main_risk' => $this->preliminary_main_risk,
            'modal_of_current' => $this->modal_of_current,
            'effective_control' => $this->effective_control,
            'residual_consequence_k3' => $this->residual_consequence_k3,
            'residual_consequence_lh' => $this->residual_consequence_lh,
            'residual_consequence_kp' => $this->residual_consequence_kp,
            'residual_consequence_ksl' => $this->residual_consequence_ksl,
            'residual_consequence_kk' => $this->residual_consequence_kk,
            'residual_frequence' => $this->residual_frequence,
            'residual_level_of_risk' => $this->residual_level_of_risk,
            'residual_main_risk' => $this->residual_main_risk,
            'follow_risk' => $this->follow_risk,
        ];

        IbprForm::create($object);

        // Clear the temporary variable
        $this->activity = '';
        $this->sub_activity = '';
        $this->safety = '';
        $this->kondition = '';
        $this->incident_risk = '';
        $this->safety_opportunity = '';
        $this->relevant_legislation = '';
        $this->preliminary_consequence_k3 = null;
        $this->preliminary_consequence_lh = null;
        $this->preliminary_consequence_kp = null;
        $this->preliminary_consequence_ksl = null;
        $this->preliminary_consequence_kk = null;
        $this->preliminary_frequence = null;
        $this->preliminary_level_of_risk = null;
        $this->preliminary_main_risk = null;
        $this->modal_of_current = '';
        $this->effective_control = '';
        $this->residual_consequence_k3 = null;
        $this->residual_consequence_lh = null;
        $this->residual_consequence_kp = null;
        $this->residual_consequence_ksl = null;
        $this->residual_consequence_kk = null;
        $this->residual_frequence = null;
        $this->residual_level_of_risk = null;
        $this->residual_main_risk = null;
        $this->follow_risk = '';

        $this->form = IbprForm::where('ibpr_id', $this->ibpr_id)->get();

        $this->emit('closeModal');
    }

    public function unset_index_edit(){
        $this->index_edit = null;
    }

    public function goto_list_ibpr(Request $request){
        DB::beginTransaction();
       try {
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
            'request_date' =>  Carbon::parse($this->request_date)->format('Y-m-d'),
            'next_date' => Carbon::parse($this->next_date)->format('Y-m-d'),
            'document_no' => $this->document_no,
            'revisi_number' => 0,
        ]);

        $outputArray = [];

        IbprTeam::where('ibpr_id', $this->ibpr_id)->delete();
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

    public function open_modal_edit($index){
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

    public function delete_form($index) {
        unset($this->form[$index]);
    }


    public function change_consequences($value, $type) {
        if ($type === 'preliminary_consequence_k3') $this->preliminary_consequence_k3 = $value;
        if ($type === 'preliminary_consequence_kp') $this->preliminary_consequence_kp = $value;
        if ($type === 'preliminary_consequence_ksl') $this->preliminary_consequence_ksl = $value;
        if ($type === 'preliminary_consequence_kk') $this->preliminary_consequence_kk = $value;
        if ($type === 'residual_consequence_k3') $this->residual_consequence_k3 = $value;
        if ($type === 'residual_consequence_kp') $this->residual_consequence_kp = $value;
        if ($type === 'residual_consequence_ksl') $this->residual_consequence_ksl = $value;
        if ($type === 'residual_consequence_kk') $this->residual_consequence_kk = $value;

        $arr_preliminary = [$this->preliminary_consequence_k3, $this->preliminary_consequence_lh, $this->preliminary_consequence_kp, $this->preliminary_consequence_ksl, $this->preliminary_consequence_kk];
        $max_preliminary = max($arr_preliminary);

        $arr_residual = [$this->residual_consequence_k3, $this->residual_consequence_lh, $this->residual_consequence_kp, $this->residual_consequence_ksl, $this->residual_consequence_kk];
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

            if ($this->preliminary_frequence === 'E' && $max_preliminary === 1) $this->preliminary_level_of_risk = 'L';
            if ($this->preliminary_frequence === 'E' && $max_preliminary === 2) $this->preliminary_level_of_risk = 'L';
            if ($this->preliminary_frequence === 'E' && $max_preliminary === 3) $this->preliminary_level_of_risk = 'M';
            if ($this->preliminary_frequence === 'E' && $max_preliminary === 4) $this->preliminary_level_of_risk = 'M';
            if ($this->preliminary_frequence === 'E' && $max_preliminary === 5) $this->preliminary_level_of_risk = 'H';

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

            if ($this->residual_frequence === 'E' && $max_residual === 1) $this->residual_level_of_risk = 'L';
            if ($this->residual_frequence === 'E' && $max_residual === 2) $this->residual_level_of_risk = 'L';
            if ($this->residual_frequence === 'E' && $max_residual === 3) $this->residual_level_of_risk = 'M';
            if ($this->residual_frequence === 'E' && $max_residual === 4) $this->residual_level_of_risk = 'M';
            if ($this->residual_frequence === 'E' && $max_residual === 5) $this->residual_level_of_risk = 'H';

            if ($this->residual_level_of_risk === 'C') $this->residual_level_of_risk_label = 'C (Tingkat Risiko Kritikal)';
            if ($this->residual_level_of_risk === 'H') $this->residual_level_of_risk_label = 'H (Tingkat Risiko Tinggi)';
            if ($this->residual_level_of_risk === 'M') $this->residual_level_of_risk_label = 'M (Tingkat Risiko Menengah)';
            if ($this->residual_level_of_risk === 'L') $this->residual_level_of_risk_label = 'L (Tingkat Risiko Rendah)';
        }

        if ($this->preliminary_level_of_risk !== '' && $max_preliminary >= 4) {
            $this->preliminary_main_risk = 'Ya';
            $this->emit('chooseModaelOfCurrent', 'Ya');
        }
        if ($this->preliminary_level_of_risk !== '' && $max_preliminary < 4) {
            $this->preliminary_main_risk = 'Tidak';
            $this->emit('chooseModaelOfCurrent', 'Tidak');
        }

        if ($this->residual_level_of_risk !== '' && $max_residual >= 4) {
            $this->residual_main_risk = 'Ya';
            $this->emit('chooseModaelOfCurrent', 'Ya');
        }
        if ($this->residual_level_of_risk !== '' && $max_residual < 4) {
            $this->residual_main_risk = 'Tidak';
            $this->emit('chooseModaelOfCurrent', 'Tidak');
        }

        $this->emit('closeAllToooltip');
        $this->emit('chooseModaelOfCurrent');
    }

    public function formula_level_of_risk($preliminary_frequence){
        $arr_preliminary = [$this->preliminary_consequence_k3, $this->preliminary_consequence_lh, $this->preliminary_consequence_kp, $this->preliminary_consequence_ksl, $this->preliminary_consequence_kk];
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

        if ($this->preliminary_level_of_risk !== '' && $max_preliminary >= 4) {
            $this->preliminary_main_risk = 'Ya';
            $this->emit('chooseModaelOfCurrent', 'Ya');
        }
        if ($this->preliminary_level_of_risk !== '' && $max_preliminary < 4) {
            $this->preliminary_main_risk = 'Tidak';
            $this->emit('chooseModaelOfCurrent', 'Tidak');
        }
    }

    public function formula_level_of_risk_residual($residual_frequence){
        $arr_residual = [$this->residual_consequence_k3, $this->residual_consequence_lh, $this->residual_consequence_kp, $this->residual_consequence_ksl, $this->residual_consequence_kk];
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

        if ($this->residual_level_of_risk !== '' && $max_residual >= 4) {
            $this->residual_main_risk = 'Ya';
        }
        if ($this->residual_level_of_risk !== '' && $max_residual < 4) {
            $this->residual_main_risk = 'Tidak';
        }
    }

    public function save_ibpr(){
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
            'request_date' =>  Carbon::parse($this->request_date)->format('Y-m-d'),
            'next_date' => Carbon::parse($this->next_date)->format('Y-m-d'),
            'document_no' => $this->document_no,
            'revisi_number' => 0,
            'status' => 'DRAFT',
        ]);

        $outputArray = [];

        IbprTeam::where('ibpr_id', $this->ibpr_id)->delete();
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

        // remove old teams;
        return redirect()->route('ibpr-and-bowtie::ibpr.active.detai-active-ibpr-and-bowtie', [$this->ibpr->id]);
    }

    public function change_teams($id, $name) {
        if(in_array($id, $this->teams)) {
            $this->teams = array_values(array_diff($this->teams, [$id]));
        } else {
            $this->teams[] = $id;
        }
    }

    public function toggle_multi_select() {
        $this->open_multiselect = !$this->open_multiselect;
    }

    public function render()
    {

        return view('ibprandbowtie::livewire.ibpr-and-bowtie.form.form-edit')->extends('ibprandbowtie::layouts.no-header');
    }
}
