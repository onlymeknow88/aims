<?php

namespace Modules\Kplh\Http\Livewire\K3\Ew;

use App\Enums\CompanyType;
use App\Enums\PicaSource;
use App\Mail\kplh\RequestApprovalPJA;
use App\Models\AreaLocation;
use App\Models\AreaManager;
use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Section;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mail;
use Modules\Kplh\Entities\InspectionData;
use Modules\Kplh\Entities\InspectionRisks;
use Modules\Kplh\Entities\KplhLabel;
use Modules\Kplh\Entities\KplhLabelIO;

class Edit extends Component
{
    use WithFileUploads;

    public $mode, $date, $ccow, $ccow_id, $companyId, $departmentId, $sectionId, $area_location_id, $detail_location, $kttId, $pjaId;
    public $inspectionOfficer = [];
    public $companyType = null;

    public $tool_type, $tool_id;
    public $type_eye_wash, $type_eye_wash_file, $type_eye_wash_note;
    public $kondisi_tangki, $kondisi_tangki_2, $kondisi_tangki_file, $kondisi_tangki_note;
    public $kondisi_air, $kondisi_air_2, $kondisi_air_file, $kondisi_air_note;
    public $box_ew, $box_ew_2, $box_ew_file, $box_ew_note;
    public $pancuran_air, $pancuran_air_2, $pancuran_air_file, $pancuran_air_note;

    public $files = [];
    public $summary;

    protected $messages = [
        'date.required' => 'Tanggal inspeksi harus diisi',
        'ccow_id.required' => 'Harus pilih salah satu CCOW',
        'companyId.required' => 'Harus pilih salah satu perusahaan',
        'departmentId.required' => 'Harus pilih salah satu departemen',
        'area_location_id.required' => 'Harus pilih salah satu lokasi',
        'kttId.required' => 'Harus pilih salah satu KTT',
        'pjaId.required' => 'Harus pilih salah satu PJA',
        'inspectionOfficer.required' => 'Petugas Inspeksi Wajib diisi',
    ];

    public function mount($id)
    {
        $this->kplh = KplhLabel::find($id);

        $this->date = Carbon::parse($this->kplh->date)->format('F d, Y');
        $this->ccow_id = $this->kplh->ccow_id;
        $this->pjaId = $this->kplh->pja_id;
        $this->kttId = $this->kplh->ktt_id;
        $this->company = Company::find($this->kplh->company_id);
$this->companyId = $this->kplh->company_id;
        $this->ccow = Company::find($this->ccow_id);
        $this->departmentId = $this->kplh->department_id;
        $this->sectionId = $this->kplh->section_id;
        $this->area_location_id = $this->kplh->area_location_id;
        $this->detail_location = $this->kplh->location_detail;
        $this->summary = $this->kplh->summary;

        $this->tool_type = $this->kplh->tool_type;
        $this->tool_id = $this->kplh->tool_id;

        $inspectionOfficer = [];
        foreach ($this->kplh->inspection_officers as $io) {
            if ($io->label_id == $id) {
                $inspectionOfficer[] = $io->employee_id;
            }
        }

        $this->inspectionOfficer = $inspectionOfficer;

        foreach ($this->kplh->inspection_data as $ins) {
            if ($ins->criteria == 'type_eye_wash') {
                $this->type_eye_wash = $ins->k3_value;
                $this->type_eye_wash_file = $ins->file;
                $this->type_eye_wash_note = $ins->note;
            }
            if ($ins->criteria == 'kondisi_tangki') {
                $this->kondisi_tangki = $ins->k3_value;
                $this->kondisi_tangki_2 = $ins->k3_value_2;
                $this->kondisi_tangki_file = $ins->file;
                $this->kondisi_tangki_note = $ins->note;
            }
            if ($ins->criteria == 'kondisi_air') {
                $this->kondisi_air = $ins->k3_value;
                $this->kondisi_air_2 = $ins->k3_value_2;
                $this->kondisi_air_file = $ins->file;
                $this->kondisi_air_note = $ins->note;
            }
            if ($ins->criteria == 'pancuran_air') {
                $this->pancuran_air = $ins->k3_value;
                $this->pancuran_air_2 = $ins->k3_value_2;
                $this->pancuran_air_file = $ins->file;
                $this->pancuran_air_note = $ins->note;
            }
        }
    }

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

    public function updated($propertyName, $value)
    {
        if ($propertyName == 'ccow_id') {
            $this->ccow = Company::find($value);
            // $this->kttId = $this->ccow->user_id;
        }

        if ($propertyName == 'companyId') {
            $this->company = Company::find($value);
            $this->kttId = $this->company->user_id;
        }
    }

    public function getCompaniesProperty()
    {
        return Company::all();
    }

    public function getDepartmentsProperty()
    {
        return Department::where('company_id', $this->ccow_id)->get();
    }

    public function updateddepartmentId()
    {
        $this->sections = Section::where('department_id', $this->departmentId)->get();
    }

    public function getSectionsProperty()
    {
        return Section::where('department_id', $this->departmentId)->get();
    }

    public function getAreaLocationsProperty()
    {
        return AreaLocation::where('section_id', $this->sectionId)->get();
    }

    public function getAreaManagersProperty()
    {
        return AreaManager::where('section_id', $this->sectionId)->get();
    }

    public function getEmployeesProperty()
    {
        return Employee::get();
    }

    public function setFileNull($criteriaFileName)
    {
        $this->{$criteriaFileName} = null;
    }

    public function cancelFileNull($criteriaName, $criteriaFileName)
    {
        foreach ($this->kplh->inspection_data as $inspection_data) {
            if ($inspection_data->criteria == $criteriaName) {
                $this->{$criteriaFileName} = $inspection_data->file;
            }
        }
    }

    public function addInspectionOfficer($employee_id)
    {
        if (in_array($employee_id, $this->inspectionOfficer)) {
            $this->alert('warning', 'Petugas sudah dipilih.', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
            $this->emit('clearInspectionOfficerInput');
        } else {
            $this->inspectionOfficer[] = $employee_id;
            $this->emit('clearInspectionOfficerInput');
        }
    }

    public function save()
    {
        try {
            $this->validate([
                'date' => 'required',
                'ccow_id' => 'required',
                'companyId' => 'required',
                'departmentId' => 'required',
                'area_location_id' => 'required',
                'detail_location' => 'required',
                'kttId' => 'required',
                'pjaId' => 'required',
                'inspectionOfficer' => 'required',
            ]);

            if ($this->mode == 'draft') {
                $status = 'draft';
            } elseif ($this->mode == 'save') {
                $this->validate([
                    'tool_type' => 'required',
                    'tool_id' => 'required',
                    'type_eye_wash' => 'required',
                    'kondisi_tangki' => 'required',
                    'kondisi_air' => 'required',
                    'pancuran_air' => 'required',
                ]);
                $status = 'active';
            }

            DB::beginTransaction();

            $count_label = KplhLabel::withTrashed()->count();
            $date = Carbon::parse($this->date);

            $this->kplh->update([
                'maker_id' => Auth::user()->id,
                'date' => $date,
                'ccow_id' => $this->ccow_id,
                'company_id' => $this->companyId,
                'department_id' => $this->departmentId,
                'section_id' => $this->sectionId,
                'area_location_id' => $this->area_location_id,
                'location_detail' => $this->detail_location,
                'ktt_id' => $this->kttId,
                'pja_id' => $this->pjaId,
                'status' => $status,
                'summary' => $this->summary,

                'tool_type' => $this->tool_type,
                'tool_id' => $this->tool_id,
            ]);

            if (!empty($this->inspectionOfficer)) {
                $label_io = $this->kplh->inspection_officers;

                foreach ($label_io as $lio) {
                    $x = KplhLabelIO::find($lio->id)->delete();
                }

                foreach ($this->inspectionOfficer as $io) {
                    $labeliodata = [
                        'label_id' => $this->kplh->id,
                        'employee_id' => $io,
                    ];
                    $label_io_store = KplhLabelIO::create($labeliodata);
                }
            }

            $InspectionDatas = [
                [
                    'criteria' => 'type_eye_wash',
                    'k3_value' => $this->type_eye_wash,
                    'note' => $this->type_eye_wash_note,
                ],
                [
                    'criteria' => 'kondisi_tangki',
                    'k3_value' => $this->kondisi_tangki,
                    'k3_value_2' => $this->kondisi_tangki_2,
                    'note' => $this->kondisi_tangki_note,
                ],
                [
                    'criteria' => 'kondisi_air',
                    'k3_value' => $this->kondisi_air,
                    'k3_value_2' => $this->kondisi_air_2,
                    'note' => $this->kondisi_air_note,
                ],
                [
                    'criteria' => 'pancuran_air',
                    'k3_value' => $this->pancuran_air,
                    'k3_value_2' => $this->pancuran_air_2,
                    'note' => $this->pancuran_air_note,
                ],
            ];

            foreach ($InspectionDatas as $InspectionData) {
                if (isset($InspectionData['k3_value'])) {

                    $InspectionData['label_id'] = $this->kplh->id;

                    if ($this->{$InspectionData['criteria'] . '_file'} && ($this->{$InspectionData['criteria'] . '_file'} != '') && !is_string($this->{$InspectionData['criteria'] . '_file'})) {
                        $filetype = pathinfo($this->{$InspectionData['criteria'] . '_file'}->path(), PATHINFO_EXTENSION);
                        $file_name = "" . $this->kplh->id . "-" . $InspectionData['criteria'] . "_file.$filetype";
                        $this->{$InspectionData['criteria'] . '_file'}->storeAs('kplh/k3', $file_name, ['disk' => 'local']);
                        $InspectionData['file'] = $file_name;
                    } else {
                        $InspectionData['file'] = $this->{$InspectionData['criteria'] . '_file'};
                    }

                    $kplh_data = InspectionData::where('label_id', $this->kplh->id)->where('criteria', $InspectionData['criteria'])->first();

                    if ($kplh_data) {
                        $kplh_data->update($InspectionData);
                    } else {
                        $kplh_data = InspectionData::create($InspectionData);
                    }

                    // PICA
                    if ($status != 'draft' && $InspectionData['k3_value'] == 'Tidak Standard') {

                        if (!$kplh_data->file) {
                            $this->validate([
                                '' . $kplh_data->criteria . '_file' => 'required',
                            ]);
                        }

                        $this->validate([
                            '' . $kplh_data->criteria . '_note' => 'required',
                        ]);

                        // $riskCondition = $kplh_data->risks()->create([
                        //     'kplh_data_id' => $kplh_data->id,
                        //     'risk_value' => $kplh_data->value,
                        //     'risk_condition' => $kplh_data->note,
                        // ]);

                        // $picaDocument = $riskCondition->pica()->create([
                        //     'source' => PicaSource::InspeksiKPLH, // buat enum
                        //     'type' => 'k3-eye-wash',
                        //     'ccow_id' => $this->ccow_id,
                        //     'company_id' => $this->companyId,
                        //     'section_id' => $this->sectionId,
                        //     'pja_id' => $this->pjaId,
                        //     'pjo_id' => $this->kttId,
                        // ]);

                        // $picaDocument->pica()->create([
                        //     'source' => 'Inspeksi KPLH',
                        //     'source_id' => $riskCondition->id,
                        //     'picaable_id' => $picaDocument->id,
                        //     'picaable_type' => InspectionRisks::class,
                        // ]);

                        // if (isset($kplh_data->file)) {
                        //     $picaDocument->picaFiles()->create([
                        //         'file' => $kplh_data->file,
                        //         'size' => null,
                        //         'type' => null,
                        //     ]);
                        // }
                    }
                    // END PICA

                }
            }

            if ($this->mode == 'save') {
                $sendmail = Mail::to($this->kplh->pja->user->email)->send(new RequestApprovalPJA($this->kplh));
            }
            DB::commit();

            $this->dispatchBrowserEvent('toast-loader', [
                'type'  => 'success',
                'message' => 'Data Sedang di Simpan'
            ]);
            sleep(5);

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Berhasil',
                'icon' => 'success',
                'text' => 'Data Inspeksi berhasil di simpan',
            ]);

            session()->flash('msg', __('Data Inspeksi Tersimpan'));
            session()->flash('alert', 'success');
            redirect()->route('kplh::lists');

        } catch (\Throwable $th) {

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Error',
                'icon' => 'error',
                'text' => $th->getMessage(),
            ]);
        }
    }

    public function render()
    {
        return view('kplh::livewire.k3.ew.edit')->extends('kplh::layouts.no-header');
    }
}
