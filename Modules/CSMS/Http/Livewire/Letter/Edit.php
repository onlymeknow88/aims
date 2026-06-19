<?php

namespace Modules\CSMS\Http\Livewire\Letter;

use App\Enums\CompanyType;
use App\Models\Company;
use Carbon\Carbon;
use DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\CSMS\Entities\CsmsLetter;
use Storage;

class Edit extends Component
{
    use WithFileUploads, LivewireAlert;

    public $letter;
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

    public function mount($id)
    {
        $this->letter = CsmsLetter::find($id);
        $this->company = Company::find($this->letter->ccow_id);

        $this->letter_number = $this->letter->letter_number;
        $this->title = $this->letter->title;
        $this->ccow_id = $this->letter->ccow_id;
        $this->ktt_id = $this->company->user->name;
        $this->date = $this->letter->date;
        $this->date_inactive = $this->letter->date_inactive;
        $this->description = $this->letter->description;
        $this->status = $this->letter->status;

        foreach ($this->letter->files as $key => $file) {
            $exp = explode('/', $file->file);

            $this->files[] = [
                'file' => $file->file,
                'name' => $exp[3],
                'size' => $file->size,
                'extension' => $file->file,
            ];
        }
    }

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

            $this->letter->update([
                'letter_number' => $this->letter_number,
                'title' => $this->title,
                'ccow_id' => $this->ccow_id,
                'ktt_id' => $this->company->user_id,
                'date' => Carbon::parse($this->date)->format('Y-m-d'),
                'date_inactive' => $this->date_inactive,
                'description' => $this->description,
                'status' => 'Active',
            ]);

            if (!empty($this->files)) {
                $this->letter->files()->delete();

                foreach ($this->files as $key => $file) {
                    if (!is_object($file['file'])) {
                        $full_path = $file['file'];
                        $blobUrl = null;
                        $blobResponse = null;
                    } else {
                        $path = 'csms/letter/' . $this->letter->id;
                        
                        $filename = $file['name'];
                        $filePathTemp = $file['file']->getRealPath();
                        $blobResult = uploadToBlobStorage($filename, $filePathTemp, $path);

                        $full_path = $blobResult['fileBlobPathName'] ?? ($path . '/' . $filename);
                        $blobUrl = $blobResult['fileBlobUrl'] ?? null;
                        $blobResponse = $blobResult['blobResponse'] ? json_encode($blobResult['blobResponse']) : null;
                    }

                    $this->letter->files()->create([
                        'file' => $full_path,
                        'blob_url' => $blobUrl,
                        'blob_response' => $blobResponse,
                        'size' => $file['size'],
                    ]);
                }
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
        return view('csms::livewire.letter.edit')->extends('csms::layouts.no-header');
    }
}
