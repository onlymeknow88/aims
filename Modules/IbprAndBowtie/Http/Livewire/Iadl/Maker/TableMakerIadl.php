<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Iadl\Maker;

use App\Models\DocumentSystem\Document;
use App\Models\IbprBowty\Iadl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TableMakerIadl extends Component
{
    public $dataTables = [];
    public $itemSelected = [];
    public $selectedColumns = [];
    public $columns = ['No Document', 'CCOW', 'Contractor', 'Subcontractor', 'Department', 'Section', 'Penanggung Jawab', 'Tanggal Disetujui', 'Tanggal Revisi Berikutnya', 'Status'];
    public $availableCompany = [];
    public $availableDepartment = [];
    public $availablePics = [];
    public $availableModules = [];
    public $countSelected = 0;
    public $info = false;
    public $iadl_status = 'DRAFT';

    // model
    public $no_document_search;

    public $searchNumber;

    public function mount(Request $request)
    {
        $this->iadl_status = $request->input('status');
        $this->selectedColumns = $this->columns;
    }

    /**
     * Funciton to get available company
     * only displays company data that already has active documents
     * or with a status not equal to the draft.
     */

    public function render()
    {
        $query = Iadl::select()->with([
            'ccow',
            'department',
            'section',
            'pjs.user',
            'pja',
            'teams.user'
        ])->when(!empty($this->searchNumber), function ($query) {
            $query->where('document_no', 'like', '%' . $this->searchNumber . '%');
        });

        $query->where('ccow_id', '!=', null);
        if ($this->iadl_status === 'ACTIVE') $query->where('status', '!=', 'DRAFT')->where('status', '!=', 'Disetujui');
        elseif ($this->iadl_status === 'DONE') $query->where('status', 'Disetujui');
        elseif ($this->iadl_status === 'Draft') $query->where('status', 'DRAFT');


        $data = $query->get();

        return view('ibprandbowtie::livewire.ibpr-and-bowtie.iadl.maker.table-maker-iadl', compact('data'));
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

    public function activedInfo(){
        $this->info = !$this->info;
    }

    public function removeSeleced(){
        $this->itemSelected = [];
        $this->countSelected = 0;
    }

    /**
     * Function to show confirmation modal before delete
     */
    public function confirmDelete()
    {
        $this->dispatchBrowserEvent('confirm-delete');
    }

    /**
     * Function to submit delete the selected data
     */
    public function submitDelete()
    {
        DB::beginTransaction();
        try {
            $ids = array_values($this->itemSelected);
            for ($a = 0; $a < count($ids); $a++) {
                $data = Iadl::find($ids[$a]);
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

    public function listing(Request $request){
        $perPage = $request->input('per_page', 10);
        $data = Iadl::paginate($perPage);

        return response()->json([
            'status' => 'success',
            'message' => 'data retrieved successfully',
            'data' => $data->items(),
            'pagination' => [
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage()
            ]
        ]);
    }
}
