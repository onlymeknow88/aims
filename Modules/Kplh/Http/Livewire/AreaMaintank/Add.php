<?php

namespace Modules\Kplh\Http\Livewire\AreaMaintank;

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

class Add extends Component
{
    use WithFileUploads;

    public $mode, $date, $ccow, $ccow_id, $companyId, $departmentId, $sectionId, $area_location_id, $detail_location, $kttId, $pjaId;
    public $inspectionOfficer = [];
    public $companyType = null;

    public $maintank_pipes_1_1_value, $maintank_pipes_1_1_file, $maintank_pipes_1_1_note, $maintank_pipes_2_1_value, $maintank_pipes_2_1_file, $maintank_pipes_2_1_note, $maintank_pipes_2_2_value, $maintank_pipes_2_2_file, $maintank_pipes_2_2_note, $maintank_pipes_2_3_value, $maintank_pipes_2_3_file, $maintank_pipes_2_3_note, $maintank_pipes_3_1_value, $maintank_pipes_3_1_file, $maintank_pipes_3_1_note, $maintank_pipes_3_2_value, $maintank_pipes_3_2_file, $maintank_pipes_3_2_note, $maintank_pipes_3_3_value, $maintank_pipes_3_3_file, $maintank_pipes_3_3_note, $maintank_pipes_3_4_value, $maintank_pipes_3_4_file, $maintank_pipes_3_4_note;
    public $maintank_1_1_value, $maintank_1_1_file, $maintank_1_1_note, $maintank_1_2_value, $maintank_1_2_file, $maintank_1_2_note, $maintank_1_3_value, $maintank_1_3_file, $maintank_1_3_note, $maintank_2_1_value, $maintank_2_1_file, $maintank_2_1_note, $maintank_2_2_value, $maintank_2_2_file, $maintank_2_2_note, $maintank_2_3_value, $maintank_2_3_file, $maintank_2_3_note, $maintank_2_4_value, $maintank_2_4_file, $maintank_2_4_note, $maintank_3_1_value, $maintank_3_1_file, $maintank_3_1_note, $maintank_3_2_value, $maintank_3_2_file, $maintank_3_2_note, $maintank_3_3_value, $maintank_3_3_file, $maintank_3_3_note, $maintank_4_1_value, $maintank_4_1_file, $maintank_4_1_note, $maintank_4_2_value, $maintank_4_2_file, $maintank_4_2_note, $maintank_4_3_value, $maintank_4_3_file, $maintank_4_3_note, $maintank_4_4_value, $maintank_4_4_file, $maintank_4_4_note, $maintank_4_5_value, $maintank_4_5_file, $maintank_4_5_note, $maintank_5_1_value, $maintank_5_1_file, $maintank_5_1_note, $maintank_5_2_value, $maintank_5_2_file, $maintank_5_2_note, $maintank_6_1_value, $maintank_6_1_file, $maintank_6_1_note, $maintank_6_2_value, $maintank_6_2_file, $maintank_6_2_note, $maintank_6_3_value, $maintank_6_3_file, $maintank_6_3_note, $maintank_6_4_value, $maintank_6_4_file, $maintank_6_4_note, $maintank_7_1_value, $maintank_7_1_file, $maintank_7_1_note, $maintank_7_2_value, $maintank_7_2_file, $maintank_7_2_note, $maintank_7_3_value, $maintank_7_3_file, $maintank_7_3_note;
    public $maintank_roof_1_1_value, $maintank_roof_1_1_file, $maintank_roof_1_1_note, $maintank_roof_1_2_value, $maintank_roof_1_2_file, $maintank_roof_1_2_note, $maintank_roof_2_1_value, $maintank_roof_2_1_file, $maintank_roof_2_1_note, $maintank_roof_2_2_value, $maintank_roof_2_2_file, $maintank_roof_2_2_note, $maintank_roof_3_1_value, $maintank_roof_3_1_file, $maintank_roof_3_1_note, $maintank_roof_3_2_value, $maintank_roof_3_2_file, $maintank_roof_3_2_note, $maintank_roof_3_3_value, $maintank_roof_3_3_file, $maintank_roof_3_3_note, $maintank_roof_3_4_value, $maintank_roof_3_4_file, $maintank_roof_3_4_note, $maintank_roof_4_1_value, $maintank_roof_4_1_file, $maintank_roof_4_1_note, $maintank_roof_4_2_value, $maintank_roof_4_2_file, $maintank_roof_4_2_note, $maintank_roof_5_1_value, $maintank_roof_5_1_file, $maintank_roof_5_1_note, $maintank_roof_5_2_value, $maintank_roof_5_2_file, $maintank_roof_5_2_note, $maintank_roof_5_3_value, $maintank_roof_5_3_file, $maintank_roof_5_3_note;
    public $maintank_area_1_1_value, $maintank_area_1_1_file, $maintank_area_1_1_note, $maintank_area_1_2_value, $maintank_area_1_2_file, $maintank_area_1_2_note, $maintank_area_1_3_value, $maintank_area_1_3_file, $maintank_area_1_3_note, $maintank_area_1_4_value, $maintank_area_1_4_file, $maintank_area_1_4_note, $maintank_area_2_1_value, $maintank_area_2_1_file, $maintank_area_2_1_note, $maintank_area_2_2_value, $maintank_area_2_2_file, $maintank_area_2_2_note, $maintank_area_2_3_value, $maintank_area_2_3_file, $maintank_area_2_3_note, $maintank_area_2_4_value, $maintank_area_2_4_file, $maintank_area_2_4_note, $maintank_area_3_1_value, $maintank_area_3_1_file, $maintank_area_3_1_note, $maintank_area_3_2_value, $maintank_area_3_2_file, $maintank_area_3_2_note, $maintank_area_3_3_value, $maintank_area_3_3_file, $maintank_area_3_3_note, $maintank_area_4_1_value, $maintank_area_4_1_file, $maintank_area_4_1_note, $maintank_area_5_1_value, $maintank_area_5_1_file, $maintank_area_5_1_note, $maintank_area_6_1_value, $maintank_area_6_1_file, $maintank_area_6_1_note, $maintank_area_7_1_value, $maintank_area_7_1_file, $maintank_area_7_1_note;
    public $maintank_maintenance_1_1_value, $maintank_maintenance_1_1_file, $maintank_maintenance_1_1_note, $maintank_maintenance_1_2_value, $maintank_maintenance_1_2_file, $maintank_maintenance_1_2_note;

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

    public function mount()
    {
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

            $this->employees = Employee::where(function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->whereHas('department', function ($query) {
                        $query->where('company_id', $this->ccow_id);
                    });
                });
            })->get();
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

    public function getEmployeesProperty()
    {
        return Employee::get();
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
                    'maintank_pipes_1_1_value' => 'required',
                    'maintank_pipes_2_1_value' => 'required',
                    'maintank_pipes_2_2_value' => 'required',
                    'maintank_pipes_2_3_value' => 'required',
                    'maintank_pipes_3_1_value' => 'required',
                    'maintank_pipes_3_2_value' => 'required',
                    'maintank_pipes_3_3_value' => 'required',
                    'maintank_pipes_3_4_value' => 'required',

                    'maintank_1_1_value' => 'required',
                    'maintank_1_2_value' => 'required',
                    'maintank_1_3_value' => 'required',
                    'maintank_2_1_value' => 'required',
                    'maintank_2_2_value' => 'required',
                    'maintank_2_3_value' => 'required',
                    'maintank_2_4_value' => 'required',
                    'maintank_3_1_value' => 'required',
                    'maintank_3_2_value' => 'required',
                    'maintank_3_3_value' => 'required',
                    'maintank_4_1_value' => 'required',
                    'maintank_4_2_value' => 'required',
                    'maintank_4_3_value' => 'required',
                    'maintank_4_4_value' => 'required',
                    'maintank_4_5_value' => 'required',
                    'maintank_5_1_value' => 'required',
                    'maintank_5_2_value' => 'required',
                    'maintank_6_1_value' => 'required',
                    'maintank_6_2_value' => 'required',
                    'maintank_6_3_value' => 'required',
                    'maintank_6_4_value' => 'required',
                    'maintank_7_1_value' => 'required',
                    'maintank_7_2_value' => 'required',
                    'maintank_7_3_value' => 'required',

                    'maintank_roof_1_1_value' => 'required',
                    'maintank_roof_1_2_value' => 'required',
                    'maintank_roof_2_1_value' => 'required',
                    'maintank_roof_2_2_value' => 'required',
                    'maintank_roof_3_1_value' => 'required',
                    'maintank_roof_3_2_value' => 'required',
                    'maintank_roof_3_3_value' => 'required',
                    'maintank_roof_3_4_value' => 'required',
                    'maintank_roof_4_1_value' => 'required',
                    'maintank_roof_4_2_value' => 'required',
                    'maintank_roof_5_1_value' => 'required',
                    'maintank_roof_5_2_value' => 'required',
                    'maintank_roof_5_3_value' => 'required',

                    'maintank_area_1_1_value' => 'required',
                    'maintank_area_1_2_value' => 'required',
                    'maintank_area_1_3_value' => 'required',
                    'maintank_area_1_4_value' => 'required',
                    'maintank_area_2_1_value' => 'required',
                    'maintank_area_2_2_value' => 'required',
                    'maintank_area_2_3_value' => 'required',
                    'maintank_area_2_4_value' => 'required',
                    'maintank_area_3_1_value' => 'required',
                    'maintank_area_3_2_value' => 'required',
                    'maintank_area_3_3_value' => 'required',
                    'maintank_area_4_1_value' => 'required',
                    'maintank_area_5_1_value' => 'required',
                    'maintank_area_6_1_value' => 'required',
                    'maintank_area_7_1_value' => 'required',

                    'maintank_maintenance_1_1_value' => 'required',
                    'maintank_maintenance_1_2_value' => 'required',
                ]);
                $status = 'active';
            }

            DB::beginTransaction();

            $count_label = KplhLabel::withTrashed()->count();
            $date = Carbon::parse($this->date);

            $inspect_id = 'INSP-' . $date->format('dmY') . '-' . (sprintf("%06d", ($count_label + 1))) . '';

            $labeldata = [
                'company_id' => $this->companyId,
                'department_id' => $this->departmentId,
                'section_id' => $this->sectionId,
                'maker_id' => Auth::user()->id,
                'inspect_id' => $inspect_id,
                'inspect_criteria' => 'area-maintank',
                'ccow_id' => $this->ccow_id,
                'date' => $date,
                'area_location_id' => $this->area_location_id,
                'location_detail' => $this->detail_location,
                'ktt_id' => $this->kttId,
                'pja_id' => $this->pjaId,
                'status' => $status,
                'summary' => $this->summary,
            ];

            $label_store = KplhLabel::create($labeldata);

            if (!empty($this->inspectionOfficer)) {
                foreach ($this->inspectionOfficer as $io) {
                    $labeliodata = [
                        'label_id' => $label_store->id,
                        'employee_id' => $io,
                    ];
                    $label_io_store = KplhLabelIO::create($labeliodata);
                }
            } else {
                $inspectionOfficer = null;
            }

            $InspectionDatas = [
                [
                    'criteria' => 'maintank_pipes_1_1',
                    'k3_value' => $this->maintank_pipes_1_1_value,
                    'note' => $this->maintank_pipes_1_1_note,
                ],
                [
                    'criteria' => 'maintank_pipes_2_1',
                    'k3_value' => $this->maintank_pipes_2_1_value,
                    'note' => $this->maintank_pipes_2_1_note,
                ],
                [
                    'criteria' => 'maintank_pipes_2_2',
                    'k3_value' => $this->maintank_pipes_2_2_value,
                    'note' => $this->maintank_pipes_2_2_note,
                ],
                [
                    'criteria' => 'maintank_pipes_2_3',
                    'k3_value' => $this->maintank_pipes_2_3_value,
                    'note' => $this->maintank_pipes_2_3_note,
                ],
                [
                    'criteria' => 'maintank_pipes_3_1',
                    'k3_value' => $this->maintank_pipes_3_1_value,
                    'note' => $this->maintank_pipes_3_1_note,
                ],
                [
                    'criteria' => 'maintank_pipes_3_2',
                    'k3_value' => $this->maintank_pipes_3_2_value,
                    'note' => $this->maintank_pipes_3_2_note,
                ],
                [
                    'criteria' => 'maintank_pipes_3_3',
                    'k3_value' => $this->maintank_pipes_3_3_value,
                    'note' => $this->maintank_pipes_3_3_note,
                ],
                [
                    'criteria' => 'maintank_pipes_3_4',
                    'k3_value' => $this->maintank_pipes_3_4_value,
                    'note' => $this->maintank_pipes_3_4_note,
                ],
                [
                    'criteria' => 'maintank_1_1',
                    'k3_value' => $this->maintank_1_1_value,
                    'note' => $this->maintank_1_1_note,
                ],
                [
                    'criteria' => 'maintank_1_2',
                    'k3_value' => $this->maintank_1_2_value,
                    'note' => $this->maintank_1_2_note,
                ],
                [
                    'criteria' => 'maintank_1_3',
                    'k3_value' => $this->maintank_1_3_value,
                    'note' => $this->maintank_1_3_note,
                ],
                [
                    'criteria' => 'maintank_2_1',
                    'k3_value' => $this->maintank_2_1_value,
                    'note' => $this->maintank_2_1_note,
                ],
                [
                    'criteria' => 'maintank_2_2',
                    'k3_value' => $this->maintank_2_2_value,
                    'note' => $this->maintank_2_2_note,
                ],
                [
                    'criteria' => 'maintank_2_3',
                    'k3_value' => $this->maintank_2_3_value,
                    'note' => $this->maintank_2_3_note,
                ],
                [
                    'criteria' => 'maintank_2_4',
                    'k3_value' => $this->maintank_2_4_value,
                    'note' => $this->maintank_2_4_note,
                ],
                [
                    'criteria' => 'maintank_3_1',
                    'k3_value' => $this->maintank_3_1_value,
                    'note' => $this->maintank_3_1_note,
                ],
                [
                    'criteria' => 'maintank_3_2',
                    'k3_value' => $this->maintank_3_2_value,
                    'note' => $this->maintank_3_2_note,
                ],
                [
                    'criteria' => 'maintank_3_3',
                    'k3_value' => $this->maintank_3_3_value,
                    'note' => $this->maintank_3_3_note,
                ],
                [
                    'criteria' => 'maintank_4_1',
                    'k3_value' => $this->maintank_4_1_value,
                    'note' => $this->maintank_4_1_note,
                ],
                [
                    'criteria' => 'maintank_4_2',
                    'k3_value' => $this->maintank_4_2_value,
                    'note' => $this->maintank_4_2_note,
                ],
                [
                    'criteria' => 'maintank_4_3',
                    'k3_value' => $this->maintank_4_3_value,
                    'note' => $this->maintank_4_3_note,
                ],
                [
                    'criteria' => 'maintank_4_4',
                    'k3_value' => $this->maintank_4_4_value,
                    'note' => $this->maintank_4_4_note,
                ],
                [
                    'criteria' => 'maintank_4_5',
                    'k3_value' => $this->maintank_4_5_value,
                    'note' => $this->maintank_4_5_note,
                ],
                [
                    'criteria' => 'maintank_5_1',
                    'k3_value' => $this->maintank_5_1_value,
                    'note' => $this->maintank_5_1_note,
                ],
                [
                    'criteria' => 'maintank_5_2',
                    'k3_value' => $this->maintank_5_2_value,
                    'note' => $this->maintank_5_2_note,
                ], [
                    'criteria' => 'maintank_6_1',
                    'k3_value' => $this->maintank_6_1_value,
                    'note' => $this->maintank_6_1_note,
                ],
                [
                    'criteria' => 'maintank_6_2',
                    'k3_value' => $this->maintank_6_2_value,
                    'note' => $this->maintank_6_2_note,
                ],
                [
                    'criteria' => 'maintank_6_3',
                    'k3_value' => $this->maintank_6_3_value,
                    'note' => $this->maintank_6_3_note,
                ],
                [
                    'criteria' => 'maintank_6_4',
                    'k3_value' => $this->maintank_6_4_value,
                    'note' => $this->maintank_6_4_note,
                ],
                [
                    'criteria' => 'maintank_7_1',
                    'k3_value' => $this->maintank_7_1_value,
                    'note' => $this->maintank_7_1_note,
                ],
                [
                    'criteria' => 'maintank_7_2',
                    'k3_value' => $this->maintank_7_2_value,
                    'note' => $this->maintank_7_2_note,
                ],
                [
                    'criteria' => 'maintank_7_3',
                    'k3_value' => $this->maintank_7_3_value,
                    'note' => $this->maintank_7_3_note,
                ],
                [
                    'criteria' => 'maintank_roof_1_1',
                    'k3_value' => $this->maintank_roof_1_1_value,
                    'note' => $this->maintank_roof_1_1_note,
                ],
                [
                    'criteria' => 'maintank_roof_1_2',
                    'k3_value' => $this->maintank_roof_1_2_value,
                    'note' => $this->maintank_roof_1_2_note,
                ],
                [
                    'criteria' => 'maintank_roof_2_1',
                    'k3_value' => $this->maintank_roof_2_1_value,
                    'note' => $this->maintank_roof_2_1_note,
                ],
                [
                    'criteria' => 'maintank_roof_2_2',
                    'k3_value' => $this->maintank_roof_2_2_value,
                    'note' => $this->maintank_roof_2_2_note,
                ],
                [
                    'criteria' => 'maintank_roof_3_1',
                    'k3_value' => $this->maintank_roof_3_1_value,
                    'note' => $this->maintank_roof_3_1_note,
                ],
                [
                    'criteria' => 'maintank_roof_3_2',
                    'k3_value' => $this->maintank_roof_3_2_value,
                    'note' => $this->maintank_roof_3_2_note,
                ],
                [
                    'criteria' => 'maintank_roof_3_3',
                    'k3_value' => $this->maintank_roof_3_3_value,
                    'note' => $this->maintank_roof_3_3_note,
                ],
                [
                    'criteria' => 'maintank_roof_3_4',
                    'k3_value' => $this->maintank_roof_3_4_value,
                    'note' => $this->maintank_roof_3_4_note,
                ],
                [
                    'criteria' => 'maintank_roof_4_1',
                    'k3_value' => $this->maintank_roof_4_1_value,
                    'note' => $this->maintank_roof_4_1_note,
                ],
                [
                    'criteria' => 'maintank_roof_4_2',
                    'k3_value' => $this->maintank_roof_4_2_value,
                    'note' => $this->maintank_roof_4_2_note,
                ],
                [
                    'criteria' => 'maintank_roof_5_1',
                    'k3_value' => $this->maintank_roof_5_1_value,
                    'note' => $this->maintank_roof_5_1_note,
                ],
                [
                    'criteria' => 'maintank_roof_5_2',
                    'k3_value' => $this->maintank_roof_5_2_value,
                    'note' => $this->maintank_roof_5_2_note,
                ],
                [
                    'criteria' => 'maintank_roof_5_3',
                    'k3_value' => $this->maintank_roof_5_3_value,
                    'note' => $this->maintank_roof_5_3_note,
                ],
                [
                    'criteria' => 'maintank_area_1_1',
                    'k3_value' => $this->maintank_area_1_1_value,
                    'note' => $this->maintank_area_1_1_note,
                ],
                [
                    'criteria' => 'maintank_area_1_2',
                    'k3_value' => $this->maintank_area_1_2_value,
                    'note' => $this->maintank_area_1_2_note,
                ],
                [
                    'criteria' => 'maintank_area_1_3',
                    'k3_value' => $this->maintank_area_1_3_value,
                    'note' => $this->maintank_area_1_3_note,
                ],
                [
                    'criteria' => 'maintank_area_1_4',
                    'k3_value' => $this->maintank_area_1_4_value,
                    'note' => $this->maintank_area_1_4_note,
                ],
                [
                    'criteria' => 'maintank_area_2_1',
                    'k3_value' => $this->maintank_area_2_1_value,
                    'note' => $this->maintank_area_2_1_note,
                ],
                [
                    'criteria' => 'maintank_area_2_2',
                    'k3_value' => $this->maintank_area_2_2_value,
                    'note' => $this->maintank_area_2_2_note,
                ],
                [
                    'criteria' => 'maintank_area_2_3',
                    'k3_value' => $this->maintank_area_2_3_value,
                    'note' => $this->maintank_area_2_3_note,
                ],
                [
                    'criteria' => 'maintank_area_2_4',
                    'k3_value' => $this->maintank_area_2_4_value,
                    'note' => $this->maintank_area_2_4_note,
                ],
                [
                    'criteria' => 'maintank_area_3_1',
                    'k3_value' => $this->maintank_area_3_1_value,
                    'note' => $this->maintank_area_3_1_note,
                ],
                [
                    'criteria' => 'maintank_area_3_2',
                    'k3_value' => $this->maintank_area_3_2_value,
                    'note' => $this->maintank_area_3_2_note,
                ],
                [
                    'criteria' => 'maintank_area_3_3',
                    'k3_value' => $this->maintank_area_3_3_value,
                    'note' => $this->maintank_area_3_3_note,
                ],
                [
                    'criteria' => 'maintank_area_4_1',
                    'k3_value' => $this->maintank_area_4_1_value,
                    'note' => $this->maintank_area_4_1_note,
                ],
                [
                    'criteria' => 'maintank_area_5_1',
                    'k3_value' => $this->maintank_area_5_1_value,
                    'note' => $this->maintank_area_5_1_note,
                ],
                [
                    'criteria' => 'maintank_area_6_1',
                    'k3_value' => $this->maintank_area_6_1_value,
                    'note' => $this->maintank_area_6_1_note,
                ],
                [
                    'criteria' => 'maintank_area_7_1',
                    'k3_value' => $this->maintank_area_7_1_value,
                    'note' => $this->maintank_area_7_1_note,
                ],

                [
                    'criteria' => 'maintank_maintenance_1_1',
                    'k3_value' => $this->maintank_maintenance_1_1_value,
                    'note' => $this->maintank_maintenance_1_1_note,
                ],
                [
                    'criteria' => 'maintank_maintenance_1_2',
                    'k3_value' => $this->maintank_maintenance_1_2_value,
                    'note' => $this->maintank_maintenance_1_2_note,
                ],
            ];

            foreach ($InspectionDatas as $InspectionData) {
                if (isset($InspectionData['k3_value'])) {

                    $InspectionData['label_id'] = $label_store->id;

                    if ($this->{$InspectionData['criteria'] . '_file'} && !is_string($this->{$InspectionData['criteria'] . '_file'})) {
                        $filetype = pathinfo($this->{$InspectionData['criteria'] . '_file'}->path(), PATHINFO_EXTENSION);
                        $file_name = "" . $label_store->id . "-" . $InspectionData['criteria'] . "_file.$filetype";
                        $this->{$InspectionData['criteria'] . '_file'}->storeAs('kplh/maintank', $file_name, ['disk' => 'local']);
                        $InspectionData['file'] = $file_name;
                    } else {
                        $InspectionData['file'] = null;
                    }

                    $kplh_data = InspectionData::create($InspectionData);

                    // PICA
                    if ($status != 'draft' && $InspectionData['k3_value'] == 'Tidak') {
                        $this->validate([
                            '' . $kplh_data->criteria . '_file' => 'required',
                            '' . $kplh_data->criteria . '_note' => 'required',
                        ]);

                        // $riskCondition = $kplh_data->risks()->create([
                        //     'kplh_data_id' => $kplh_data->id,
                        //     'risk_k3_value' => $kplh_data->k3_value,
                        //     'risk_condition' => $kplh_data->note,
                        // ]);

                        // $picaDocument = $riskCondition->pica()->create([
                        //     'source' => PicaSource::InspeksiKPLH,
                        //     'type' => 'area-maintank',
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
                $sendmail = Mail::to($label_store->pja->user->email)->send(new RequestApprovalPJA($label_store));
            }

            DB::commit();

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
        return view('kplh::livewire.area-maintank.add')->extends('kplh::layouts.no-header');
    }
}
