<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Bowtie\Listing;

use App\Exports\IbprAndBowtie\BowtieExport;
use App\Models\DocumentSystem\Document;
use App\Models\IbprBowty\Bowtie;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BowtieList extends Component
{
    public $dataTables = [];
    public $itemSelected = [];
    public $availableCompany = [];
    public $availableDepartment = [];
    public $availablePics = [];
    public $availableModules = [];
    public $countSelected = 0;
    public $info = false;
    public $bowtie_status = 'Draft';

    public $columns = ['No Document', 'Perusahaan IUP', 'CCOW', 'Contractor', 'Subcontractor', 'Department', 'Penanggung Jawab', 'Tanggal Disetujui', 'Tanggal Revisi Berikutnya', 'Status'];
    public $selectedColumns = [];

    public $searchNumber;

    public function mount(Request $request)
    {
        $this->selectedColumns = $this->columns;

        $this->bowtie_status = $request->input('status');
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
                $data = Bowtie::find($ids[$a]);
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
        $query = Bowtie::select()->with([
            'ccow',
            'department',
            'section',
            'pjs.user',
            'pja',
            'teams'
        ])->when(!empty($this->searchNumber), function ($query) {
            $query->where('document_no', 'like', '%' . $this->searchNumber . '%');
        });

        $query->where('ccow_id', '!=', null);
        if ($this->bowtie_status === 'DONE') $query->where('status', 'Disetujui');
        elseif ($this->bowtie_status === 'ACTIVE') $query->where('status', '!=', 'Draft')->where('status', '!=', 'Temporary')->where('status', '!=', 'Disetujui');
        elseif ($this->bowtie_status === 'Draft') $query->where('status', 'DRAFT');
        elseif ($this->bowtie_status === 'Temporary') $query->where('status', 'Temporary');


        $data = $query->get();

        return view('ibprandbowtie::livewire.ibpr-and-bowtie.bowtie.list.list', compact('data'))->layout('ibprandbowtie::layouts.ibpr-and-bowtie');
    }

    public function listing(Request $request){
        $perPage = $request->input('per_page', 10);
        $data = Bowtie::paginate($perPage);

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

    public function export($id)
    {
        $bowtie = Bowtie::find($id);

        return Excel::download(new BowtieExport($bowtie), 'bowtie-export.xlsx');
    }
}
