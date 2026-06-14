<?php

namespace Modules\KPP\Http\Livewire\Rule;

use App\Enums\CompanyType;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\KPP\Entities\KppAgencyAuthority;
use Modules\KPP\Entities\KppRule;
use Modules\KPP\Entities\KppRuleType;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Create extends Component
{
    use WithFileUploads, LivewireAlert;

    public $agencyAuthorities = [];
    public $types = [];
    public $companies = [];
    public $users = [];

    public $number = '';
    public $title = '';
    public $type = '';
    public $status = 'Terdaftar';
    public $document_type;

    public $company = [];
    public $agency_authority = '';
    public $approved_date = '';
    public $effective_date = '';
    public $description = '';
    public $user = [];
    public $files = [];
    public $files_data = [];

    public $temporaryFile;
    protected $rules = [
        'number' => 'required|unique:kpp_rules',
        'title' => 'required',
        'type' => 'required',
        'status' => 'required',
        'agency_authority' => 'required',
        'approved_date' => 'required',
        'effective_date' => 'required',
        'document_type' => 'required'
    ];

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function mount()
    {
        $this->agencyAuthorities = KppAgencyAuthority::all();
        $this->companies = Company::where('type', CompanyType::Internal()->value)->get();
        $this->types = KppRuleType::all();
        $this->users = User::all();
    }

    public function updated($propertyName, $value)
    {
        if ($propertyName == 'temporaryFile') {
            if (is_object($value[0])) {
                $this->addFile();
            }
        }
    }

    public function addFile()
    {
        $this->files_data[] = [
            'file' => $this->temporaryFile[0],
            'name' => $this->temporaryFile[0]->getClientOriginalName(),
            'size' => $this->changeByte($this->temporaryFile[0]->getSize()),
            'extension' => $this->temporaryFile[0]->getClientOriginalExtension(),
        ];
    }

    public function changeByte($size)
    {
        $unit = array('b', 'Kb', 'Mb', 'Gb', 'Tb', 'Pb');
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }

    public function removeFile($index)
    {
        unset($this->files_data[$index]);
    }

    public function save($isDraft)
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $data = [
                'number' => $this->number,
                'title' => $this->title,
                'rule_type_id' => $this->type,
                'agency_authority_id' => $this->agency_authority,
                'approved_date' => Carbon::parse($this->approved_date)->format('Y-m-d'),
                'effective_date' => Carbon::parse($this->effective_date)->format('Y-m-d'),
                'description' => $this->description,
                'created_by' => Auth::user()->id,
                'status' => $this->status,
                'document_type' => $this->document_type,
                'is_draft' => $isDraft
            ];

            $rule = KppRule::create($data);

            foreach ($this->files_data as $file) {
                $path = 'kpp/rules/' . $rule->id;
                $full_path = Storage::disk('public')->putFileAs($path, $file['file'], $file['name']);
                $rule->files()->create([
                    'file' => $full_path,
                    'size' => $file['size'],
                    'name' => $file['name'],
                    'type' => $file['extension']
                ]);
            }

            DB::commit();

            $this->flash('success','Berhasil mengupdate data!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            if ($isDraft == 1) {
                return redirect()->route('kpp::rules.draft');
            }

            return redirect()->route('kpp::rules.index');
        } catch (\Exception $exception) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Gagal',
                'icon' => 'error',
                'text' => json_encode([
                    'message' => $exception->getMessage(),
                    'line' => $exception->getMessage(),
                    'code' => $exception->getCode(),
                    'file' => $exception->getFile(),
                ])
            ]);
            return false;
        }
    }

    public function render()
    {
        return view('kpp::livewire.rule.create')->extends('kpp::layouts.no-header');
    }
}

