<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Bowtie\Event;

use App\Models\DocumentSystem\Document;
use App\Models\IbprBowty\Bowtie;
use App\Models\IbprBowty\BowtieCca;
use App\Models\IbprBowty\BowtieEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CcaListing extends Component
{
    protected $listeners = [
        'check_cca' => 'handle_check_cca',
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
            trans('Tujuan Pengendalian') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'activity_search',
                'sortable' => true,
            ],
            trans('Hubungan dengan Kejadian Risiko') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'sub_activity_search',
                'sortable' => true,
            ],
            trans('Penjelasan Pengendalian') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'sub_activity_search',
                'sortable' => true,
            ],
            trans('Langkah 1') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Langkah 2') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Langkah 3') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Langkah 4') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Langkah 5') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Langkah 6') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Langkah 7') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Regulasi Pengendalian') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Nomor Identitas Pengendalian') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
        ];
    }

    public function handle_check_cca(){
        $this->data = BowtieCca::where('bowtie_id', $this->bowtie_id)->get();
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
                $data = BowtieCca::find($ids[$a]);
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

        $query = BowtieCca::where('bowtie_id', $this->bowtie_id)->select();
        $this->data = $query->get();

        return view('ibprandbowtie::livewire.ibpr-and-bowtie.bowtie.list.cca-list')->extends('ibprandbowtie::layouts.no-header');
    }

}
