<?php

namespace App\Http\Livewire\DocumentSystems\Master;

use App\Models\DocumentSystem\Module;
use App\Models\Modules;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ModuleIndex extends Component
{
    // global variables
    public $selected_rows = [];
    public $countSelected = 0;

    // model attributes
    public $name;

    // rules
    protected $rules = [
        'name' => 'required|unique:modules,name',
    ];

    private function validationRules($id = null)
    {
        $rule = [
            'name' => 'required',
        ];
        if ($id) {
            $rule = [
                'name' => [
                    'required',
                    Rule::unique('modules', 'name')
                        ->ignore($id),
                ],
            ];
        }

        return $rule;
    }

    // public function updated($propertyName, $id)
    // {
    //     $this->validateOnly($propertyName, $this->validationRules($id), [
    //         'name.required' => trans('global.name_required'),
    //         'name.unique' => trans('global.name_unique'),
    //     ]);
    // }

    /**
     * Function to save new modules
     * @param string name
     */
    public function saveData($id = null)
    {
        $validate = $this->validate($this->validationRules($id), [
            'name.required' => trans('global.name_required'),
            'name.unique' => trans('global.name_unique'),
        ]);

        try {
            if ($id) {
                Module::updateData($validate, $id);
            } else {
                Module::store($validate);
            }
            $this->reset_form();
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('swal', [
                'icon' => 'success',
                'title' => trans('global.success'),
                'text' => trans('global.success_add_module'),
            ]);

        } catch (\Throwable $th) {

            return $this->dispatchBrowserEvent('swal', [
                'icon' => 'warning',
                'title' => 'Error',
                'text' => env('APP_ENV') == 'local' ? $th->getMessage() : trans('global.something_went_wrong'),
            ]);
        }
    }

    /**
     * Function to empty all input field
     *
     */
    public function reset_form()
    {
        $this->name = '';
    }

    /**
     * Function to manipulate selected table rows
     */
    public function selectTable($id)
    {
        if(in_array($id, $this->selected_rows)){
            $key = array_search($id, $this->selected_rows);
            unset($this->selected_rows[$key]);
            $this->countSelected--;
        }else{
            $this->selected_rows[] = $id;
            $this->countSelected++;
        }
    }

    /**
     * Function to remove all selected rows and reset states
     */
    public function removeSeleced(){
        $this->selected_rows = [];
        $this->countSelected = 0;
    }

    /**
     * Function to manipulate current model attribute
     * @param string id
     */
    public function editModule($id)
    {
        $data = Module::select('name')
            ->find($id);
        if ($data) {
            $this->name = $data->name;
        }

        $this->dispatchBrowserEvent('updateModalAttribute', [
            'type' => 'edit',
            'id' => $id,
        ]);
    }

    /**
     * Function to show box confirmation to delete item
     */
    public function confirmDelete($id)
    {
        $this->dispatchBrowserEvent('confirm-delete', $id);
    }

    /**
     * Function to show box confirmation to bulk delete item
     */
    public function confirmBulkDelete()
    {
        $this->dispatchBrowserEvent('confirmBulkDelete');
    }

    /**
     * Function to delete data
     *
     */
    public function submitDelete($id)
    {
        $data = Module::with('categories')->find($id);
        $categories = $data->categories;
        if (count($categories) > 0) {
            return $this->notif('error', trans('global.failed_delete_relation'));
        }

        if ($data->delete()) {
            return $this->dispatchBrowserEvent('swal', [
                'title' => trans('global.success'),
                'icon' => 'success',
                'text' => trans('global.success_delete_module'),
            ]);
        }
    }

    /**
     * Function to bulk delete selected modules
     *
     */
    public function submitBulkDelete()
    {
        DB::beginTransaction();
        try {
            $ids = $this->selected_rows;
            $ids = array_values($ids);
            for ($a = 0; $a < count($ids); $a++) {
                $data = Module::with('categories')->find($ids[$a]);
                $categories = $data->categories;
                if (count($categories) > 0) {
                    DB::rollBack();
                    return $this->notif('error', trans('global.failed_delete_relation'));
                }

                $data->delete();
            }

            // reset selected rows
            DB::commit();
            $this->removeSeleced();

            return $this->notif('success', trans('global.success_delete_module'));
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->notif('error', $th->getMessage());
        }
    }

    /**
     * Function to reset all error bags
     * Need to run this function when modal form is closed
     */
    public function clearErrorBag()
    {
        $this->resetErrorBag();
    }

    /**
     * Function to render view
     *
     * @return Renderable
     */
    public function render()
    {
        $modules = Module::with('categories')->get();
        return view('livewire.document-systems.master.module-index', compact('modules'));
    }

    /**
     * Function to send all type notification in this controller
     */
    private function notif($type, $message)
    {
        $icon = 'success';
        $title = trans('global.success');
        if ($type == 'error') {
            $icon = 'error';
            $title = trans('global.error');
        }

        return $this->dispatchBrowserEvent('swal', [
            'title' => $title,
            'icon' => $icon,
            'text' => $message,
        ]);
    }
}
