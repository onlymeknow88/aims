<?php

namespace App\Http\Livewire\DocumentSystems\Obsolate;

use App\Models\DocumentSystem\Document;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    public $columns;
    public $availableCompany;
    public $availableDepartment;
    public $availablePics;
    public $availableModules;
    public $countSelected;
    public $itemSelected = [];

    public function mount()
    {
        $this->availableData();
        $status = Document::availableStatus();
        $statuses = [];
        foreach ($status as $key => $s) {
            $statuses[] = [
                'id' => $key,
                'name' => $s,
            ];
        }
        $this->columns = [
            trans('global.title') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'title_search',
                'sortable' => true,
            ],
            trans('global.id_document') => [
                'filter' => true,
                'type' => 'text',
                'model' => 'id_doc_search',
                'sortable' => true,
            ],
            trans('global.company') => [
                'filter' => true,
                'type' => 'select',
                'model' => 'company_search',
                'sortable' => false,
                'option' => $this->availableCompany,
            ],
            trans('global.department') => [
                'filter' => true,
                'type' => 'select',
                'model' => 'department_search',
                'sortable' => false,
                'option' => $this->availableDepartment,
            ],
            trans('global.pic') => [
                'filter' => true,
                'type' => 'select',
                'model' => 'pic_search',
                'sortable' => false,
                'option' => $this->availablePics,
            ],
            trans('global.module') => [
                'filter' => true,
                'type' => 'select',
                'model' => 'module_search',
                'sortable' => false,
                'option' => $this->availableModules,
            ],
            trans('global.date_created') => [
                'filter' => true,
                'type' => 'datepicker',
                'model' => 'date_created_search',
                'sortable' => false,
            ],
            trans('global.status') => [
                'filter' => true,
                'type' => 'select',
                'model' => 'status_search',
                'sortable' => false,
                'option' => $statuses,
            ],
        ];
    }

    /**
     * Funciton to get available company
     * only displays company data that already has active documents
     * or with a status not equal to the draft.
     */
    private function availableData()
    {
        $data = Document::select('id', 'department_id', 'mapping_id')
            ->with([
                'department:id,company_id,name',
                'department.company:id,company_name',
                'mapping:id,name,category_id',
                'mapping.category:id,name,module_id',
                'mapping.category.module:id,name',
            ])
            ->exceptDraft()
            ->get();

        $companies = [];
        $departments = [];
        $pics = [];
        $modules = [];
        if (count($data) > 0) {
            foreach($data as $item) {
                $companies[] = [
                    'id' => $item->department->company->id,
                    'name' => $item->department->company->company_name,
                ];

                $departments[] = [
                    'id' => $item->department_id,
                    'name' => $item->department->name,
                ];

                $user = User::select('id', 'name')
                    ->where('department_id', $item->department_id)
                    ->first();
                $pics[] = [
                    'id' => $user->id,
                    'name' => $user->name,
                ];

                $modules[] = [
                    'id' => $item->mapping->category->module->id,
                    'name' => $item->mapping->category->module->name,
                ];
            }
        }

        $this->availableCompany = array_map("unserialize", array_unique(array_map("serialize", $companies)));;
        $this->availableDepartment = array_map("unserialize", array_unique(array_map("serialize", $departments)));;
        $this->availablePics = array_map("unserialize", array_unique(array_map("serialize", $pics)));;
        $this->availableModules = array_map("unserialize", array_unique(array_map("serialize", $modules)));;
    }

    public function render()
    {
        $select = [
            'id', 'title', 'department_id', 'user_id', 'mapping_id',
            'doc_created', 'document_number', 'sop_number', 'status',
            'document_level', 'sop_add_win', 'sop_add_form',
        ];
        $query = Document::select($select)
            ->with([
                'department:id,name,company_id',
                'department.company:id,company_name',
                'user:id,name', 'mapping:id,name,category_id',
                'mapping.category:id,name,module_id',
                'mapping.category.module:id,name',
            ]);
        $query->where('status', Document::EXPIRED);

        $data = $query->get();
        return view('livewire.document-systems.obsolate.index', compact('data'));
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
