<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Bowtie\Modal;

use App\Models\IbprBowty\BowtieEvent;
use App\Models\IbprBowty\BowtieLossCalculation;
use App\Models\IbprBowty\BowtieLossCalculationDetail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ModalLossCallculation extends Component
{

    protected $listeners = [
        'check_event_loss_callculation' => 'handle_check_event_loss_callculation',
        'change_detail_name' => 'handle_change_detail_name',
        'change_detail_amount' => 'handle_change_detail_amount',
        'click_edit_lost_callculation' => 'handle_click_edit_lost_callculation',
        'clear_lost_callculation_modal' => 'handle_clear_lost_callculation_modal'
    ];

    public $event = [];

    public $event_id;
    public $bowtie_id;

    public $section_id;
    public $details = [];
    public $ohs_id;
    public $pja_id;
    public $callculation_id;
    public $is_edit = false;
    public $department_id;
    public $ccow_id;
    public $contractor_id;
    public $sub_contractor_id;
    public $obesrvation;
    public $implementation_test_efectivity;

    public function mount($bowtie_id) {
        $this->bowtie_id = $bowtie_id;

        $selected_event = BowtieLossCalculation::where('bowtie_id', $bowtie_id)->pluck('event_id');
        $this->event = BowtieEvent::where('bowtie_id', $bowtie_id)->whereNotIn('id', $selected_event)->get();

        $detail = [
            'name' => '',
            'amount' => 0,
        ];

        $this->details[] = $detail;

    }

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function handle_check_event_loss_callculation() {
        $this->event = BowtieEvent::where('bowtie_id', $this->bowtie_id)->get();

    }

    public function add_detail(){
        $detail = [
            'name' => '',
            'amount' => 0,
        ];

        $this->details[] = $detail;
    }

    public function remove_detail($index) {

        array_splice($this->details, $index, 1);
    }

    public function handle_change_detail_name($name, $index) {
        $this->details[$index]['name'] = $name;
    }


    public function handle_change_detail_amount($amount, $index) {
        $this->details[$index]['amount'] = $amount;
    }

    public function handle_click_edit_lost_callculation($id) {
        $this->is_edit = true;
        $this->callculation_id = $id;

        $lost_callculation = BowtieLossCalculation::find($id);
        $this->bowtie_id = $lost_callculation->bowtie_id;
        $this->event_id = $lost_callculation->event_id;

        $this->details = $lost_callculation->details->toArray();

        $this->emit('openModalLossCallculation');
    }

    public function handle_clear_lost_callculation_modal() {
        $this->is_edit = false;
        $this->callculation_id = null;

        $this->event_id = null;
        $this->details = [];

        $detail = [
            'name' => '',
            'amount' => 0,
        ];

        $this->details[] = $detail;
    }


    public function submit() {
        DB::beginTransaction();
        try {
            $data = BowtieLossCalculation::create([
                'bowtie_id' => $this->bowtie_id,
                'event_id' => $this->event_id,
            ]);

            $data->details()->createMany($this->details);
            DB::commit();

            $this->emit('closeModalLossCallculation');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
       }
    }

    public function submit_edit() {
        DB::beginTransaction();
        try {

            $data = BowtieLossCalculation::find($this->callculation_id);
            $data->update([
                'event_id' => $this->event_id,
            ]);

            $details = [];
            BowtieLossCalculationDetail::where('loss_calculation_id', $this->callculation_id)->delete();
            foreach ($this->details as $value) {
                if ($value !== '') {

                 $details = [
                     'id' => Str::uuid()->toString(),
                     'loss_calculation_id' => $this->callculation_id,
                     'name' => $value['name'],
                     'amount' => $value['amount']
                 ];
                 BowtieLossCalculationDetail::insert($details);
                }
             }

            DB::commit();

            $this->emit('closeModalLossCallculation');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
       }
    }

    public function render()
    {

        return view('ibprandbowtie::livewire.ibpr-and-bowtie.bowtie.modal.modal-loss-callculation');
    }

}
