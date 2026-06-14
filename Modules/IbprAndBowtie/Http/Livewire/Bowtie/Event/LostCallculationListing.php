<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Bowtie\Event;

use App\Models\IbprBowty\Bowtie;
use App\Models\IbprBowty\BowtieLossCalculation;
use App\Models\IbprBowty\BowtiePerformanceStandard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class LostCallculationListing extends Component
{
    protected $listeners = [
        'check_lost_callculation' => 'handle_check_lost_callculation',
    ];

    public $data = [];
    public $bowtie_id;
    public $bowtie;
    public $columns = [];
    public $itemSelected = [];
    public $countSelected = 0;

    public function mount($id){
        $this->bowtie_id = $id;
        $this->bowtie = Bowtie::find($id);

        $this->columns = [
            trans('Nama Kejadian') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'activity_search',
                'sortable' => true,
            ],
            trans('Detail') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'activity_search',
                'sortable' => true,
            ],
            trans('Jumlah Rupiah') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'activity_search',
                'sortable' => true,
            ],
            trans('Jumlah Dolar') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'activity_search',
                'sortable' => true,
            ],
        ];
    }

    public function handle_check_lost_callculation(){
        $this->data = BowtieLossCalculation::where('bowtie_id', $this->bowtie_id)->get();
    }

    public function onSelectedItem($id)
    {
        if(in_array($id, $this->itemSelected)){
            $key = array_search($id, $this->itemSelected);
            unset($this->itemSelected[$key]);
            $this->countSelected--;
        }else{
            $this->itemSelected[] = $id;
             $this->countSelected++;
        }

    }



    public function confirmDelete()
    {
        $this->dispatchBrowserEvent('confirm-delete');
    }

    public function submitDelete()
    {
        DB::beginTransaction();
        try {
            $ids = array_values($this->itemSelected);
            for ($a = 0; $a < count($ids); $a++) {
                $data = BowtieLossCalculation::find($ids[$a]);
                $data->delete();
            }
            $this->itemSelected = [];
            $this->countSelected = 0;
            DB::commit();

            return $this->dispatchBrowserEvent('swal', [
                'title' => 'Success',
                'icon' => 'success',
                'text' => trans('global.success_delete_document'),
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->dispatchBrowserEvent('swal', [
                'title' => 'Failed',
                'icon' => 'error',
                'text' => env('APP_ENV') == 'local' ? $th->getMessage() . ' ' . $th->getLine() : 'Failed to delete document',
            ]);
        }
    }


    public function render()
    {

        $query = BowtieLossCalculation::where('bowtie_id', $this->bowtie_id)->withCount('details')->withSum('details', 'amount');
        $this->data = $query->get();

        return view('ibprandbowtie::livewire.ibpr-and-bowtie.bowtie.list.loss-callculation-list')->extends('ibprandbowtie::layouts.no-header');
    }

}
