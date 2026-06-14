<?php

namespace App\Http\Livewire\DocumentSystems\Maker;

use App\Jobs\NotifyCreateDocument;
use App\Models\Company;
use App\Models\Department;
use App\Models\DocumentSystem\Category;
use App\Models\DocumentSystem\Document;
use App\Models\DocumentSystem\Mapping;
use App\Models\DocumentSystem\Module;
use Livewire\Component;
use App\Models\User;
use App\Rules\DocumentNumberRule;
use App\Rules\SopNumberRule;
use App\Services\DocumentSystemService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

use function PHPSTORM_META\map;

class AddnewMaker extends Component
{
    use WithFileUploads;

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
    public $company_code;
    public $department_code;

    //define wire:model
    public $company_id;
    public $department_id;
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
    public $notify_via_email = 0;
    public $user = [];
    public $description = '';
    public $doc_created='';
    public $pjSelected = '';
    public $docs = [];
    public $inputInvited = '';
    public $file = '';
    public $tmp = [];

    public function mount($id = null)
    {
        $this->companies = Company::select('id', 'company_name', 'document_code')
            ->with('departments:id,name,company_id,code')->get();
        $this->modules = Module::select('id', 'name')->with(['categories:id,name,module_id', 'categories.mappings:id,name,category_id'])->get();
        $this->documentTypes = [
            Document::SOP_DOC_TYPE => trans('global.sop'),
            Document::TS_DOC_TYPE => trans('global.ts'),
            Document::MN_DOC_TYPE => trans('global.manual'),
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
            $this->title = $detail->title;
            $this->department_id = $detail->department->id;
            $this->company_id = $detail->department->company->id;
            $company = Company::select('document_code', 'id')
                ->find($this->company_id);
            $company_code = $company->document_code;
            $department = Department::select('code')
                ->find($this->department_id);
            $department_code = $department->code;
            $this->template_form = $company_code . '-' . $department_code . '-';

            Cache::forget('peoples');
            $all_pic = Cache::remember('peoples', 600, function () {
                return User::select('id', 'name', 'email')
                    ->where('department_id', $this->department_id)
                    ->get();
            });
            $this->pics = $all_pic;

            $this->pic = $detail->user_id;

            $departments = Department::select('id', 'name', 'code')->where('company_id', $this->company_id)->get();
            $this->departments = $departments;
            $pics = User::select('id', 'name', 'email')->where('department_id', $this->department_id)->get();
            $this->pics = $pics;

            $this->module_id = $detail->mapping->category->module->id;
            $this->category_id = $detail->mapping->category->id;
            $this->mapping_id = $detail->mapping->id;
            $categories = Category::select('id', 'name')->where('module_id', $this->module_id)->get();
            $this->categories = $categories;
            $mappings = Mapping::select('id', 'name')->where('category_id', $this->category_id)->get();
            $this->mapping = $mappings;

            $this->upload_type = $detail->upload_type;
            $this->document_type = $detail->document_level;
            $this->sop_number = $detail->sop_number;
            $this->win_number = $detail->sop_add_win;
            $this->form_number = $detail->sop_add_form;
            $this->doc_created = date('m/d/Y', strtotime($detail->doc_created));

            if (count($detail->peoples) > 0) {
                $peoples = collect($detail->peoples)->pluck('email')->all();
                $this->invitedPeople = $peoples;
                $this->notify_via_email = collect($detail->peoples)->pluck('is_notify_email')->all()[0] == 1 ? 'on' : 'off';
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
        }
    }

    // event listener
    protected $listeners = ['loading'];

    public function loading()
    {
        $this->dispatchBrowserEvent('loading-modal');
    }

    public function hydrate()
    {
        $this->emit('select2');
    }

    /**
     * Function to watch any data after updated
     */
    public function updated($name, $value)
    {
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
            $departments = $company->departments;
            $this->company_code = $company->document_code;
            $this->departments = $departments;
        }

        if ($name == 'module_id') {
            $this->category_id = '';
            $this->mapping_id = '';

            $modules = $this->modules;
            $categories = collect($modules)->filter(function ($item) use ($value) {
                return $item->id == $value;
            })->pluck('categories')->all()[0];

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

            $all_pic = Cache::remember('peoples', 600, function () {
                return User::select('id', 'name', 'email')
                    ->where('department_id', $this->department_id)
                    ->get();
            });
            $department = collect($this->departments)->filter(function ($item) use ($value) {
                return $item->id == $value;
            })->values()[0];
            $this->department_code = $department->code;
            $this->pics = $all_pic;

            // set format document form
            $this->template_form = $this->company_code . '-' . $this->department_code . '-';
        }
    }

    public function render()
    {
        return view('livewire.document-systems.maker.addnew')
            ->extends('layouts.no-header');
    }

    public function addInvitedPeople($value = null)
    {
        $selected = $this->inputInvited;
        if ($value) {
            $selected = $value;
        }
        if(in_array($value, $this->invitedPeople)){
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Notification',
                'icon'=>'success',
                'text'  => 'Email sudah ada'
            ]);
        }else{
            $this->invitedPeople[] = $value;
            $this->inputInvited = '';
        }
    }

    /**
     * Function to set invited people through javascript
     */
    public function setInvitedPeople()
    {
        return $this->dispatchBrowserEvent('setInvitedPeople');
    }

    public function removeInvited($email){
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
            'sop_number' => [new SopNumberRule($this->document_type)],
            'document_number' => [new DocumentNumberRule($this->document_type)],
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
        DB::beginTransaction();
        try {
            $data = $this->validate($this->validationRules(), $this->message);
            $data['peoples'] = $this->invitedPeople;
            $data['description'] = $this->description;
            $data['documents'] = array_values($this->tmp);
            $data['user_id'] = $this->pic;
            $data['status'] = $status;
            $data['document_level'] = $this->document_type;
            $data['is_notify_email'] = $this->notify_via_email == 'on' ? true : false;
            $data['doc_created'] = date('Y-m-d', strtotime($this->doc_created));
            if ($this->document_type == Document::SOP_DOC_TYPE) {
                $data['sop_number'] = $this->sop_number;
            }
            if ($this->document_number == Document::MN_DOC_TYPE) {
                $data['document_number'] = $this->document_number;
            }
            if ($this->document_number == Document::TS_DOC_TYPE) {
                if ($this->win_number) {
                    $data['sop_add_win'] = $this->win_number;
                }
                if ($this->form_number) {
                    $data['sop_add_form'] = $this->form_number;
                }
            }
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

            session()->flash('success', $status == 1 ? trans('global.success_add_document_review') : trans('global.success_add_document_draft'));
            return redirect()->route('maker');
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

}
