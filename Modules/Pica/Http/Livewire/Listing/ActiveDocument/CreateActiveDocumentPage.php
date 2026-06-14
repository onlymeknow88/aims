<?php

namespace Modules\Pica\Http\Livewire\Listing\ActiveDocument;

use App\Enums\CompanyType;
use App\Enums\FieldLeadership\FieldLeadershipType;
use App\Enums\Pica\PicaStatus;
use App\Enums\PicaSource;
use App\Models\AreaLocation;
use App\Models\AreaManager;
use App\Models\Company;
use App\Models\Department;
use App\Models\Section;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Pica\Entities\PicaDocument;
use Storage;

class CreateActiveDocumentPage extends Component
{
    use WithFileUploads, LivewireAlert;

    public $source;
    public $date;
    public $ccow_id;
    public $company_id;
    public $detail_company;
    public $section_id;
    public $area_location_id;
    public $detail_location;
    public $pja_id;
    public $pjo_id;
    public $type;
    public $job;
    public $visit_time;
    public $non_compliance;
    public $non_compliance_root;
    public $target_date;
    public $settlement_date;
    public $auditor;
    public $corrective_action;
    public $remarks;
    public $status;
    public $company_type = null;
    public $temporaryFile;
    public $evidances = [];

    public function hydrate()
    {
        $this->emit('select2');
        $this->emit('datetimepicker-input');
        $this->emit('form-check-input');
    }

    public function getCcowsProperty()
    {
        return Company::where('type', CompanyType::Internal)->get();
    }

    public function getCompaniesProperty()
    {
        return Company::all();
    }

    public function getSectionsProperty()
    {
        return Section::whereHas('department', function ($query) {
            $query->where('company_id', $this->ccow_id);
        })->get();
    }

    public function getAreaLocationsProperty()
    {
        return AreaLocation::where('section_id', $this->section_id)->get();
    }

    public function getAreaManagersProperty()
    {
        return AreaManager::where('section_id', $this->section_id)->get();
    }

    public function getEmployeesProperty()
    {
        return User::whereHas('department', function ($query) {
            $query->where('company_id', $this->company_id)
                ->whereHas('company', function ($q) {
                    $q->where('type', $this->company_type->type ?? null);
                });
        })->get();
    }

    public function updated($propertyName, $value)
    {
        // dd($propertyName, $value);
        if ($propertyName == 'company_id') {
            $this->company_type = Company::find($value);
            $this->detail_company = $this->company_type->type;
        }
        if ($propertyName == 'target_date') {
            $this->settlement_date = $value;
        }
        if ($propertyName == 'section_id') {
            $department = Section::find($value);
            $this->department_id = $department->department_id;
        }
        if ($propertyName == 'temporaryFile') {
            if (is_object($value[0])) {
                $this->addFile($value[0]);
            }
        }
    }

    public function addFile($index)
    {
        $this->evidances[] = [
            'file' => $index,
            'name' => $index->getClientOriginalName(),
            'size' => $this->changeByte($index->getSize()),
            'extension' => $index->getClientOriginalExtension(),
        ];
    }

    public function removeFile($fileIndex)
    {
        unset($this->evidances[$fileIndex]);
        $this->evidances = array_values($this->evidances);
    }

    public function changeByte($size)
    {
        $unit = array('b', 'Kb', 'Mb', 'Gb', 'Tb', 'Pb');
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }

    protected function rules(): array
    {
        return [
            'source' => 'required',
        ];
    }

    public function saved($published)
    {
        try {
            $this->validate();

            DB::beginTransaction();

            $picaDocument = PicaDocument::create([
                'identity_id' => $this->generateIdentityId(),
                'source' => $this->source,
                'type' => $this->type,
                'date' => Carbon::parse($this->date)->format('Y-m-d'),
                'ccow_id' => $this->ccow_id,
                'company_id' => $this->company_id,
                'section_id' => $this->section_id,
                'location_id' => $this->area_location_id,
                'location_detail' => $this->detail_location,
                'company_detail' => $this->detail_company,
                'pja_id' => $this->pja_id,
                'pjo_id' => $this->pjo_id,
                'auditor' => $this->auditor,
                'non_compliance' => $this->non_compliance,
                'non_compliance_root_cause' => $this->non_compliance_root,
                'corrective_action' => $this->corrective_action,
                'target_settlement_date' => Carbon::parse($this->target_date)->format('Y-m-d'),
                'settlement_date' => Carbon::parse($this->settlement_date)->format('Y-m-d'),
                'remarks' => $this->remarks,
                'requested' => PicaStatus::RequestedCrs, // new field for pica document
                'published' => $published, // new field for pica document
                'status' => PicaStatus::Open,
            ]);

            foreach ($this->evidances as $key => $file) {
                $path = 'pica/file/' . $picaDocument->id;
                $full_path = Storage::disk('public')->putFileAs($path, $file['file'], $file['name']);

                $picaDocument->picaFiles()->create([
                    'file' => $full_path,
                    'size' => $file['size'],
                    'type' => $this->type
                ]);
            }

            // create pica activity
            $picaDocument->activities()->create([
                'description' => 'New Request',
                'user_id' => Auth::user()->id,
            ]);

            DB::commit();

            $this->flash('success', 'Data berhasil di simpan!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('pica::listing.active-document.index');
        } catch (\Throwable $err) {

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Error',
                'icon' => 'error',
                'text' => "Error | " . $err,
            ]);
        }
    }

    public function saveDocument()
    {
        try {
            $this->validate();

            DB::beginTransaction();

            $picaDocument = PicaDocument::create([
                'identity_id' => $this->generateIdentityId(),
                'source' => $this->source,
                'type' => $this->type,
                'date' => Carbon::parse($this->date)->format('Y-m-d'),
                'ccow_id' => $this->ccow_id,
                'company_id' => $this->company_id,
                'section_id' => $this->section_id,
                'location_id' => $this->area_location_id,
                'location_detail' => $this->detail_location,
                'company_detail' => $this->detail_company,
                'pja_id' => $this->pja_id,
                'pjo_id' => $this->pjo_id,
                'auditor' => $this->auditor,
                'non_compliance' => $this->non_compliance,
                'non_compliance_root_cause' => $this->non_compliance_root,
                'corrective_action' => $this->corrective_action,
                'target_settlement_date' => Carbon::parse($this->target_date)->format('Y-m-d'),
                'settlement_date' => Carbon::parse($this->settlement_date)->format('Y-m-d'),
                'remarks' => $this->remarks,
                'requested' => PicaStatus::RequestedPja, // new field for pica document
                'published' => PicaStatus::Publish, // new field for pica document
                'status' => PicaStatus::OnReviewPja,
            ]);

            foreach ($this->evidances as $key => $file) {
                $path = 'pica/file/' . $picaDocument->id;
                $full_path = Storage::disk('public')->putFileAs($path, $file['file'], $file['name']);

                $picaDocument->picaFiles()->create([
                    'file' => $full_path,
                    'size' => $file['size'],
                    'type' => $this->type
                ]);
            }

            // create pica activity
            $picaDocument->activities()->create([
                'description' => 'New Request',
                'user_id' => Auth::user()->id,
            ]);

            DB::commit();

            $this->flash('success', 'Data berhasil di simpan!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);

            return redirect()->route('pica::listing.active-document.index');
        } catch (\Throwable $err) {

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Error',
                'icon' => 'error',
                'text' => "Error | " . $err,
            ]);
        }
    }

    public function generateIdentityId()
    {
        if ($this->source == PicaSource::FieldLeadership) {
            $code = 'FL';
        } else if ($this->source == PicaSource::InspeksiKPLH) {
            $code = 'IN';
        } else if ($this->source == PicaSource::IBPR) {
            $code = 'IB';
        } else if ($this->source == PicaSource::Audit) {
            $code = 'AU';
        } else {
            $code = '-';
        }

        $count = PicaDocument::count();
        $formattedNumber = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
        $date = Carbon::now()->format('mY');

        $result = $code . $date . '-' . $code . $formattedNumber;

        while (PicaDocument::where('identity_id', $result)->exists()) {
            $count++;
            $formattedNumber = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
            $result = $code . $date . '-' . $code . $formattedNumber;
        }

        return $result;
    }

    public function render()
    {
        return view('pica::livewire.listing.active-document.create-active-document-page')->extends('pica::layouts.no-header');
    }
}
