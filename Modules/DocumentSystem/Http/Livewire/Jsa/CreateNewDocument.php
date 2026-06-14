<?php

namespace Modules\DocumentSystem\Http\Livewire\Jsa;

use App\Models\Company;
use App\Models\Department;
use App\Models\DepartmentCode;
use Modules\DocumentSystem\Entities\Category;
use Modules\DocumentSystem\Entities\Document;
use Modules\DocumentSystem\Entities\Mapping;
use Modules\DocumentSystem\Entities\Module;
use Modules\DocumentSystem\Entities\JsaDocument;
use App\Models\User;
use App\Rules\DocumentNumberRule;
use App\Rules\JsaDocumentNumberRule;
use App\Rules\JsaDocumentTitleRule;
use App\Rules\SopNumberRule;
use Modules\DocumentSystem\Services\DocumentSystemService;
use Modules\DocumentSystem\Services\JsaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateNewDocument extends Component
{
    use WithFileUploads, LivewireAlert;

    //define opiton value
    public $companies = [];
    public $departments = [];
    public $pics = [];
    public $modules = [];
    public $categories = [];
    public $mapping = [];
    public $users = [];
    public $documentTypes = [];
    public $deleted_id_media = [];
    public $id_maker;
    public $detail;
    public $template_form = '';
    public $template_win_number = '';
    public $template_form_number = '';
    public $template_document_number = '';
    public $company_code;
    public $department_code;
    public $show_children_form = false;
    public $parent_document_id;
    public $readonly = false; // this will be active when status document is preparing for rooting approval

    //define wire:model
    public $company_id;
    public $department_id;
    public $department_code_id;
    public $real_department_id;
    public $pic;
    public $module_id;
    public $category_id;
    public $mapping_id;
    public $upload_type;
    public $document_type;
    public $sop_number;
    public $win_number;
    public $document_number;
    public $form_number;
    public $title;
    public $invitedPeople = [];
    public $listEmployee = [];
    public $detail_location;
    public $notify_via_email = 0;
    public $user = [];
    public $description = '';
    public $doc_created = '';
    public $pjSelected = '';
    public $docs = [];
    public $inputInvited = '';
    public $file = '';
    public $tmp = [];

    public function mount()
    {
        $this->companies = Company::select('id', 'company_name', 'document_code')
            ->with(['departments:id,name,company_id,code', 'departments.codes'])->get();
        $this->modules = Module::select('id', 'name')->with(['categories:id,name,module_id', 'categories.mappings:id,name,category_id'])->get();
        $this->documentTypes = [
            Document::SOP_DOC_TYPE => trans('global.sop'),
            Document::TS_DOC_TYPE => trans('global.ts'),
            Document::MN_DOC_TYPE => trans('global.manual'),
        ];
    }

    // event listener
    protected $listeners = ['loading', 'saveData', 'showEmployee'];

    public function loading()
    {
        $this->dispatchBrowserEvent('loading-modal');
    }

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function showEmployee()
    {
        if ($this->company_id) {
            $this->listEmployee = User::whereHas('department', function ($query) {
                $query->whereHas('company', function ($q) {
                    $q->where('id', $this->company_id);
                });
            })->get();
        } else {
            $this->listEmployee = [];
        }

        $this->emit('employeeDataUpdated', $this->listEmployee);
    }

    /**
     * Function to watch any data after updated
     */
    public function updated($name, $value)
    {
        if (empty($value)) {
            if ($name == 'company_id') {
                $this->departments = [];
                $this->pics = [];
                $this->department_id = '';
                $this->pic = '';
                $this->company_code = '';
                $this->department_code = '';
            }
            if ($name == 'department_id') {
                $this->pic = '';
                $this->pics = [];
                $this->department_code = '';
            }
            return;
        }

        if ($name == 'company_id') {
            $this->departments = [];
            $this->pics = [];
            $this->department_id = '';
            $this->pic = '';
            $this->company_code = '';
            $this->department_code = '';

            $companies = $this->companies;
            $company = collect($companies)->filter(function ($item) use ($value) {
                return $item->id == $value;
            })->values()[0];
            $this->company_code = $company->document_code;
            $departments = $company->departments;
            $new_departs = [];
            foreach ($departments as $dept) {
                foreach ($dept->codes as $d) {
                    $new_departs[] = [
                        'id' => $d->id,
                        'name' => $dept->name . ' - ' . $d->code,
                    ];
                }
            }
            $this->departments = $new_departs;

            $this->showEmployee();
        }

        if ($name == 'department_id') {
            $this->pic = '';

            Cache::forget('peoples');

            $this->department_code_id = $value;
            $dept_code_data = DepartmentCode::select('department_id')
                ->find($this->department_id);
            $all_pic = Cache::remember('peoples', 600, function () use ($dept_code_data) {
                return User::select('id', 'name', 'email')
                    ->where('department_id', $dept_code_data->department_id)
                    ->get();
            });
            $this->real_department_id = $dept_code_data->department_id;
            $department = collect($this->departments)->filter(function ($item) use ($value) {
                return $item['id'] == $value;
            })->values()[0];
            $dept_name = $department['name'];
            $exp_dept = explode(' - ', $dept_name);
            $dept_code = $exp_dept[1];
            $this->department_code = $dept_code;
            $this->pics = $all_pic;
        }
    }

    public function render()
    {
        return view('documentsystem::livewire.jsa.create-new-document')
            ->extends('documentsystem::layouts.no-header');
    }

    public function addInvitedPeople($value = null)
    {
        $selected = $this->inputInvited;
        if ($value != "") {
            if ($value) {
                $selected = $value;
            }
            if (in_array($value, $this->invitedPeople)) {
                $this->dispatchBrowserEvent('swal', [
                    'title' => 'Notification',
                    'icon' => 'error',
                    'text'  => 'Email sudah ada'
                ]);
            } else {
                $this->invitedPeople[] = $value;
                $this->inputInvited = '';
            }
        } else {

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Notification',
                'icon' => 'error',
                'text'  => 'Tidak boleh kosong'
            ]);
        }
    }

    /**
     * Function to set invited people through javascript
     */
    public function setInvitedPeople()
    {
        return $this->dispatchBrowserEvent('setInvitedPeople');
    }

    public function removeInvited($email)
    {
        $key = array_search($email, $this->invitedPeople);
        unset($this->invitedPeople[$key]);
    }

    protected $rules = [
        'company_id' => 'required',
        'department_id' => 'required',
        'pic' => 'required',
        'module_id' => 'required',
        'category_id' => 'required',
        'mapping_id' => 'required',
        'upload_type' => 'required',
        'document_type' => 'required',
    ];

    private function validationRules()
    {
        $rules = [
            'company_id' => 'required',
            'department_id' => 'required',
            'pic' => 'required',
            'detail_location' => 'required',
            'document_number' => [
                'required',
                new JsaDocumentNumberRule($this->id_maker)
            ],
            'title' => [
                'required',
                new JsaDocumentTitleRule($this->id_maker),
            ],
            'doc_created' => 'required',
        ];

        return $rules;
    }

    protected $message = [
        '*.required' => 'The :attribute field is required',
    ];

    /**
     * Function to store new document
     */
    public function saveData($status = 2)
    {
        $status = $status['data']['inputAttributes']['value'];

        if (!empty($this->document_number)) {
            $doc = JsaDocument::where('document_number', $this->document_number)->where('status', JsaDocument::ACTIVE)->first();
            if ($doc) {
                $this->alert('error', 'Document Number Sudah Ada', [
                    'position' => 'top-end',
                    'timer' => 3000,
                    'toast' => true,
                ]);
            }
        }

        $data = $this->validate($this->validationRules(), $this->message);

        DB::beginTransaction();
        try {

            $data['peoples'] = $this->invitedPeople;
            $data['department_id'] = $this->real_department_id;
            $data['department_code_id'] = $this->department_code_id;
            $data['description'] = $this->description;
            $data['documents'] = array_values($this->tmp);
            $data['user_id'] = $this->pic;
            $data['status'] = $status;
            $data['is_notify_email'] = $this->notify_via_email == 'on' ? true : false;
            $data['doc_created'] = date('Y-m-d H:i:s', strtotime($this->doc_created));

            $data['created_by'] = auth()->id();
            $data['deleted_id_media'] = $this->deleted_id_media;
            $service = new JsaService();
            if ($this->id_maker) {
                $service->update($data, $this->id_maker);
            } else {
                unset($data['pic']);

                $service->store($data);
            }

            DB::commit();
            if (!$this->id_maker) {
                $this->resetExcept(['companies', 'modules']);
                $this->dispatchBrowserEvent('resetSummernote');
            }

            $this->flash('success', $status == 1 ? trans('global.success_add_document_review') : trans('global.success_add_document_draft'), [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('document-systems::jsa.active');
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->dispatchBrowserEvent('swal', [
                'title' => 'Failed',
                'icon' => 'error',
                'text' => env('APP_ENV') == 'local' ? $th->getMessage() . ' ' . $th->getLine() . ' ' . $th->getFile() : 'Failed to create new active document',
            ]);
        }
    }

    /**
     * Function to save temporary file
     */
    public function saveFile(Request $request)
    {
        $service = new JsaService();
        $upload = $service->temporary_upload($request);

        return response()->json($upload);
    }

    /**
     * Function to save data to state
     * @param array files
     */
    public function createdFiles($files)
    {
        if (!$files['error']) {
            $current = $this->tmp;
            array_push($current, $files['data']);
            $this->tmp = $current;
        } else {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Error',
                'icon' => 'error',
                'text' => 'Failed to upload file'
            ]);
        }
    }

    /**
     * Function to remove file before upload
     */
    public function removeFile($filename, $id_media = null)
    {
        if ($id_media) {
            $this->deleted_id_media[] = $id_media;
        }

        $current = $this->tmp;
        $names = collect($current)->pluck('name')->all();
        if (in_array($filename, $names)) {
            if (File::exists(public_path('storage/tmp/jsa/' . $filename))) {
                File::delete(public_path('storage/tmp/jsa/' . $filename));

                $new = collect($current)->filter(function ($item) use ($filename) {
                    return $item['name'] != $filename;
                })->all();

                $this->tmp = $new;
            }

            if ($id_media) {
                $new = collect($current)->filter(function ($item) use ($filename) {
                    return $item['name'] != $filename;
                })->all();

                $this->tmp = $new;
            }
        }
    }

    /**
     * Function to update / activate children form
     */
    public function update_children($document_id)
    {
        $this->show_children_form = true;
        $this->parent_document_id = $document_id;
        $this->template_win_number = 'WIN-' . $this->template_form;
        $this->template_form_number = 'F-' . $this->template_form;
    }

    /**
     * Function to show popup confirmation via javascript
     */
    public function confirmRooting($status)
    {
        if ($status == 1) {
            $textConfirm = "Are you sure want to save this document? once saved the document will be active and cannot be edited.";
        } else {
            $textConfirm = "Are you sure want to save this document as Draft?";
        }

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
            'text' => $textConfirm,
            'onConfirmed' => 'saveData',
            'inputAttributes' => [
                'value' => $status
            ],
        ]);
        // return $this->dispatchBrowserEvent('confirm-rooting-approval', $status);
    }
}
