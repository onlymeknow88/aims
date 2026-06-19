<?php

namespace Modules\CSMS\Http\Livewire\Pjo\Active;

use Storage;
use Carbon\Carbon;
use App\Models\Company;
use Livewire\Component;
use PDF;
use App\Enums\CompanyType;
use Livewire\WithFileUploads;
use App\Enums\CSMS\CsmsStatus;
use Illuminate\Support\Facades\DB;
use Modules\CSMS\Entities\CsmsPjo;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Modules\CSMS\Entities\Bidding;

class Edit extends Component
{
    use WithFileUploads, LivewireAlert;

    public $pjo;
    public $company_id;
    public $criteria;
    public $ccow_id;
    public $submission;
    public $number_pjo;
    public $name;
    public $date_of_birth;
    public $phone;
    public $email;
    public $temporaryFile;
    public $competency_file;
    public $other_file;
    public $cv_file;
    public $appoinment_file;
    public $organizational_file;
    public $administration_file;
    public $commitment_file;
    public $date_submission;
    public $date_approved;
    public $comment;
    public $status;
    public $published;
    public $created_by;

    public $files = [];

    public function mount($id)
    {
        $this->pjo = CsmsPjo::find($id);

        $this->company_id = $this->pjo->company_id;
        $this->criteria = $this->pjo->criteria;
        $this->ccow_id = $this->pjo->ccow_id;
        $this->submission = $this->pjo->submission;
        $this->number_pjo = $this->pjo->number_pjo;
        $this->name = $this->pjo->name;
        $this->date_of_birth = $this->pjo->date_of_birth;
        $this->phone = $this->pjo->phone;
        $this->email = $this->pjo->email;
        $this->date_submission = $this->pjo->date_submission;
        $this->date_approved = $this->pjo->date_approved;
        $this->comment = $this->pjo->comment;
        $this->status = $this->pjo->status;
        $this->published = $this->pjo->published;
        $this->created_by = $this->pjo->created_by;

        $this->files = $this->pjo->files->groupBy('type')->toArray();
    }

    public function hydrate()
    {
        $this->emit('select2');
        $this->emit('datetimepicker-input');
    }

    public function getBiddingCompaniesProperty()
    {
        return Bidding::whereIn('criteria', [CsmsStatus::PostBidding, CsmsStatus::Renewal])->where('status', CsmsStatus::Approved)->get();
    }

    public function getCcowsProperty()
    {
        return Company::where('type', CompanyType::Contractor)->get();
    }

    public function addFile($type)
    {
        $this->files[$type][] = [
            'file' => $this->temporaryFile[$type][0],
            'name' => $this->temporaryFile[$type][0]->getClientOriginalName(),
            'size' => $this->changeByte($this->temporaryFile[$type][0]->getSize()),
            'extension' => $this->temporaryFile[$type][0]->getClientOriginalExtension(),
        ];
    }

    public function removeFile($type, $fileIndex)
    {
        if (isset($this->files[$type][$fileIndex])) {
            // Hapus elemen dengan array_splice
            array_splice($this->files[$type], $fileIndex, 1);
        }
        $this->files[$type] = array_values($this->files[$type]);
    }

    public function changeByte($size)
    {
        $unit = array('b', 'Kb', 'Mb', 'Gb', 'Tb', 'Pb');
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }

    public function updated($propertyName, $value)
    {
        if ($propertyName == 'company_id') {
            $this->company_id = $value;
            $comp = Bidding::find($value);
            $this->criteria = $comp->service_criteria->value;
            $this->ccow_id = $comp->company_id;

            $this->number_pjo = $this->generateNumber();
        }

        if (explode('.', $propertyName)[0] == 'temporaryFile') {
            $this->addFile(explode('.', $propertyName)[1]);
        }
    }

    public function generateNumber()
    {
        $count = CsmsPjo::count();
        $company = Bidding::find($this->company_id);
        $formattedNumber = str_pad($count + 1, 4, '0', STR_PAD_LEFT);
        $date = Carbon::today()->format('mY');

        $result = $formattedNumber . '-PJO-' . $company->ccow->document_code . '-' . $company->company_name . '-' . $date;

        while (CsmsPjo::where('number_pjo', $result)->exists()) {
            $count++;
            $formattedNumber = str_pad($count + 1, 4, '0', STR_PAD_LEFT);
            $result = $formattedNumber . '-PJO-' . $company->ccow->document_code . '-' . $company->company_name . '-' . $date;
        }

        return $result;
    }

    public function exportAdministration()
    {
        $company = Bidding::find($this->company_id);

        $data = [
            'date' => Carbon::now()->format('d F Y'),
            'number_pjo' => $this->number_pjo,
            'name' => $this->name,
            'company' => $company->company_name,
        ];

        if (empty($this->number_pjo)) {
            $this->alert('error', 'Number PJO Belum Terisi', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return false;
        }

        if (empty($this->name)) {
            $this->alert('error', 'Name Belum Terisi', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return false;
        }

        $pdfContent = PDF::loadView('csms::livewire.pjo.pdf.persyaratan-administratif', ['data' => $data])->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "persyaratan-administratif.pdf"
        );
    }

    public function exportCommitment()
    {
        $company = Bidding::find($this->company_id);

        $data = [
            'date' => Carbon::now()->format('d F Y'),
            'number_pjo' => $this->number_pjo,
            'name' => $this->name,
            'company' => $company->company_name,
        ];

        if (empty($this->number_pjo)) {
            $this->alert('error', 'Number PJO Belum Terisi', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return false;
        }

        if (empty($this->name)) {
            $this->alert('error', 'Name Belum Terisi', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return false;
        }

        $pdfContent = PDF::loadView('csms::livewire.pjo.pdf.surat-pernyataan', ['data' => $data])->output();
        return response()->streamDownload(
            fn () => print($pdfContent),
            "surat-pernyataan.pdf"
        );
    }

    protected function rules()
    {
        return [
            'company_id' => 'required',
            'criteria' => 'required',
            'ccow_id' => 'required',
            'submission' => 'nullable',
            'number_pjo' => 'nullable',
            'name' => 'required',
            'date_of_birth' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'temporaryFile.competency_file' => 'nullable',
            'temporaryFile.other_file' => 'nullable',
            'temporaryFile.cv_file' => 'nullable',
            'temporaryFile.appoinment_file' => 'nullable',
            'temporaryFile.organizational_file' => 'nullable',
            'temporaryFile.administration_file' => 'nullable',
            'temporaryFile.commitment_file' => 'nullable',
            'date_submission' => 'nullable',
            'date_approved' => 'nullable',
            'comment' => 'nullable',
            'status' => 'nullable',
            'published' => 'nullable',
            'created_by' => 'nullable',
        ];
    }

    public function saved($published)
    {
        try {
            $rules = [
                'company_id' => 'required',
                'criteria' => 'required',
                'name' => 'required',
                'date_of_birth' => 'required',
                'phone' => 'required',
                'email' => 'required',
            ];
            $messages = [
                'company_id.required' => 'Company harus dipilih.',
                'criteria.required' => 'Kriteria harus diisi.',
                'ccow_id.required' => 'CCOW harus diisi.',
                'name.required' => 'Nama PJO harus diisi.',
                'date_of_birth.required' => 'Tanggal lahir harus diisi.',
                'phone.required' => 'Nomor telepon harus diisi.',
                'email.required' => 'Email harus diisi.',
            ];
            $company = Bidding::find($this->company_id);
            if ($company && isset($company->type) && $company->type == 'subcontractor') {
                $rules['ccow_id'] = 'required';
            }
            $this->validate($rules, $messages);

            DB::beginTransaction();

            $pjo = $this->pjo;

            $pjo->update([
                'company_id' => $this->company_id,
                'criteria' => $this->criteria,
                'ccow_id' => $this->ccow_id,
                'submission' => $this->submission,
                'number_pjo' => $this->number_pjo,
                'name' => $this->name,
                'date_of_birth' => Carbon::parse($this->date_of_birth)->format('Y-m-d'),
                'phone' => $this->phone,
                'email' => $this->email,
                'date_submission' => Carbon::parse($this->date_submission)->format('Y-m-d'),
                'date_approved' => Carbon::parse($this->date_approved)->format('Y-m-d'),
                'comment' => $this->comment,
                'status' => CsmsStatus::Open,
                'published' => $published,
                'created_by' => auth()->user()->id,
            ]);

            if (!empty($this->file)) {
                $pjo->files()->delete();

                if (!empty($this->file['competency_file'])) {
                    foreach ($this->files['competency_file'] as $file) {
                        if (!is_object($file['file'])) {
                            $full_path = $file['file'];
                        } else {
                            $path = 'csms/' . $pjo->id . '/competency_file/';
                            $full_path = Storage::disk('public')->putFileAs($path, $file['file'], $file['name']);
                        }

                        $pjo->files()->create([
                            'type' => 'competency_file',
                            'file' => $full_path,
                            'name' => $file['name'],
                            'size' => $file['size'],
                            'extension' => $file['extension'],
                        ]);
                    }
                }

                if (!empty($this->file['other_file'])) {
                    foreach ($this->files['other_file'] as $file) {
                        if (!is_object($file['file'])) {
                            $full_path = $file['file'];
                        } else {
                            $path = 'csms/' . $pjo->id . '/other_file/';
                            $full_path = Storage::disk('public')->putFileAs($path, $file['file'], $file['name']);
                        }

                        $pjo->files()->create([
                            'type' => 'other_file',
                            'file' => $full_path,
                            'name' => $file['name'],
                            'size' => $file['size'],
                            'extension' => $file['extension'],
                        ]);
                    }
                }

                if (!empty($this->file['cv_file'])) {
                    foreach ($this->files['cv_file'] as $file) {
                        if (!is_object($file['file'])) {
                            $full_path = $file['file'];
                        } else {
                            $path = 'csms/' . $pjo->id . '/cv_file/';
                            $full_path = Storage::disk('public')->putFileAs($path, $file['file'], $file['name']);
                        }

                        $pjo->files()->create([
                            'type' => 'cv_file',
                            'file' => $full_path,
                            'name' => $file['name'],
                            'size' => $file['size'],
                            'extension' => $file['extension'],
                        ]);
                    }
                }

                if (!empty($this->file['appoinment_file'])) {
                    foreach ($this->files['appoinment_file'] as $file) {
                        if (!is_object($file['file'])) {
                            $full_path = $file['file'];
                        } else {
                            $path = 'csms/' . $pjo->id . '/appoinment_file/';
                            $full_path = Storage::disk('public')->putFileAs($path, $file['file'], $file['name']);
                        }

                        $pjo->files()->create([
                            'type' => 'appoinment_file',
                            'file' => $full_path,
                            'name' => $file['name'],
                            'size' => $file['size'],
                            'extension' => $file['extension'],
                        ]);
                    }
                }

                if (!empty($this->file['organizational_file'])) {
                    foreach ($this->files['organizational_file'] as $file) {
                        if (!is_object($file['file'])) {
                            $full_path = $file['file'];
                        } else {
                            $path = 'csms/' . $pjo->id . '/organizational_file/';
                            $full_path = Storage::disk('public')->putFileAs($path, $file['file'], $file['name']);
                        }

                        $pjo->files()->create([
                            'type' => 'organizational_file',
                            'file' => $full_path,
                            'name' => $file['name'],
                            'size' => $file['size'],
                            'extension' => $file['extension'],
                        ]);
                    }
                }

                if (!empty($this->file['administration_file'])) {
                    foreach ($this->files['administration_file'] as $file) {
                        if (!is_object($file['file'])) {
                            $full_path = $file['file'];
                        } else {
                            $path = 'csms/' . $pjo->id . '/administration_file/';
                            $full_path = Storage::disk('public')->putFileAs($path, $file['file'], $file['name']);
                        }

                        $pjo->files()->create([
                            'type' => 'administration_file',
                            'file' => $full_path,
                            'name' => $file['name'],
                            'size' => $file['size'],
                            'extension' => $file['extension'],
                        ]);
                    }
                }

                if (!empty($this->file['commitment_file'])) {
                    foreach ($this->files['commitment_file'] as $file) {
                        if (!is_object($file['file'])) {
                            $full_path = $file['file'];
                        } else {
                            $path = 'csms/' . $pjo->id . '/commitment_file/';
                            $full_path = Storage::disk('public')->putFileAs($path, $file['file'], $file['name']);
                        }

                        $pjo->files()->create([
                            'type' => 'commitment_file',
                            'file' => $full_path,
                            'name' => $file['name'],
                            'size' => $file['size'],
                            'extension' => $file['extension'],
                        ]);
                    }
                }

                if (!empty($this->files['approval_letter'])) {
                    foreach ($this->files['approval_letter'] as $file) {
                        $path = 'csms/' . $pjo->id . '/approval_letter/';
                        $filename = $file['name'];
                        $filePathTemp = $file['file']->getRealPath();
                        $blobResult = uploadToBlobStorage($filename, $filePathTemp, $path);

                        $full_path = $blobResult['fileBlobPathName'] ?? ($path . '/' . $filename);
                        $blobUrl = $blobResult['fileBlobUrl'] ?? null;
                        $blobResponse = $blobResult['blobResponse'] ? json_encode($blobResult['blobResponse']) : null;

                        $pjo->files()->create([
                            'type' => 'approval_letter',
                            'file' => $full_path,
                            'blob_url' => $blobUrl,
                            'blob_response' => $blobResponse,
                            'name' => $file['name'],
                            'size' => $file['size'],
                            'extension' => $file['extension'],
                        ]);
                    }
                }
            }

            DB::commit();

            $this->flash('success', 'Data berhasil di simpan!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('csms::pjo.index');
        } catch (\Throwable $err) {

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Error',
                'icon' => 'error',
                'text' => $err->getMessage(),
            ]);
        }
    }

    public function render()
    {
        return view('csms::livewire.pjo.active.edit')->extends('csms::layouts.no-header');
    }
}
