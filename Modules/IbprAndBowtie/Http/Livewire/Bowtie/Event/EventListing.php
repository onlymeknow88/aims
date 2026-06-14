<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Bowtie\Event;

use App\Models\DocumentSystem\Document;
use App\Models\IbprBowty\Bowtie;
use App\Models\IbprBowty\BowtieEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EventListing extends Component
{
    protected $listeners = [
        'check_event' => 'check_event',
    ];

    public $data = [];
    public $bowtie;
    public $bowtie_id;
    public $dataTables = [];
    public $itemSelected = [];
    public $columns = [];
    public $countSelected = 0;

    public function mount($id){
        $this->bowtie_id = $id;
        $this->bowtie = Bowtie::find($id);

        $this->columns = [
            trans('Impact (K3)') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'sub_activity_search',
                'sortable' => true,
            ],
            trans('Impact (LH)') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Impact (KP)') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Impact (KSL)') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Impact (KK)') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Max Loss (K3)') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Max Loss (LH)') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Max Loss (KSL)') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Max Loss (KP)') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Max Loss (KK)') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Severity (K)') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Likelihood (P)') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('TRR') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
        ];
    }

    public function check_event(){
        $this->data = BowtieEvent::where('bowtie_id', $this->bowtie_id)->get();
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
                $data = BowtieEvent::find($ids[$a]);
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
        
        $query = BowtieEvent::where('bowtie_id', $this->bowtie_id)->select();
        $this->data = $query->get();

        return view('ibprandbowtie::livewire.ibpr-and-bowtie.bowtie.list.event-list')->extends('ibprandbowtie::layouts.no-header');
    }
}