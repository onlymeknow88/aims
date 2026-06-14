<?php

namespace Modules\CSMS\Http\Livewire\Letter;

use App\Enums\CompanyType;
use App\Models\Company;
use DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\CSMS\Entities\CsmsLetter;
use Storage;

class Create extends Component
{
    use WithFileUploads, LivewireAlert;

    public $letter_number;
    public $title;
    public $ccow_id;
    public $company;
    public $ktt_id;
    public $date;
    public $date_inactive;
    public $files = [];
    public $temporaryFile;
    public $description;
    public $status;

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function getCompaniesProperty()
    {
        return Company::all();
    }

    public function getCcowsProperty()
    {
        return Company::where('type', CompanyType::Internal)->get();
    }

    public function addFile()
    {
        $this->files[] = [
            'file' => $this->temporaryFile[0],
            'name' => $this->temporaryFile[0]->getClientOriginalName(),
            'size' => $this->changeByte($this->temporaryFile[0]->getSize()),
            'extension' => $this->temporaryFile[0]->getClientOriginalExtension(),
        ];
    }

    public function removeFile($fileIndex)
    {
        unset($this->files[$fileIndex]);
        $this->files = array_values($this->files);
    }

    public function changeByte($size)
    {
        $unit = array('b', 'Kb', 'Mb', 'Gb', 'Tb', 'Pb');
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }

    public function updated($propertyName, $value)
    {
        if ($propertyName == 'ccow_id') {
            $this->company = Company::find($value);
            $this->ktt_id = $this->company->user->name;
        }

        if ($propertyName == 'temporaryFile') {
            $this->addFile();
        }
    }


    protected function rules(): array
    {
        return [
            'letter_number' => 'required',
            'title' => 'required',
            'ccow_id' => 'required',
            'ktt_id' => 'required',
            'date' => 'required',
            'files' => 'nullable',
            'description' => 'required',
        ];
    }

    public function saved()
    {
        try {
            $this->validate();

            DB::beginTransaction();

            $letter = CsmsLetter::create([
                'letter_number' => $this->letter_number,
                'title' => $this->title,
                'ccow_id' => $this->ccow_id,
                'ktt_id' => $this->company->user_id,
                'date' => $this->date,
                'date_inactive' => $this->date_inactive,
                'description' => $this->description,
                'status' => 'Active',
            ]);

            foreach ($this->files as $key => $file) {
                $path = 'csms/letter/' . $letter->id;
                $full_path = Storage::disk('public')->putFileAs($path, $file['file'], $file['name']);

                $letter->files()->create([
                    'file' => $full_path,
                    'size' => $file['size'],
                ]);
            }

            DB::commit();

            $this->flash('success', 'Data berhasil di simpan!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('csms::letter.index');
        } catch (\Throwable $err) {

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Error',
                'icon' => 'error',
                'text' => "Error | " . $err,
            ]);
        }
    }

    public function render()
    {
        return view('csms::livewire.letter.create')->extends('csms::layouts.no-header');
    }
}
