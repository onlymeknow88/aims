<?php

namespace Modules\KPP\Http\Livewire\Obedience;

use App\Enums\KPP\ExtractionStatus;
use App\Enums\KPP\ObedienceStatus;
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
use Modules\KPP\Entities\KppExtractionTransaction;
use Modules\KPP\Entities\KppObedience;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CreateExtraction extends Component
{
    use WithFileUploads, LivewireAlert;

    public $users = [];
    public $sections = [];
    public $articles = [];

    public $obedience;
    public $bidang = '';
    public $sub_bidang = '';
    public $responsible_id = '';
    public $section_id = '';
    public $compliance_level = '';
    public $sub_section = '';
    public $lampiran = '';
    public $content = '';
    public $disobedience = '';
    public $consequence = '';
    public $date = '';
    public $status = '';
    public $files = [];
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
        $this->obedience = KppObedience::find($request->obedience);

        $department_ids = Department::where('company_id', $this->obedience->company_id)->pluck('id');

        $this->sections = Section::whereIn('department_id', $department_ids)->get();
        $this->users = User::whereIn('department_id', $department_ids)->get();
        $this->articles = KppArticle::where('rule_id', $this->obedience->rule_id)->get();
    }

    public function render()
    {
        return view('kpp::livewire.obedience.create-extraction')->extends('kpp::layouts.no-header');
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

    protected $rules = [
        'bidang' => 'required',
        'sub_bidang' => 'required',
        'responsible_id' => 'required',
        'compliance_level' => 'required',
        'article_id' => 'required',
        'sub_section' => 'required',
        'section_id' => 'required',
        'content' => 'required',
        'disobedience' => 'required',
        'consequence' => 'required',
        'date' => 'required',
    ];

    public function generateNumber($code)
    {
        $existCode = KoProposal::where('number', 'like', '%'.$code.'%')->latest()->first();

        if ($existCode) {
            $number = substr($existCode->number, 4);
            $number = str_pad($number + 1, 3, '0', STR_PAD_LEFT);
            $number = $code . '-' . $number;
        } else {
            $number = $code . '-001';
        }

        return $number;
    }

    public function generateId()
    {
        $id = str_replace(' ', '', $this->obedience->company->company_name . '-' . date('Y') . '-' . date('m'));

        $exist = KppExtraction::where('id',  'like', '%'.$id.'%')->latest()->first();

        if ($exist) {
            $number = substr($exist->id, -3);
            $number = str_pad($number + 1, 3, '0', STR_PAD_LEFT);
            $number = $id . '-' . $number;
        } else {
            $number = $id . '-001';
        }

        return $number;
    }

    public function save($createAnother)
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
                'id' => $this->generateId(),
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
                'is_draft' => 1,
                'status' => ExtractionStatus::Draft()->value
            ];

            $extraction = KppExtraction::create($data);

            foreach ($this->files_data as $key => $file) {
                $path = 'kpp/files/extractions/' . $extraction->id;
                $full_path = Storage::disk('public')->putFileAs($path, $file['file'], $file['name']);
                $extraction->files()->create([
                    'file' => $full_path,
                    'size' => $file['size'],
                    'name' => $file['name'],
                    'type' => $file['extension']
                ]);
            }

            $this->obedience->update([
                'status' => ObedienceStatus::Draft()
            ]);

            DB::commit();

            $this->flash('success','Berhasil mengupdate data!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            if ($createAnother == 1) {
                return redirect(route('kpp::obediences.create-extraction', ['obedience' => $this->obedience->id]));
            }

            return redirect(route('kpp::obediences.detail', ['id' => $this->obedience->id]));
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

