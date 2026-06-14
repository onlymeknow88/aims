<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Master;

use App\Models\IbprBowty\IbprMasterHirarki;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Hirarki extends Component {

    public $dataTables = [];
    public $itemSelected = [];
    public $columns = [];
    public $countSelected = 0;

    public $data = [];

    public $id_hirarki;
    public $is_edit = false;
    public $name;

    public function mount()
    {

        $query = IbprMasterHirarki::select()->with([]);
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
        $this->id_hirarki = $id;
        $this->is_edit = true;

        $this->name = $name;

        $this->emit('openModalHirarIbprMasterHirarki');
    }

    public function submit(){
        try {
            IbprMasterHirarki::create([
                'name' => $this->name
            ]);

            $this->name = '';
        
            $query = IbprMasterHirarki::select()->with([]);
            $this->data = $query->get();
            
            $this->emit('closeModalHirarIbprMasterHirarki');
        }  catch (\Exception $e) {
            dd($e);
        }
    }

    public function submit_edit(){
        try {
            $master_hirarki = IbprMasterHirarki::find($this->id_hirarki);
        
            $master_hirarki->update([
                'name' => $this->name
            ]);

            $this->name = '';
            $this->id_hirarki = null;
            $this->is_edit = false;
    
        
            $query = IbprMasterHirarki::select()->with([]);
            $this->data = $query->get();
            
            $this->emit('closeModalHirarIbprMasterHirarki');
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
                $data = IbprMasterHirarki::find($ids[$a]);
                $data->delete();
            }
            $this->itemSelected = [];
            $this->countSelected = 0;
            DB::commit();

            $query = IbprMasterHirarki::select()->with([]);
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
        return view('ibprandbowtie::livewire.ibpr-and-bowtie.master.list-hirarki')->layout('ibprandbowtie::layouts.ibpr-and-bowtie');
    }
}