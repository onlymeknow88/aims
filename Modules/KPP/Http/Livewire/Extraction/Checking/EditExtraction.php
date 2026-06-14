<?php

namespace Modules\KPP\Http\Livewire\Extraction\Checking;

use App\Enums\KPP\ExtractionStatus;
use App\Models\Department;
use App\Models\Section;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\KPP\Entities\KppArticle;
use Modules\KPP\Entities\KppExtraction;
use Modules\KPP\Entities\KppExtractionFile;
use Modules\KPP\Entities\KppExtractionTransaction;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EditExtraction extends Component
{
    use WithFileUploads, LivewireAlert;

    public $extraction = [];
    public $obedience = [];
    public $users = [];
    public $sections = [];

    public $bidang = '';
    public $sub_bidang = '';
    public $responsible_id = '';
    public $section_id = '';
    public $compliance_level = '';
    public $article = '';
    public $sub_section = '';
    public $lampiran = '';
    public $content = '';
    public $disobedience = '';
    public $consequence = '';
    public $date = '';
    public $status = '';
    public $files = [];
    public $oldFiles = [];
    public $temporaryFile;
    public $files_data = [];

    public $article_id = null;
    public string $new_article = "";

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function mount(Request $request)
    {
        $this->extraction = KppExtraction::find($request->id);
        $this->obedience = $this->extraction->obedience;

        $department_ids = Department::where('company_id', $this->obedience->company_id)->pluck('id');

        $this->sections = Section::whereIn('department_id', $department_ids)->get();
        $this->users = User::whereIn('department_id', $department_ids)->get();

        $this->bidang = $this->extraction->bidang;
        $this->sub_bidang = $this->extraction->sub_bidang;
        $this->responsible_id = $this->extraction->responsible_id;
        $this->section_id = $this->extraction->section_id;
        $this->compliance_level = $this->extraction->compliance_level;
        $this->article_id = $this->extraction->article_id;
        $this->sub_section = $this->extraction->sub_section;
        $this->lampiran = $this->extraction->lampiran;
        $this->content = $this->extraction->content;
        $this->disobedience = $this->extraction->disobedience;
        $this->consequence = $this->extraction->consequence;
        $this->date = $this->extraction->date;
        $this->status = $this->extraction->status;
        $this->oldFiles = $this->extraction->files->toArray();
        $this->articles = KppArticle::where('rule_id', $this->obedience->rule_id)->get();
    }

    public function render()
    {
        return view('kpp::livewire.extraction.checking.edit-extraction')->extends('kpp::layouts.no-header');
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
            KppExtractionFile::find($id)->delete();
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

    protected $rules = [
        'bidang' => 'required',
        'sub_bidang' => 'required',
        'responsible_id' => 'required',
        'compliance_level' => 'required',
        'article' => 'required',
        'sub_section' => 'required',
        'section_id' => 'required',
        'content' => 'required',
        'disobedience' => 'required',
        'consequence' => 'required',
        'date' => 'required',
    ];

    public function save()
    {
        $this->validate();
        try {
            DB::beginTransaction();

            if ($this->article_id === 'new') {
                $newArticle = KppArticle::create([
                    'rule_id' => $this->obedience->rule_id,
                    'name' => $this->new_article,
                ]);
            }

            $data = [
                'obedience_id' => $this->obedience->id,
                'bidang' => $this->bidang,
                'sub_bidang' => $this->sub_bidang,
                'responsible_id' => $this->responsible_id,
                'compliance_level' => $this->compliance_level,
                'article_id' => $this->article_id === 'new' ? $newArticle->id : $this->article_id,
                'sub_section' => $this->sub_section,
                'lampiran' => $this->lampiran,
                'section_id' => $this->section_id,
                'content' => $this->content,
                'disobedience' => $this->disobedience,
                'consequence' => $this->consequence,
                'date' => Carbon::parse($this->date)->format('Y-m-d'),
            ];

            $this->extraction->update($data);

            foreach ($this->files_data as $key => $file) {
                $path = 'kpp/files/extractions/' . $this->extraction->id;
                $full_path = Storage::disk('public')->putFileAs($path, $file['file'], $file['name']);
                $this->extraction->files()->create([
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

            return redirect(route('kpp::extractions.checking.detail', ['id' => $this->extraction->id]));
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

