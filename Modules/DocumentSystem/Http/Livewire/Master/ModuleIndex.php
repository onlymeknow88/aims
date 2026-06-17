<?php

namespace Modules\DocumentSystem\Http\Livewire\Master;

use App\Models\Modules;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Modules\DocumentSystem\Entities\Module;
use Modules\DocumentSystem\Imports\ModuleImport as ModuleImportJob;
use Livewire\WithFileUploads;

class ModuleIndex extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    // global variables
    public $selected_rows = [];
    public int $countSelected = 0;
    public $selectAll = false;
    public int $limit = 0;

    // model attributes
    public string $name = '';
    public string $module_index = '';

    // ── Import ──────────────────────────────
    public $importFile = null;
    public bool $importDone = false;
    public array $importErrors = [];


    // rules
    protected array $rules = [
        'name' => 'required',
        'index' => 'required',
    ];

    protected $listeners = ['submitBulkDelete', 'submitDelete'];

    private function validationRules($id = null): array
    {
        $rule = [
            'name' => 'required',
            'module_index' => 'required',
        ];
        if ($id) {
            $rule = [
                'name' => [
                    'required',
                ],
                'module_index' => [
                    'required',
                ]
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
     * @param $id
     */
    public function saveData($id = null)
    {
        $validate = $this->validate($this->validationRules($id), [
            'name.required' => trans('global.name_required'),
            'module_index.required' => trans('global.index_required'),
        ]);

        try {
            if ($id) {
                Module::updateData($validate, $id);
            } else {

                Module::store($validate);
            }
            $this->reset_form();
            $this->dispatchBrowserEvent('close-modal');

            $this->flash('success', trans('global.success_add_module'), [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('document-systems::master.index');
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
        $this->module_index = '';
    }

    public function getActiveListingsProperty(): LengthAwarePaginator
    {
        return Module::with('categories')->paginate($this->limit);
    }

    /**
     * Function to manipulate selected table rows
     */
    public function selectTable($id)
    {
        if (in_array($id, $this->selected_rows)) {
            $key = array_search($id, $this->selected_rows);
            unset($this->selected_rows[$key]);
            $this->countSelected--;
        } else {
            $this->selected_rows[] = $id;
            $this->countSelected++;
        }
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectAll = false;
        } else {
            $this->selectAll = true;
        }

        if (!$this->selectAll) {
            // Deselect all items
            $this->selected_rows = [];
            $this->selectAll = false;
            $this->countSelected = 0;
        } else {
            // Select all items
            $this->selected_rows = $this->activeListings->pluck('id')->map(fn($id) => (string) $id);
            $this->selectAll = true;
            $this->countSelected = $this->activeListings->count();

            $this->selected_rows = $this->selected_rows->toArray();
        }
    }

    /**
     * Function to remove all selected rows and reset states
     */
    public function removeSeleced()
    {
        $this->selected_rows = [];
        $this->countSelected = 0;
    }

    /**
     * Function to manipulate current model attribute
     * @param string id
     */
    public function editModule($id)
    {
        $data = Module::select('name', 'index')
            ->find($id);
        if ($data) {
            $this->name = $data->name;
            $this->module_index = implode(' ', explode('_', $data->index));
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
        $this->alert('question', 'Are You Sure ?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes',
            'confirmButtonColor' => '#00552F',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'cancelButtonColor' => '#d33',
            'timer' => 30000,
            'toast' => true,
            'timerProgressBar' => true,
            'position' => 'center',
            'text' => trans('global.confirm_delete'),
            'onConfirmed' => 'submitDelete',
            'inputAttributes' => [
                'value' => $id
            ],
        ]);
        // $this->dispatchBrowserEvent('confirm-delete', $id);
    }

    /**
     * Function to show box confirmation to bulk delete item
     */
    public function confirmBulkDelete()
    {
        $this->alert('question', 'Are You Sure ?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Yes',
            'confirmButtonColor' => '#00552F',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancel',
            'cancelButtonColor' => '#d33',
            'timer' => 30000,
            'toast' => true,
            'timerProgressBar' => true,
            'position' => 'center',
            'text' => trans('global.bulk_confirmation'),
            'onConfirmed' => 'submitBulkDelete',
        ]);
        // $this->dispatchBrowserEvent('confirmBulkDelete');
    }

    /**
     * Function to delete data
     *
     */
    public function submitDelete($id)
    {
        $id = $id['data']['inputAttributes']['value'];

        $data = Module::with('categories')->find($id);
        $categories = $data->categories;
        if (count($categories) > 0) {
            $this->flash('success', trans('global.failed_delete_relation'), [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return redirect()->route('document-systems::master.index');
        }

        if ($data->delete()) {
            $this->flash('success', trans('global.success_delete_module'), [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return redirect()->route('document-systems::master.index');
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
                    $this->flash('success', trans('global.failed_delete_relation'), [
                        'position' => 'top-end',
                        'timer' => 3000,
                        'toast' => true,
                    ]);
                    return redirect()->route('document-system.master.module');
                }

                $data->delete();
            }

            // reset selected rows
            DB::commit();
            $this->removeSeleced();

            $this->flash('success', trans('global.success_delete_module'), [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return redirect()->route('document-systems::master.index');
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
        $modules = Module::with('categories')->orderBy('index', 'asc')->get();
        return view('documentsystem::livewire.master.module-index', compact('modules'))
            ->layout('documentsystem::layouts.app');
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

    public function importModule()
    {
        $this->validate([
            'importFile' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ], [
            'importFile.required' => 'File wajib dipilih.',
            'importFile.mimes'    => 'Format file harus xlsx, xls, atau csv.',
        ]);

        $this->importErrors = [];
        $this->importDone   = false;

        try {
            $import = new ModuleImportJob();
            Excel::import($import, $this->importFile->getRealPath());

            foreach ($import->errors() as $error) {
                $this->importErrors[] = $error->getMessage();
            }

            $this->importDone = true;
            $this->importFile = null;

            $this->dispatchBrowserEvent('import-success');
        } catch (\Throwable $e) {
            $this->addError('importFile', 'Import gagal: ' . $e->getMessage());
        }
    }

    public function resetImport()
    {
        $this->importFile   = null;
        $this->importDone   = false;
        $this->importErrors = [];
        $this->resetErrorBag('importFile');
    }
}
