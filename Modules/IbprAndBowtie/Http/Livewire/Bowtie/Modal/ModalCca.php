<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Bowtie\Modal;

use App\Models\IbprBowty\Bowtie;
use App\Models\IbprBowty\BowtieCca;
use App\Models\IbprBowty\BowtieEvent;
use App\Models\IbprBowty\BowtieEventCmf;
use App\Models\IbprBowty\BowtieEventImm;
use App\Models\IbprBowty\IbprMasterHirarki;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ModalCca extends Component
{
    protected $listeners = [
        'check_event_on_cca' => 'handle_check_event_cca',
        'click_edit_cca' => 'handle_click_edit_cca',
        'clear_state_cca' => 'clear_state_cca',
    ];

    public $hirarkis = [];
    public $event = [];
    public $bowtie_id;
    public $control_objectives;
    public $event_id;
    public $control_explanation;
    public $step_one;
    public $step_two;
    public $step_three;
    public $step_four;
    public $step_five;
    public $step_six;
    public $step_seven;
    public $control_regulation;
    public $number;
    public $cca_id;
    public $is_edit = false;

    public function mount($bowtie_id)
    {
        $this->bowtie_id = $bowtie_id;
        $this->event = BowtieEvent::where('bowtie_id', $bowtie_id)->get();
        $this->hirarkis = IbprMasterHirarki::all();
    }

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function updatedEventId()
    {
        // dd($this->event_id);
    }
    public function updatedControlObjectives()
    {
    }
    // public function updatedStepFour(){
    //     if ($this->step_four == 'Ya'){
    //         $this->step_seven = 'Ya';
    //     } else {
    //         $this->stepSevenValue();
    //     }
    //     dd($this->step_seven);
    // }
    // public function updatedStepFive(){
    //     if ($this->step_five == 'Ya'){
    //         $this->step_seven = 'Ya';
    //     } else {
    //         $this->stepSevenValue();
    //     }
    //     dd($this->step_seven);
    // }
    // public function updatedStepSix(){
    //     if ($this->step_four == 'Ya'){
    //         $this->step_seven = 'Ya';
    //     } else {
    //         $this->stepSevenValue();
    //     }
    //     dd($this->step_seven);
    // }
    public function stepSevenValue()
    {
        if ($this->step_four == 'Ya' || $this->step_five == 'Ya' || $this->step_six == 'Ya') {
            $this->step_seven = 'Ya';
        } else {
            $this->step_seven = 'Tidak';
        }
    }
    public function getEventControlExplanationProperty()
    {
        if ($this->event_id) {
            $e = ($this->control_objectives == 'Pencegahan') ? BowtieEventCmf::whereIn('event_id', $this->event_id)->get() : BowtieEventImm::whereIn('event_id', $this->event_id)->get();
            return $e;
        } else {
            return [];
        }
    }
    public function getEventImpactMitigationMeasureProperty()
    {
        if ($this->event_id) {
            return BowtieEvent::where('bowtie_id', $this->bowtie_id)
                ->whereIn('id', $this->event_id)
                ->get();
        } else {
            return [];
        }
    }

    public function handle_check_event_cca($number)
    {
        $this->event = BowtieEvent::where('bowtie_id', $this->bowtie_id)->get();

        $bowtie = Bowtie::find($this->bowtie_id);
        $cca = BowtieCca::where('bowtie_id', $this->bowtie_id)->count();

        if (isset($number)) {
            $this->number = $number . '-' . str_pad($cca + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $this->number = $bowtie->document_no . '-' . str_pad($cca + 1, 3, '0', STR_PAD_LEFT);
        }
    }

    public function handle_click_edit_cca($id)
    {
        $this->is_edit = true;
        $this->cca_id = $id;

        $cca = BowtieCca::find($id);
        $this->bowtie_id = $cca->bowtie_id;
        $this->control_objectives = $cca->control_objectives;
        $this->event_id = $cca->events->pluck('id')->toArray();

        $this->control_explanation = $cca->control_explanation;
        $this->step_one = $cca->step_one;
        $this->step_two = $cca->step_two;
        $this->step_three = $cca->step_three;
        $this->step_four = $cca->step_four;
        $this->step_five = $cca->step_five;
        $this->step_six = $cca->step_six;
        $this->step_seven = $cca->step_seven;
        $this->control_regulation = $cca->control_regulation;
        $this->number = $cca->number;

        $this->emit('openModalCca');
        $this->dispatchBrowserEvent('updateSelect2', ['event_id' => $this->event_id]);
    }

    public function clear_state_cca()
    {
        $this->is_edit = false;
        $this->cca_id = null;

        $this->control_objectives = null;
        $this->event_id = null;
        $this->control_explanation = null;
        $this->step_one = null;
        $this->step_two = null;
        $this->step_three = null;
        $this->step_four = null;
        $this->step_five = null;
        $this->step_six = null;
        $this->step_seven = null;
        $this->control_regulation = null;
        $this->number = null;
    }

    public function submit()
    {
        DB::beginTransaction();
        try {
            // $control_explanation = BowtieEvent::find($this->control_explanation);
            // dd($this->control_explanation);
            // dd($control_explanation->description);
            $this->stepSevenValue();
            // dd($this->step_seven);

            $cca = BowtieCca::create([
                'bowtie_id' => $this->bowtie_id,
                'control_objectives' => $this->control_objectives,
                // 'event_id' => $this->event_id,
                'control_explanation' => $this->control_explanation,
                'step_one' => $this->step_one,
                'step_two' => $this->step_two,
                'step_three' => $this->step_three,
                'step_four' => $this->step_four,
                'step_five' => $this->step_five,
                'step_six' => $this->step_six,
                'step_seven' => $this->step_seven,
                'control_regulation' => $this->control_regulation,
                'number' => $this->number,
            ]);

            $cca->events()->attach($this->event_id);
            // dd($cca);
            DB::commit();

            $this->emit('closeModalCCa');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function submit_edit()
    {
        DB::beginTransaction();
        try {
            $this->stepSevenValue();
            // dd($this->step_seven);
            $cca = BowtieCca::find($this->cca_id);
            $cca->update([
                'control_objectives' => $this->control_objectives,
                // 'event_id' => $this->event_id,
                'control_explanation' => $this->control_explanation,
                'step_one' => $this->step_one,
                'step_two' => $this->step_two,
                'step_three' => $this->step_three,
                'step_four' => $this->step_four,
                'step_five' => $this->step_five,
                'step_six' => $this->step_six,
                'step_seven' => $this->step_seven,
                'control_regulation' => $this->control_regulation,
            ]);
            // $events = $this->event_id;
            $cca->events()->sync($this->event_id);
            // dd($cca);

            DB::commit();
            $this->emit('closeModalCCa');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }


    public function render()
    {

        return view('ibprandbowtie::livewire.ibpr-and-bowtie.bowtie.modal.modal-cca');
    }
}
