<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Maker;

use App\Models\Department;
use Illuminate\Support\Facades\DB;
use App\Models\IbprBowty\Ibpr;
use App\Models\IbprBowty\IbprForm;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Detail extends Component
{
    use LivewireAlert;

    protected $listeners = [
        'event_formula_level_of_risk' => 'formula_level_of_risk',
        'event_formula_level_of_risk_residual' => 'formula_level_of_risk_residual',
        'send_approval' => 'send_approval'
    ];

    public $user;
    public $field;
    public $ibpr_id;

    public $show_more = false;

    public $readonly = false;
    public $reject_reason;
    public $form_ibpr;
    public $form_id;
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
    public $residual_main_risk;
    public $follow_risk;
    public $loadingButton = false;

    public function mount($id)
    {
        $this->user = User::with(['employee', 'department'])->find(Auth::user()->id);

        $this->ibpr_id = $id;
        $this->field = Ibpr::with([
            'pjs',
            'forms',
        ])->find($id);
    }

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function goto_list_ibpr(Request $request) {
        $request->session()->put('route', '/ibpr-and-bowtie/ibpr/active/detail/' . $this->ibpr_id);

        return redirect()->route('ibpr-and-bowtie::ibpr.active.list-form-active-ibpr-and-bowtie', [$this->ibpr_id]);
    }

    public function toggle_show_more(){
        $this->show_more = !$this->show_more;
    }

    public function delete_form($id) {
        IbprForm::where('id', $id)->delete();

        $new_form = IbprForm::where('ibpr_id', $this->ibpr_id)->get();
        $this->field->forms = $new_form;
    }

    public function open_modal_edit($form_id){
        $form_ibpr = IbprForm::find($form_id);

        $this->form_ibpr = $form_ibpr;
        $this->form_id = $form_ibpr->id;
        $this->activity = $form_ibpr->activity;
        $this->sub_activity = $form_ibpr->sub_activity;
        $this->safety = $form_ibpr->safety;
        $this->kondition = $form_ibpr->kondition;
        $this->incident_risk = $form_ibpr->incident_risk;
        $this->safety_opportunity = $form_ibpr->safety_opportunity;
        $this->relevant_legislation = $form_ibpr->relevant_legislation;
        $this->preliminary_consequence_k3 = $form_ibpr->preliminary_consequence_k3;
        $this->preliminary_consequence_lh = $form_ibpr->preliminary_consequence_lh;
        $this->preliminary_consequence_kp = $form_ibpr->preliminary_consequence_kp;
        $this->preliminary_consequence_ksl = $form_ibpr->preliminary_consequence_ksl;
        $this->preliminary_consequence_kk = $form_ibpr->preliminary_consequence_kk;
        $this->preliminary_frequence = $form_ibpr->preliminary_frequence;
        $this->preliminary_level_of_risk = $form_ibpr->preliminary_level_of_risk;
        $this->preliminary_main_risk = $form_ibpr->preliminary_main_risk;
        $this->modal_of_current = $form_ibpr->modal_of_current;
        $this->effective_control = $form_ibpr->effective_control;
        $this->residual_consequence_k3 = $form_ibpr->residual_consequence_k3;
        $this->residual_consequence_lh = $form_ibpr->residual_consequence_lh;
        $this->residual_consequence_kp = $form_ibpr->residual_consequence_kp;
        $this->residual_consequence_ksl = $form_ibpr->residual_consequence_ksl;
        $this->residual_consequence_kk = $form_ibpr->residual_consequence_kk;
        $this->residual_frequence = $form_ibpr->residual_frequence;
        $this->residual_level_of_risk = $form_ibpr->residual_level_of_risk;
        $this->residual_main_risk = $form_ibpr->residual_main_risk;
        $this->follow_risk = $form_ibpr->follow_risk;

        $this->emit('openModal');
    }

    public function update_form() {
        $this->form_ibpr->update([
            'activity' => $this->activity,
            'sub_activity' => $this->sub_activity,
            'safety' => $this->safety,
            'kondition' => $this->kondition,
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
        ]);

        $this->emit('closeModal');
    }

    public function add_form() {
        $ibpr = IbprForm::create([
            'ibpr_id' => $this->ibpr_id,
            'activity' => $this->activity,
            'sub_activity' => $this->sub_activity,
            'safety' => $this->safety,
            'kondition' => $this->kondition,
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
        ]);

        $this->field->forms[] = $ibpr;
        $this->emit('closeModal');
    }

    public function change_consequences($value, $type) {
        if ($type === 'preliminary_consequence_k3') $this->preliminary_consequence_k3 = $value;
        if ($type === 'preliminary_consequence_lh') $this->preliminary_consequence_lh = $value;
        if ($type === 'preliminary_consequence_kp') $this->preliminary_consequence_kp = $value;
        if ($type === 'preliminary_consequence_ksl') $this->preliminary_consequence_ksl = $value;
        if ($type === 'preliminary_consequence_kk') $this->preliminary_consequence_kk = $value;
        if ($type === 'residual_consequence_k3') $this->residual_consequence_k3 = $value;
        if ($type === 'residual_consequence_lh') $this->residual_consequence_lh = $value;
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
        }

        if ($this->residual_level_of_risk !== '' && $max_residual >= 4) {
            $this->residual_main_risk = 'Ya';
        }
        if ($this->residual_level_of_risk !== '' && $max_residual < 4) {
            $this->residual_main_risk = 'Tidak';
        }
    }

    public function changeStatus()
    {
        $text = 'Yakin untuk melanjutkan?';

        $this->alert('question', 'Are You Sure ?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes',
            'confirmButtonColor' => '#00552F',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'cancelButtonColor' => '#d33',
            'timer' => 30000,
            'toast' => true,
            'timerProgressBar' => true,
            'position' => 'center',
            'text' => $text,
            'onConfirmed' => 'send_approval',
            'inputAttributes' => [
                'value' => $this->field->status
            ],
        ]);
    }

    public function send_approval(){
        try {
            $this->loadingButton = true;
            if(($this->field->status === 'DRAFT' || $this->field->status === 'Di Reject') && $this->field->iup === 'INTERNAL') {
                $status = 'Pengajuan Kepada PJA';
//                $receiptEmail = [$this->field->pja->email];
//                $receiptName = $this->field->pja->name;
            }
            if(($this->field->status === 'DRAFT' || $this->field->status === 'Di Reject') && ($this->field->iup === 'CONTRACTOR' || $this->field->iup === 'SUBCONTRACTOR')) {
                $status = 'Pengajuan Kepada PJO';
//                $receiptEmail = [$this->field->pjo->email];
//                $receiptName = $this->field->pjo->name;
            }
            if($this->field->status === 'Pengajuan Kepada PJA') {
                $status = 'Pengajuan Kepada DH/OHS';

//                $ohsdept = Department::where('code', 'OHS')->with(['users'])->get()->toArray();
//                $receiptEmail = array_column($ohsdept[0]['users'], 'email');
//                $receiptName = 'Departemen OHS';
            }
            if($this->field->status === 'Pengajuan Kepada PJO') {
                $status = 'Pengajuan Kepada DH/OHS';

//                $ohsdept = Department::where('code', 'OHS')->with(['users'])->get()->toArray();
//                $receiptEmail = array_column($ohsdept[0]['users'], 'email');
//                $receiptName = 'Departemen OHS';
            }

            if($this->field->status === 'Pengajuan Kepada DH/OHS') {
                $status = 'Diajukan Untuk Persetujuan KTT';

//                $ohsdept = Department::where('code', 'KTT')->with(['users'])->get()->toArray();
//                $receiptEmail = array_column($ohsdept[0]['users'], 'email');
//                $receiptName = 'Departemen KTT';
            }

            if($this->field->status === 'Diajukan Untuk Persetujuan KTT') $status = 'Disetujui';

            if($status === 'Disetujui') {
                $this->field->update([
                    'status' => $status,
                    'approve_at' => date('Y-m-d'),
                ]);
            }else {
                $this->field->update([
                    'status' => $status,
                ]);
            }

//            $email = new EmailService();
//            $payload = [
//                'type' => 'notif_approval',
//                'receiver' => $receiptEmail,
//                'has_attachments' => false,
//                'name' => $receiptName,
//                'module' => 'IBPR',
//                'url' => env('APP_URL') . '/ibpr-and-bowtie/ibpr/active/detail/' . $this->field->id,
//            ];

//            $email->sendEmail($payload);

            $this->loadingButton = false;
            $this->alert('success', 'Data berhasil diupdate!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
//            $this->emit('successApprove');

        } catch (\Exception $e) {
            dd($e);
            throw $e;
       }
    }

    public function submit_reject() {
        $this->field->update([
            'status' => 'Di Reject',
            'reject_reason' => $this->reject_reason,
        ]);

        $this->emit('closeModal');
        $this->alert('success', 'Data berhasil diupdate!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    public function render()
    {
        return view('ibprandbowtie::livewire.ibpr-and-bowtie.maker.detail')->extends('ibprandbowtie::layouts.no-header');
    }

    public function getDetail(Request $request){
        return response()->json([
            'message' => 'Success',
            'data' => $this->ibpr
        ])->header('Custom-Header', 'Value');

    }
}
