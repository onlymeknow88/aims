<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Maker;

use App\Models\DocumentSystem\Document;
use App\Models\IbprBowty\Ibpr;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

use function PHPUnit\Framework\throwException;

class TableMaker extends Component
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
    public $ibpr_status = 'DRAFT';

    // model
    public $no_document_search;

    public $searchNumber;

    public function mount(Request $request)
    {
        $this->selectedColumns = $this->columns;
        $this->ibpr_status = $request->input('status');
    }

    /**
     * Funciton to get available company
     * only displays company data that already has active documents
     * or with a status not equal to the draft.
     */

    public function render()
    {
        $query = Ibpr::select()->with([
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
        if ($this->ibpr_status === 'DONE') $query->where('status', 'Disetujui');
        elseif ($this->ibpr_status === 'ACTIVE') $query->where('status', '!=', 'DRAFT')->where('status' , '!=', 'Disetujui')->where('status', '!=', 'Temporary');
        elseif ($this->ibpr_status === 'DRAFT') $query->where('status', '=', 'DRAFT');
        elseif ($this->ibpr_status === 'Temporary') $query->where('status', '=', 'Temporary');

        $data = $query->get();
        return view('ibprandbowtie::livewire.ibpr-and-bowtie.maker.table-maker', compact('data'));
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
                $data = Ibpr::find($ids[$a]);
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
        $data = Ibpr::paginate($perPage);

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
