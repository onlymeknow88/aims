<?php

namespace Modules\KPP\Http\Livewire\Rule;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\KPP\Entities\KppAgencyAuthority;
use Modules\KPP\Entities\KppRule;
use Modules\KPP\Entities\KppRuleFile;
use Modules\KPP\Entities\KppRuleType;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Edit extends Component
{

    use WithFileUploads, LivewireAlert;

    //define opiton value
    public $rule = [];
    public $agencyAuthorities = [];
    public $statuses = [];
    public $types = [];
    public $files_data = [];

    //define wire:model
    public $number = '';
    public $title = '';
    public $type = '';
    public $status = 'Terdaftar';
    public $agency_authority = '';
    public $approved_date = '';
    public $effective_date = '';
    public $description = '';
    public $document_type;

    public $files = [];
    public $oldFiles = [];
    public $temporaryFile;

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function mount(Request $request)
    {
        $this->rule = KppRule::find($request->id);
        $this->agencyAuthorities = KppAgencyAuthority::all();
        $this->types = KppRuleType::all();

        $this->number = $this->rule->number;
        $this->title = $this->rule->title;
        $this->type = $this->rule->rule_type_id;
        $this->status = $this->rule->status;
        $this->agency_authority = $this->rule->agency_authority_id;
        $this->approved_date = $this->rule->approved_date;
        $this->effective_date = $this->rule->effective_date;
        $this->description = $this->rule->description;
        $this->document_type = $this->rule->document_type;

        $this->oldFiles = $this->rule->files->toArray();
    }

    public function render()
    {
        return view('kpp::livewire.rule.edit')->extends('kpp::layouts.no-header');
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
        //$this->files = array_values($this->files);
    }

    public function deleteOldFile($id, $key)
    {
        try {
            DB::beginTransaction();
            KppRuleFile::find($id)->delete();
            DB::commit();

            unset($this->oldFiles[$key]);
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

    public function rules()
    {
        return [
            'number' => 'required|unique:kpp_rules,number,' . $this->rule->id,
            'title' => 'required',
            'type' => 'required',
            'status' => 'required',
            'agency_authority' => 'required',
            'approved_date' => 'required',
            'effective_date' => 'required',
            'document_type' => 'required'
        ];
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
                'is_draft' => $isDraft,
                'document_type' => $this->document_type,
            ];

            $this->rule->update($data);

            foreach ($this->files_data as $file) {
                //$fileExist = $this->rule->files()->where('name', $file['name'])->first();

                $path = 'kpp/rules/' . $this->rule->id;
                $full_path = Storage::disk('public')->putFileAs($path, $file['file'], $file['name']);
                $this->rule->files()->create([
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
}
