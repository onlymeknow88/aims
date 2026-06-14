<?php

namespace Modules\DocumentSystem\Http\Livewire\Maker;

use App\Jobs\NotifyCreateDocument;
use App\Models\Company;
use App\Models\Department;
use App\Models\DepartmentCode;
use Modules\DocumentSystem\Entities\Category;
use Modules\DocumentSystem\Entities\Document;
use Modules\DocumentSystem\Entities\Mapping;
use Modules\DocumentSystem\Entities\Module;
use Livewire\Component;
use App\Models\User;
use App\Rules\DocumentNumberRule;
use App\Rules\SopNumberRule;
use Modules\DocumentSystem\Services\DocumentSystemService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;

use function PHPSTORM_META\map;

class AddnewMaker extends Component
{
    use WithFileUploads, LivewireAlert;

    //define opiton value
    public $document;
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
    public $has_document_number = false;
    public $showDocumentType = false;

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
    public $document_type = 0;
    public $category_number;
    public $sop_number;
    public $win_number;
    public $document_number;
    public $form_number;
    public $title;
    public $invitedPeople = [];
    public $listEmployee = [];
    public $notify_via_email = 0;
    public $user = [];
    public $description = '';
    public $doc_created = '';
    public $pjSelected = '';
    public $docs = [];
    public $inputInvited = '';
    public $file = '';
    public $tmp = [];
    public $status;
    public $activeSopNumbers;
    public $select_sop_number;
    public $errorMessageSop = '';

    public bool $showDepartmentHelp = false;

    public function toggleDepartmentHelp()
    {
        $this->showDepartmentHelp = ! $this->showDepartmentHelp;
    }

    public function mount($id = null)
    {
        $this->companies = Company::select('id', 'company_name', 'document_code')
            ->with(['departments:id,name,company_id,code', 'departments.codes'])->get();
        $this->modules = Module::select('id', 'index', 'name', 'has_document_number')->with(['categories:id,index,name,module_id', 'categories.mappings:id,index,name,category_id'])->get();

        $this->documentTypes = [
            Document::SOP_DOC_TYPE => trans('global.sop'),
            Document::TS_DOC_TYPE => trans('global.ts'),
            Document::MN_DOC_TYPE => trans('global.manual'),
            Document::WIN_DOC_TYPE => 'Working Instruction',
            Document::FORM_DOC_TYPE => 'Form',
        ];
        $this->users = [
            [
                'id' => 1,
                'name'  => 'User 1',
                'email' => 'sophie.walker@gmail.com',
                'avatar'    => ''
            ],
            [
                'id' => 2,
                'name'  => 'User 2',
                'email' => 'andrew.walsh@gmail.com'
            ],
            [
                'id' => 3,
                'name'  => 'User 3',
                'email' => 'joanne.young@gmail.com'
            ],
            [
                'id' => 4,
                'name'  => 'User 4',
                'email' => 'andrew.mackenzie@gmail.com'
            ]
        ];

        $this->id_maker = $id;
        if ($this->id_maker) {
            $service = new DocumentSystemService();
            $detail = $service->detail($this->id_maker);
            $attachments = $detail['attachments'];
            $activities = $detail['activities'];
            $detail = $detail['detail'];
            $this->document = $detail;
            $this->title = $detail->title;
            $this->department_id = $detail->department_code_id;
            $this->department_code_id = $detail->department_code_id;
            $this->real_department_id = $detail->department->id;
            $this->company_id = $detail->department->company->id;
            $company = Company::select('document_code', 'id')
                ->find($this->company_id);
            $company_code = $company->document_code;
            $department = Department::select('code')
                ->find($this->real_department_id);
            $department_code = $department->code;
            $this->template_form = $detail->prefix_code;
            $this->company_code = $company_code;
            $this->department_code = $department_code;
            if ($detail->parent_document) {
                $this->show_children_form = true;
                $this->parent_document_id = $detail->id;
                $this->template_win_number = $this->template_form;
                $this->template_form_number = $this->template_form;
            }

            Cache::forget('peoples');
            $all_pic = Cache::remember('peoples', 600, function () {
                return User::select('id', 'name', 'email')
                    ->where('department_id', $this->real_department_id)
                    ->get();
            });
            $this->pics = $all_pic;

            $this->pic = $detail->user_id;
            // $departments = Department::select('id', 'name', 'code')->where('company_id', $this->company_id)->get();
            // $this->departments = $departments;
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

            $pics = User::select('id', 'name', 'email')->where('department_id', $this->real_department_id)->get();
            $this->pics = $pics;

            $this->module_id = $detail->mapping->category->module->id;
            $module = Module::select('name')->find($this->module_id);

            if ($module->name == 'Dokumentasi') {
                $this->showDocumentType = true;
            } else {
                $this->showDocumentType = false;
            }

            $this->category_id = $detail->mapping->category->id;
            $this->mapping_id = $detail->mapping->id;
            $categories = Category::select('id', 'index', 'name')->where('module_id', $this->module_id)->get();
            $this->categories = $categories;
            $mappings = Mapping::select('id', 'index', 'name')->where('category_id', $this->category_id)->get();
            $this->mapping = $mappings;

            $this->upload_type = $detail->upload_type;
            $this->document_type = $detail->document_level;
            $this->sop_number = $detail->sop_number;
            $this->win_number = $detail->sop_add_win;
            $this->form_number = $detail->sop_add_form;
            $this->document_number = $detail->document_number;
            $this->doc_created = date('m/d/Y', strtotime($detail->doc_created));
            $this->status = $detail->status;

            $explode_prefix = explode('-', $detail->prefix_code);
            if ($explode_prefix[0] == 'F') {
                $this->category_number = 'FORM';
            }
            if ($explode_prefix[0] == 'WIN') {
                $this->category_number = 'WIN';
            }

            // document number template
            if ($this->document_type == Document::TS_DOC_TYPE || $this->document_type == Document::MN_DOC_TYPE) {
                $this->template_document_number = $detail->prefix_code;
            }

            if (count($detail->peoples) > 0) {
                $peoples = collect($detail->peoples)->pluck('user_id')->all();
                $this->invitedPeople = $peoples;
                $this->notify_via_email = collect($detail->peoples)->pluck('is_notify_email')->all()[0] == 1 ? 'on' : 'off';

                $this->listEmployee = User::whereHas('department', function ($query) {
                    $query->whereHas('company', function ($q) {
                        $q->where('id', $this->company_id);
                    });
                })->get();
            } else {
                $this->listEmployee = User::whereHas('department', function ($query) {
                    $query->whereHas('company', function ($q) {
                        $q->where('id', $this->company_id);
                    });
                })->get();
            }

            $this->description = $detail->description;

            $attachments = $detail->attachments;
            if (count($attachments) > 0) {
                $medias = [];
                for ($a = 0; $a < count($attachments); $a++) {
                    $medias[] = [
                        'id' => $attachments[$a]->id,
                        'ext' => $attachments[$a]->file_type,
                        'name' => $attachments[$a]->file_name,
                        'size' => $attachments[$a]->file_size,
                        'ext_icon' => $service->define_file_icon($attachments[$a]->file_type),
                    ];
                }
                $this->tmp = $medias;
            }

            $this->activeSopNumbers = Document::where('status', Document::ACTIVE)->where('prefix_code', $this->template_form)->get();
            if ($this->activeSopNumbers->count() > 0) {
                $this->select_sop_number = $this->activeSopNumbers->first()->id;
            }

            if ($module->name == 'Dokumentasi' && ($this->document_type == Document::SOP_DOC_TYPE || $this->document_type == Document::MN_DOC_TYPE || $this->document_type == Document::TS_DOC_TYPE)) {
                $this->readonly = true;
            } elseif ($this->document_type == Document::WIN_DOC_TYPE || $this->document_type == Document::FORM_DOC_TYPE) {
                $this->readonly = true;
            } elseif (!empty($detail->relatedDocumentNumber)) {
                $this->readonly = true;
            } else {
                $this->readonly = false;
            }
        }
    }

    // event listener
    protected $listeners = ['loading', 'showDocumentTypes', 'showEmployee'];

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
        // if ($name = 'sop_number') {
        //     $exist = Document::where('sop_number', $value)->first();

        //     if (!$exist) {
        //         $this->show_children_form = true;
        //     }
        // }

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

        if ($name == 'module_id') {
            $this->category_id = '';
            $this->mapping_id = '';
            $this->document_type = 0;
            $this->sop_number = '';
            $this->document_number = '';
            $this->form_number = '';
            $this->win_number = '';
            $this->show_children_form = false;

            $modules = $this->modules;
            $selected_module = collect($modules)->filter(function ($item) use ($value) {
                return $item->id == $value;
            })->values()[0];
            $this->has_document_number = $selected_module->has_document_number;
            $categories = $selected_module->categories;

            $this->categories = $categories;
        }

        if ($name == 'category_id') {
            $this->mapping_id = '';

            $categories = $this->categories;
            $mappings = collect($categories)->filter(function ($item) use ($value) {
                return $item->id == $value;
            })->pluck('mappings')->all()[0];
            $this->mapping = $mappings;
        }

        if ($name == 'department_id') {
            $this->pic = '';

            Cache::forget('peoples');

            $this->department_code_id = $value;
            $dept_code_data = DepartmentCode::select('department_id', 'code')
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
            $dept_code = '';
            if (!empty($department['name'])) {
                $exp_dept = explode(' - ', $department['name']);
                $dept_code = $exp_dept[1] ?? '';
            }

            // $this->department_code = $dept_code;
            $this->department_code = $dept_code_data->code;
            $this->pics = $all_pic;

            // set format document form
            $this->template_form = $this->company_code . '-' . $this->department_code . '-';
            if ($this->template_form) {
                $this->dispatchBrowserEvent('sop-autocomplete', [
                    'department_id' => $value,
                ]);
            }

            // set form for document number
            $this->create_document_number_prefix();
        }

        if ($name == 'document_type') {
            if ((int)$value == Document::SOP_DOC_TYPE && $this->department_id) {
                $this->dispatchBrowserEvent('sop-autocomplete', [
                    'department_id' => $this->department_id,
                ]);
            }

            if ((int)$value == Document::WIN_DOC_TYPE) {
                $this->show_children_form = true;
                $this->activeSopNumbers = Document::where('status', Document::ACTIVE)->where('prefix_code', $this->template_form)->get();
            }

            if ((int)$value == Document::FORM_DOC_TYPE) {
                $this->show_children_form = true;
                $this->activeSopNumbers = Document::where('status', Document::ACTIVE)->where('prefix_code', $this->template_form)->get();
            }

            $this->create_document_number_prefix();
        }

        if ($name == 'select_sop_number') {
            $this->sop_number = $this->activeSopNumbers->where('id', $value)->first()->sop_number;
            $this->show_children_form = true;

            $this->update_children($value);
        }
    }

    /**
     * Function to create template document number format
     */
    public function create_document_number_prefix()
    {
        if (
            $this->company_code &&
            $this->department_code &&
            $this->document_type == Document::TS_DOC_TYPE
        ) {
            $this->template_document_number = 'TS-' . $this->company_code . '-' . $this->department_code . '-';
        } else if (
            $this->company_code &&
            $this->department_code &&
            $this->document_type == Document::MN_DOC_TYPE
        ) {
            $this->template_document_number = $this->company_code . '-Manual-';
        }
    }

    public function render()
    {
        return view('documentsystem::livewire.maker.addnew')
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

    public function showDocumentTypes($value)
    {
        $module = Module::select('name')->find($value);

        if ($module->name == 'Dokumentasi') {
            $this->showDocumentType = true;
        } else {
            $this->showDocumentType = false;
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
            'module_id' => 'required',
            'category_id' => 'required',
            'mapping_id' => 'required',
            'upload_type' => 'required',
            'document_type' => 'required',
            'sop_number' => [new SopNumberRule($this->document_type, $this->has_document_number)],
            'document_number' => [new DocumentNumberRule($this->document_type, $this->has_document_number)],
            'title' => 'required',
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
        $data = $this->validate($this->validationRules(), $this->message);

        if (empty($this->document->relatedDocumentNumber)) {
            if (!empty($this->sop_number) && (empty($this->win_number) && empty($this->form_number))) {
                $doc = Document::where('sop_number', $this->sop_number)->where('prefix_code', $this->template_form)->where('status', Document::ACTIVE)->first();
                if ($doc) {
                    $this->alert('error', 'SOP Number Sudah Ada', [
                        'position' => 'top-end',
                        'timer' => 3000,
                        'toast' => true,
                    ]);

                    $this->errorMessageSop = 'SOP Number Sudah Ada';

                    return false;
                }
            }

            if (!empty($this->win_number)) {
                $doc = Document::where('sop_add_win', $this->win_number)->where('prefix_code', $this->template_form)->where('status', Document::ACTIVE)->first();
                if ($doc) {
                    $this->alert('error', 'WIN Number Sudah Ada', [
                        'position' => 'top-end',
                        'timer' => 3000,
                        'toast' => true,
                    ]);

                    $this->errorMessageSop = 'WIN Number Sudah Ada';

                    return false;
                }
            }

            if (!empty($this->form_number)) {
                $doc = Document::where('sop_add_form', $this->form_number)->where('prefix_code', $this->template_form)->where('status', Document::ACTIVE)->first();
                if ($doc) {
                    $this->alert('error', 'Form Number Sudah Ada', [
                        'position' => 'top-end',
                        'timer' => 3000,
                        'toast' => true,
                    ]);

                    $this->errorMessageSop = 'Form Number Sudah Ada';

                    return false;
                }
            }

            if (!empty($this->document_number)) {
                $doc = Document::where('document_number', $this->document_number)->where('status', Document::ACTIVE)->first();
                if ($doc) {
                    $this->alert('error', 'Document Number Sudah Ada', [
                        'position' => 'top-end',
                        'timer' => 3000,
                        'toast' => true,
                    ]);

                    $this->errorMessageSop = 'Document Number Sudah Ada';

                    return false;
                }
            }
        }

        DB::beginTransaction();
        try {

            $data['peoples'] = $this->invitedPeople;
            $data['department_id'] = $this->real_department_id;
            $data['department_code_id'] = $this->department_code_id;
            $data['description'] = $this->description;
            $data['documents'] = array_values($this->tmp);
            $data['user_id'] = $this->pic;
            $data['status'] = $status;
            $data['document_level'] = $this->document_type;
            $data['is_notify_email'] = $this->notify_via_email == 'on' ? true : false;
            $data['doc_created'] = date('Y-m-d', strtotime($this->doc_created));
            // if ($this->has_document_number) {
            if ($this->document_type == Document::SOP_DOC_TYPE || $this->document_type == Document::WIN_DOC_TYPE || $this->document_type == Document::FORM_DOC_TYPE) {
                $data['prefix_code'] = $this->showDocumentType ? $this->template_form : null;
                $data['sop_number'] = $this->sop_number;

                if ($this->win_number) {
                    $delimeterWin = "WIN-";
                    $prefix_code = explode($delimeterWin, $data['prefix_code']);

                    $data['prefix_code'] = $this->showDocumentType ? 'WIN-' . $this->template_form : null;
                    $data['sop_add_win'] = $this->win_number;
                    $data['parent_document'] = $this->parent_document_id;

                    $data['prefix_code'] = 'WIN-' . $prefix_code[1];
                }
                if ($this->form_number) {
                    $delimeterForm = "F-";
                    $prefix_code = explode($delimeterForm, $data['prefix_code']);

                    $data['prefix_code'] = $this->showDocumentType ? 'F-' . $this->template_form : null;
                    $data['sop_add_form'] = $this->form_number;
                    $data['parent_document'] = $this->parent_document_id;

                    $data['prefix_code'] = 'F-' . $prefix_code[1];
                }
            }
            if (
                $this->document_type == Document::MN_DOC_TYPE ||
                $this->document_type == Document::TS_DOC_TYPE
            ) {
                $data['prefix_code'] = $this->showDocumentType ? $this->template_document_number : null;
                $data['document_number'] = $this->document_number;
            }
            // }
            $data['created_by'] = auth()->id();
            $data['deleted_id_media'] = $this->deleted_id_media;


            $service = new DocumentSystemService();
            if ($this->id_maker) {
                $document = Document::select('status')
                    ->find($this->id_maker);

                /**
                 * Validate uploaded files when action came from 'prepare rooting approval
                 * Just accept pdf type
                 */
                if ($document->status == Document::PREPARE_ROOTING_REVIEW) {
                    $file_types = collect($this->tmp)->pluck('ext')->all();
                    if (
                        in_array('xlsx', $file_types) ||
                        in_array('xlx', $file_types) ||
                        in_array('doc', $file_types) ||
                        in_array('docx', $file_types) ||
                        in_array('jpg', $file_types) ||
                        in_array('jpeg', $file_types) ||
                        in_array('png', $file_types) ||
                        in_array('webp', $file_types) ||
                        in_array('ppt', $file_types) ||
                        in_array('pptx', $file_types)
                    ) {
                        return $this->dispatchBrowserEvent('swal', [
                            'icon' => 'error',
                            'title' => 'Failed',
                            'text' => trans('global.file_type_not_allowed') . ' ' . trans('global.pdf_allowed'),
                        ]);
                    }
                }

                /**
                 * If current status is 6 / PREPARE_ROOTING_REVIEW
                 * Then change status to 3 / ROOTING PREVIEW
                 */
                if ($document->status == Document::PREPARE_ROOTING_REVIEW) {
                    $data['status'] = Document::ROOTING_REVIEW;
                }

                $service->update($data, $this->id_maker);
            } else {
                unset($data['pic']);
                unset($data['document_type']);

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

            return redirect()->route('document-systems::ongoing');
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
        $service = new DocumentSystemService();
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
            if (File::exists(public_path('storage/tmp/document_systems/' . $filename))) {
                File::delete(public_path('storage/tmp/document_systems/' . $filename));

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
}
