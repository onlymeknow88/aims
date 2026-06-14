<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Master;

use App\Models\IbprBowty\IbprMasterBahaya;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Bahaya extends Component {

    public $dataTables = [];
    public $itemSelected = [];
    public $columns = [];
    public $countSelected = 0;

    public $data = [];

    public $id_bahaya;
    public $is_edit = false;
    public $name;

    public function mount()
    {

        $query = IbprMasterBahaya::select()->with([]);
        $this->data = $query->get();
    
        $this->columns = [
            trans('NO.') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Nama') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('Ubah') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
        ];
    }

    public function open_edit($id, $name){
        $this->id_bahaya = $id;
        $this->is_edit = true;

        $this->name = $name;

        $this->emit('openModalBahaya');
    }

    public function submit(){
        try {
            IbprMasterBahaya::create([
                'name' => $this->name
            ]);

            $this->name = '';
        
            $query = IbprMasterBahaya::select()->with([]);
            $this->data = $query->get();
            
            $this->emit('closeModalBahaya');
        }  catch (\Exception $e) {
            dd($e);
        }
    }

    public function submit_edit(){
        try {
            $master_bahaya = IbprMasterBahaya::find($this->id_bahaya);
        
            $master_bahaya->update([
                'name' => $this->name
            ]);

            $this->name = '';
            $this->id_bahaya = null;
            $this->is_edit = false;
    
        
            $query = IbprMasterBahaya::select()->with([]);
            $this->data = $query->get();
            
            $this->emit('closeModalBahaya');
        }  catch (\Exception $e) {
            dd($e);
        }
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
                $data = IbprMasterBahaya::find($ids[$a]);
                $data->delete();
            }
            $this->itemSelected = [];
            $this->countSelected = 0;
            DB::commit();

            $query = IbprMasterBahaya::select()->with([]);
            $this->data = $query->get();

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
        return view('ibprandbowtie::livewire.ibpr-and-bowtie.master.list-bahaya')->layout('ibprandbowtie::layouts.ibpr-and-bowtie');
    }
}