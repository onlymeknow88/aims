<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Bowtie\Event;

use App\Models\IbprBowty\Bowtie;
use App\Models\IbprBowty\BowtiePerformanceStandard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class PerpormanceStandardListing extends Component
{
    protected $listeners = [
        'check_perpormance_standard' => 'handle_check_perpormance_standard',
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
            trans('Nama Pengendalian') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'activity_search',
                'sortable' => true,
            ],
//            trans('Department') => [
//                'filter' => true,
//                'type' => 'text',
//                'model' => 'activity_search',
//                'sortable' => true,
//            ],
//            trans('Section') => [
//                'filter' => true,
//                'type' => 'text',
//                'model' => 'activity_search',
//                'sortable' => true,
//            ],
//            trans('Penjelasan') => [
//                'filter' => true,
//                'type' => 'text',
//                'model' => 'activity_search',
//                'sortable' => true,
//            ],
            trans('Penanggung Jawab') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'activity_search',
                'sortable' => true,
            ],
            trans('Tujuan') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'activity_search',
                'sortable' => true,
            ],
            trans('Standar Kinerja') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'activity_search',
                'sortable' => true,
            ],
            trans('Kegiatan Verifikasi') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'activity_search',
                'sortable' => true,
            ],
            trans('Bukti Verifikasi') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'activity_search',
                'sortable' => true,
            ],
            trans('Pelaksanaan Verifikasi') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'activity_search',
                'sortable' => true,
            ],
            trans('Pengetesan efektifitas pengendalian') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'activity_search',
                'sortable' => true,
            ],
            trans('Pelaksanaan Pengetesan Efektifitas') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'activity_search',
                'sortable' => true,
            ],
        ];
    }

    public function handle_check_perpormance_standard(){
        $this->data = BowtiePerformanceStandard::where('bowtie_id', $this->bowtie_id)->get();
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

    public function downloadFile($url)
    {
       try {
            $filePath = storage_path('app/public/' .$url);
            return response()->download($filePath);
       }
       catch (\Throwable $th) {
            return $this->dispatchBrowserEvent('swal', [
                'title' => 'Failed',
                'icon' => 'error',
                'text' => $th->getMessage(),
            ]);
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
                $data = BowtiePerformanceStandard::find($ids[$a]);
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

        $query = BowtiePerformanceStandard::where('bowtie_id', $this->bowtie_id)->select();
        $this->data = $query->get();

        return view('ibprandbowtie::livewire.ibpr-and-bowtie.bowtie.list.perpormance-standard-list')->extends('ibprandbowtie::layouts.no-header');
    }

}
