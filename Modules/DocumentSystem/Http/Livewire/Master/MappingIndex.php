<?php

namespace Modules\DocumentSystem\Http\Livewire\Master;

use Livewire\Component;
use App\Rules\MappingNameRule;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Modules\DocumentSystem\Entities\Mapping;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Modules\DocumentSystem\Entities\Category;
use Modules\DocumentSystem\Entities\Document;

class MappingIndex extends Component
{
    use LivewireAlert;

    // global variables
    public $selected_rows = [];
    public $countSelected = 0;
    public $categories = [];
    public $selectAll = false;
    public int $limit = 0;

    // model attributes
    public string $name = '';
    public string $category_id  = '';
    public string $mapping_index = '';

    // rules
    protected $rules = [
        'name' => 'required',
    ];

    protected $listeners = ['submitBulkDelete', 'submitDelete'];

    public function mount()
    {
        $categories = Category::all_related_data();
        $this->categories = $categories;
    }

    public function hydrate()
    {
        $this->emit('select2');
    }

    private function validationRules($id = null)
    {
        $rule = [
            'name' => 'required',
            'category_id' => 'required',
            'mapping_index' => 'required',
        ];
        if ($id) {
            $rule = [
                'name' => 'required',
                'category_id' => 'required',
                'mapping_index' => 'required',
            ];
        }

        return $rule;
    }

    /**
     * Function to save new modules
     * @param string name
     */
    public function saveData($id = null)
    {
        $validate = $this->validate($this->validationRules($id), [
            'name.required' => trans('global.name_required'),
            'mapping_index.required' => trans('global.index_required'),
            'category_id.required' => trans('global.module_required'),
        ]);

        try {
            if ($id) {
                Mapping::updateData($validate, $id);
            } else {
                Mapping::store($validate);
            }
            $this->reset_form();
            $this->dispatchBrowserEvent('close-modal');

            $this->flash('success', 'Success create new module mapping', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('document-systems::master.mapping.index');
        } catch (\Throwable $th) {

            return $this->dispatchBrowserEvent('swal', [
                'icon' => 'warning',
                'title' => 'Error',
                'text' => env('APP_ENV') == 'local' ? $th->getMessage() . ' ' . $th->getLine() : trans('global.something_went_wrong'),
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
        $this->category_id = '';
    }

    public function getActiveListingsProperty(): LengthAwarePaginator
    {
        return Mapping::with('category:id,name')->orderBy('index', 'asc')->paginate($this->limit);
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
            $this->selected_rows = $this->activeListings->pluck('id')->map(fn ($id) => (string) $id);
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
     * Function to open modal to create category
     */
    public function createMapping()
    {
        $this->dispatchBrowserEvent('updateModalAttribute', [
            'type' => 'create',
        ]);
    }

    /**
     * Function to manipulate current model attribute
     * @param string id
     */
    public function editMapping($id)
    {
        $data = Mapping::select('name', 'category_id', 'index')
            ->with('category:id')
            ->find($id);
        if ($data) {
            $this->name = $data->name;
            $this->category_id = $data->category->id;
            $this->mapping_index = implode(' ', explode('_', $data->index));
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
        $data = Mapping::find($id);
        $check = Document::select('id')
            ->where('mapping_id', $id)
            ->first();
        if ($check) {
            $this->flash('success', trans('global.failed_delete_relation'), [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return redirect()->route('document-systems::master.mapping.index');
        }

        if ($data->delete()) {
            $this->flash('success', trans('global.success_delete_mapping'), [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return redirect()->route('document-systems::master.mapping.index');
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
                $data = Mapping::find($ids[$a]);
                // check relation
                $check = Document::select('id')
                    ->where('mapping_id', $ids[$a])
                    ->latest()
                    ->first();
                if ($check) {
                    DB::rollBack();
                    $this->flash('success', trans('global.failed_delete_relation'), [
                        'position' => 'top-end',
                        'timer' => 3000,
                        'toast' => true,
                    ]);
                    return redirect()->route('document-systems::master.mapping.index');
                }

                $data->delete();
            }

            // reset selected rows
            DB::commit();
            $this->removeSeleced();

            $this->flash('success', trans('global.success_delete_mapping'), [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return redirect()->route('document-systems::master.mapping.index');
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
        $mappings = Mapping::with('category:id,name')->orderBy('index', 'asc')->get();
        return view('documentsystem::livewire.master.mapping-index', compact('mappings'))
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
}
