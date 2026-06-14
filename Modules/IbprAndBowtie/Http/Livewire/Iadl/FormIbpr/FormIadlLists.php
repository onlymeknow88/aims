<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Iadl\FormIbpr;

use App\Models\DocumentSystem\Document;
use App\Models\IbprBowty\IbprForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FormIadlLists extends Component
{

    public $title;
    public $dataTables = [];
    public $itemSelected = [];
    public $columns = [];
    public $availableCompany = [];
    public $availableDepartment = [];
    public $availablePics = [];
    public $availableModules = [];
    public $countSelected = 0;
    public $info = false;

    // model
    public $no_document_search;

    public function mount(Request $request)
    {
        // $this->availableData();
        $status = Document::availableStatus();
        $statuses = [];
        foreach ($status as $key => $s) {
            $statuses[] = [
                'id' => $key,
                'name' => $s,
            ];
        }
        $this->columns = [
            trans('NO DOCUMENT') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('CCOW') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('KRITERIA ANALISA') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('PERUSAHAAN') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('DEPARTMENT') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('SECTION') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('PENANGGUNG JAWAB RISIKO') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('TIM MANAGEMEN RISIKO') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('NOMOR REVISI') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('TANGGAL DISETUJUI') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('TANGGAL REVISI BERIKUTNYA') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('STATUS') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
            trans('ICON') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'no_document_search',
                'sortable' => true,
            ],
        ];
    }

    /**
     * Funciton to get available company
     * only displays company data that already has active documents
     * or with a status not equal to the draft.
     */

    public function render()
    {
      
        $query = IbprForm::select();
        $data = $query->get();

        return view('ibprandbowtie::livewire.ibpr-and-bowtie.ibpr-form.table-maker', compact('data'));
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
                $data = Document::find($ids[$a]);
                if ($data->status == Document::ACTIVE) {
                    DB::rollBack();

                    return $this->dispatchBrowserEvent('swal', [
                        'title' => 'Failed',
                        'icon' => 'error',
                        'text' => trans('global.failed_delete_active_document'),
                    ]);
                }

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
}
