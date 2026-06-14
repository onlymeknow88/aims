<?php

namespace Modules\Kplh\Http\Livewire\FoodHygiene;

use App\Enums\CompanyType;
use App\Enums\PicaSource;
use App\Mail\kplh\RequestApprovalPJA;
use App\Enums\Pica\PicaStatus;
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
use Modules\Pica\Entities\PicaDocument;
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

    public $building_criteria_1_value, $building_criteria_1_file, $building_criteria_1_note, $building_criteria_2_value, $building_criteria_2_file, $building_criteria_2_note, $building_criteria_3_value, $building_criteria_3_file, $building_criteria_3_note, $building_criteria_4_value, $building_criteria_4_file, $building_criteria_4_note, $building_criteria_5_value, $building_criteria_5_file, $building_criteria_5_note, $building_criteria_6_value, $building_criteria_6_file, $building_criteria_6_note, $building_criteria_7_value, $building_criteria_7_file, $building_criteria_7_note, $building_criteria_8_value, $building_criteria_8_file, $building_criteria_8_note, $building_criteria_9_value, $building_criteria_9_file, $building_criteria_9_note, $building_criteria_10_value, $building_criteria_10_file, $building_criteria_10_note, $building_criteria_11_value, $building_criteria_11_file, $building_criteria_11_note;
    public $sanitation_1_value, $sanitation_1_file, $sanitation_1_note, $sanitation_2_value, $sanitation_2_file, $sanitation_2_note, $sanitation_3_value, $sanitation_3_file, $sanitation_3_note, $sanitation_4_value, $sanitation_4_file, $sanitation_4_note, $sanitation_5_value, $sanitation_5_file, $sanitation_5_note, $sanitation_6_value, $sanitation_6_file, $sanitation_6_note;
    public $equipment_1_value, $equipment_1_file, $equipment_1_note, $equipment_2_value, $equipment_2_file, $equipment_2_note, $equipment_3_value, $equipment_3_file, $equipment_3_note, $equipment_4_value, $equipment_4_file, $equipment_4_note, $equipment_5_value, $equipment_5_file, $equipment_5_note, $equipment_6_value, $equipment_6_file, $equipment_6_note, $equipment_7_value, $equipment_7_file, $equipment_7_note, $equipment_8_value, $equipment_8_file, $equipment_8_note;
    public $food_handler_1_value, $food_handler_1_file, $food_handler_1_note, $food_handler_2_value, $food_handler_2_file, $food_handler_2_note, $food_handler_3_value, $food_handler_3_file, $food_handler_3_note, $food_handler_4_value, $food_handler_4_file, $food_handler_4_note, $food_handler_5_value, $food_handler_5_file, $food_handler_5_note, $food_handler_6_value, $food_handler_6_file, $food_handler_6_note, $food_handler_7_value, $food_handler_7_file, $food_handler_7_note, $food_handler_8_value, $food_handler_8_file, $food_handler_8_note, $food_handler_9_value, $food_handler_9_file, $food_handler_9_note, $food_handler_10_value, $food_handler_10_file, $food_handler_10_note, $food_handler_11_value, $food_handler_11_file, $food_handler_11_note, $food_handler_12_value, $food_handler_12_file, $food_handler_12_note;
    public $food_storage_1_value, $food_storage_1_file, $food_storage_1_note, $food_storage_2_value, $food_storage_2_file, $food_storage_2_note, $food_storage_3_value, $food_storage_3_file, $food_storage_3_note, $food_storage_4_value, $food_storage_4_file, $food_storage_4_note, $food_storage_5_value, $food_storage_5_file, $food_storage_5_note;
    public $food_processers_1_value, $food_processers_1_file, $food_processers_1_note, $food_processers_2_value, $food_processers_2_file, $food_processers_2_note, $food_processers_3_value, $food_processers_3_file, $food_processers_3_note, $food_processers_4_value, $food_processers_4_file, $food_processers_4_note, $food_processers_5_value, $food_processers_5_file, $food_processers_5_note, $food_processers_6_value, $food_processers_6_file, $food_processers_6_note, $food_processers_7_value, $food_processers_7_file, $food_processers_7_note;
    public $food_transport_1_1_value, $food_transport_1_1_file, $food_transport_1_1_note, $food_transport_1_2_value, $food_transport_1_2_file, $food_transport_1_2_note, $food_transport_1_3_value, $food_transport_1_3_file, $food_transport_1_3_note, $food_transport_2_1_value, $food_transport_2_1_file, $food_transport_2_1_note, $food_transport_2_2_value, $food_transport_2_2_file, $food_transport_2_2_note, $food_transport_2_3_value, $food_transport_2_3_file, $food_transport_2_3_note;
    public $general_precautions_1_value, $general_precautions_1_file, $general_precautions_1_note, $general_precautions_2_value, $general_precautions_2_file, $general_precautions_2_note, $general_precautions_3_value, $general_precautions_3_file, $general_precautions_3_note, $general_precautions_4_value, $general_precautions_4_file, $general_precautions_4_note, $general_precautions_5_value, $general_precautions_5_file, $general_precautions_5_note;

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
    { }

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
                    'building_criteria_1_value' => 'required',
                    'building_criteria_2_value' => 'required',
                    'building_criteria_3_value' => 'required',
                    'building_criteria_4_value' => 'required',
                    'building_criteria_5_value' => 'required',
                    'building_criteria_6_value' => 'required',
                    'building_criteria_7_value' => 'required',
                    'building_criteria_8_value' => 'required',
                    'building_criteria_9_value' => 'required',
                    'building_criteria_10_value' => 'required',
                    'building_criteria_11_value' => 'required',

                    'sanitation_1_value' => 'required',
                    'sanitation_2_value' => 'required',
                    'sanitation_3_value' => 'required',
                    'sanitation_4_value' => 'required',
                    'sanitation_5_value' => 'required',
                    'sanitation_6_value' => 'required',

                    'equipment_1_value' => 'required',
                    'equipment_2_value' => 'required',
                    'equipment_3_value' => 'required',
                    'equipment_4_value' => 'required',
                    'equipment_5_value' => 'required',
                    'equipment_6_value' => 'required',
                    'equipment_7_value' => 'required',
                    'equipment_8_value' => 'required',

                    'food_handler_1_value' => 'required',
                    'food_handler_2_value' => 'required',
                    'food_handler_3_value' => 'required',
                    'food_handler_4_value' => 'required',
                    'food_handler_5_value' => 'required',
                    'food_handler_6_value' => 'required',
                    'food_handler_7_value' => 'required',
                    'food_handler_8_value' => 'required',
                    'food_handler_9_value' => 'required',
                    'food_handler_10_value' => 'required',
                    'food_handler_11_value' => 'required',
                    'food_handler_12_value' => 'required',

                    'food_storage_1_value' => 'required',
                    'food_storage_2_value' => 'required',
                    'food_storage_3_value' => 'required',
                    'food_storage_4_value' => 'required',
                    'food_storage_5_value' => 'required',

                    'food_processers_1_value' => 'required',
                    'food_processers_2_value' => 'required',
                    'food_processers_3_value' => 'required',
                    'food_processers_4_value' => 'required',
                    'food_processers_5_value' => 'required',
                    'food_processers_6_value' => 'required',
                    'food_processers_7_value' => 'required',

                    'food_transport_1_1_value' => 'required',
                    'food_transport_1_2_value' => 'required',
                    'food_transport_1_3_value' => 'required',
                    'food_transport_2_1_value' => 'required',
                    'food_transport_2_2_value' => 'required',
                    'food_transport_2_3_value' => 'required',

                    'general_precautions_1_value' => 'required',
                    'general_precautions_2_value' => 'required',
                    'general_precautions_3_value' => 'required',
                    'general_precautions_4_value' => 'required',
                    'general_precautions_5_value' => 'required',
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
                'inspect_criteria' => 'food-hygiene',
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
                    'criteria' => 'building_criteria_1',
                    'value' => $this->building_criteria_1_value,
                    'note' => $this->building_criteria_1_note,
                ],
                [
                    'criteria' => 'building_criteria_2',
                    'value' => $this->building_criteria_2_value,
                    'note' => $this->building_criteria_2_note,
                ],
                [
                    'criteria' => 'building_criteria_3',
                    'value' => $this->building_criteria_3_value,
                    'note' => $this->building_criteria_3_note,
                ],
                [
                    'criteria' => 'building_criteria_4',
                    'value' => $this->building_criteria_4_value,
                    'note' => $this->building_criteria_4_note,
                ],
                [
                    'criteria' => 'building_criteria_5',
                    'value' => $this->building_criteria_5_value,
                    'note' => $this->building_criteria_5_note,
                ],
                [
                    'criteria' => 'building_criteria_6',
                    'value' => $this->building_criteria_6_value,
                    'note' => $this->building_criteria_6_note,
                ],
                [
                    'criteria' => 'building_criteria_7',
                    'value' => $this->building_criteria_7_value,
                    'note' => $this->building_criteria_7_note,
                ],
                [
                    'criteria' => 'building_criteria_8',
                    'value' => $this->building_criteria_8_value,
                    'note' => $this->building_criteria_8_note,
                ],
                [
                    'criteria' => 'building_criteria_9',
                    'value' => $this->building_criteria_9_value,
                    'note' => $this->building_criteria_9_note,
                ],
                [
                    'criteria' => 'building_criteria_10',
                    'value' => $this->building_criteria_10_value,
                    'note' => $this->building_criteria_10_note,
                ],
                [
                    'criteria' => 'building_criteria_11',
                    'value' => $this->building_criteria_11_value,
                    'note' => $this->building_criteria_11_note,
                ],
                [
                    'criteria' => 'sanitation_1',
                    'value' => $this->sanitation_1_value,
                    'note' => $this->sanitation_1_note,
                ],
                [
                    'criteria' => 'sanitation_2',
                    'value' => $this->sanitation_2_value,
                    'note' => $this->sanitation_2_note,
                ],
                [
                    'criteria' => 'sanitation_3',
                    'value' => $this->sanitation_3_value,
                    'note' => $this->sanitation_3_note,
                ],
                [
                    'criteria' => 'sanitation_4',
                    'value' => $this->sanitation_4_value,
                    'note' => $this->sanitation_4_note,
                ],
                [
                    'criteria' => 'sanitation_5',
                    'value' => $this->sanitation_5_value,
                    'note' => $this->sanitation_5_note,
                ],
                [
                    'criteria' => 'sanitation_6',
                    'value' => $this->sanitation_6_value,
                    'note' => $this->sanitation_6_note,
                ],
                [
                    'criteria' => 'equipment_1',
                    'value' => $this->equipment_1_value,
                    'note' => $this->equipment_1_note,
                ],
                [
                    'criteria' => 'equipment_2',
                    'value' => $this->equipment_2_value,
                    'note' => $this->equipment_2_note,
                ],
                [
                    'criteria' => 'equipment_3',
                    'value' => $this->equipment_3_value,
                    'note' => $this->equipment_3_note,
                ],
                [
                    'criteria' => 'equipment_4',
                    'value' => $this->equipment_4_value,
                    'note' => $this->equipment_4_note,
                ],
                [
                    'criteria' => 'equipment_5',
                    'value' => $this->equipment_5_value,
                    'note' => $this->equipment_5_note,
                ],
                [
                    'criteria' => 'equipment_6',
                    'value' => $this->equipment_6_value,
                    'note' => $this->equipment_6_note,
                ],
                [
                    'criteria' => 'equipment_7',
                    'value' => $this->equipment_7_value,
                    'note' => $this->equipment_7_note,
                ],
                [
                    'criteria' => 'equipment_8',
                    'value' => $this->equipment_8_value,
                    'note' => $this->equipment_8_note,
                ],
                [
                    'criteria' => 'food_handler_1',
                    'value' => $this->food_handler_1_value,
                    'note' => $this->food_handler_1_note,
                ],
                [
                    'criteria' => 'food_handler_2',
                    'value' => $this->food_handler_2_value,
                    'note' => $this->food_handler_2_note,
                ],
                [
                    'criteria' => 'food_handler_3',
                    'value' => $this->food_handler_3_value,
                    'note' => $this->food_handler_3_note,
                ],
                [
                    'criteria' => 'food_handler_4',
                    'value' => $this->food_handler_4_value,
                    'note' => $this->food_handler_4_note,
                ],
                [
                    'criteria' => 'food_handler_5',
                    'value' => $this->food_handler_5_value,
                    'note' => $this->food_handler_5_note,
                ],
                [
                    'criteria' => 'food_handler_6',
                    'value' => $this->food_handler_6_value,
                    'note' => $this->food_handler_6_note,
                ],
                [
                    'criteria' => 'food_handler_7',
                    'value' => $this->food_handler_7_value,
                    'note' => $this->food_handler_7_note,
                ],
                [
                    'criteria' => 'food_handler_8',
                    'value' => $this->food_handler_8_value,
                    'note' => $this->food_handler_8_note,
                ],
                [
                    'criteria' => 'food_handler_9',
                    'value' => $this->food_handler_9_value,
                    'note' => $this->food_handler_9_note,
                ],
                [
                    'criteria' => 'food_handler_10',
                    'value' => $this->food_handler_10_value,
                    'note' => $this->food_handler_10_note,
                ],
                [
                    'criteria' => 'food_handler_11',
                    'value' => $this->food_handler_11_value,
                    'note' => $this->food_handler_11_note,
                ],
                [
                    'criteria' => 'food_handler_12',
                    'value' => $this->food_handler_12_value,
                    'note' => $this->food_handler_12_note,
                ],
                [
                    'criteria' => 'food_storage_1',
                    'value' => $this->food_storage_1_value,
                    'note' => $this->food_storage_1_note,
                ],
                [
                    'criteria' => 'food_storage_2',
                    'value' => $this->food_storage_2_value,
                    'note' => $this->food_storage_2_note,
                ],
                [
                    'criteria' => 'food_storage_3',
                    'value' => $this->food_storage_3_value,
                    'note' => $this->food_storage_3_note,
                ],
                [
                    'criteria' => 'food_storage_4',
                    'value' => $this->food_storage_4_value,
                    'note' => $this->food_storage_4_note,
                ],
                [
                    'criteria' => 'food_storage_5',
                    'value' => $this->food_storage_5_value,
                    'note' => $this->food_storage_5_note,
                ],
                [
                    'criteria' => 'food_processers_1',
                    'value' => $this->food_processers_1_value,
                    'note' => $this->food_processers_1_note,
                ],
                [
                    'criteria' => 'food_processers_2',
                    'value' => $this->food_processers_2_value,
                    'note' => $this->food_processers_2_note,
                ],
                [
                    'criteria' => 'food_processers_3',
                    'value' => $this->food_processers_3_value,
                    'note' => $this->food_processers_3_note,
                ],
                [
                    'criteria' => 'food_processers_4',
                    'value' => $this->food_processers_4_value,
                    'note' => $this->food_processers_4_note,
                ],
                [
                    'criteria' => 'food_processers_5',
                    'value' => $this->food_processers_5_value,
                    'note' => $this->food_processers_5_note,
                ],
                [
                    'criteria' => 'food_processers_6',
                    'value' => $this->food_processers_6_value,
                    'note' => $this->food_processers_6_note,
                ],
                [
                    'criteria' => 'food_processers_7',
                    'value' => $this->food_processers_7_value,
                    'note' => $this->food_processers_7_note,
                ],
                [
                    'criteria' => 'food_transport_1_1',
                    'value' => $this->food_transport_1_1_value,
                    'note' => $this->food_transport_1_1_note,
                ],
                [
                    'criteria' => 'food_transport_1_2',
                    'value' => $this->food_transport_1_2_value,
                    'note' => $this->food_transport_1_2_note,
                ],
                [
                    'criteria' => 'food_transport_1_3',
                    'value' => $this->food_transport_1_3_value,
                    'note' => $this->food_transport_1_3_note,
                ],
                [
                    'criteria' => 'food_transport_2_1',
                    'value' => $this->food_transport_2_1_value,
                    'note' => $this->food_transport_2_1_note,
                ],
                [
                    'criteria' => 'food_transport_2_2',
                    'value' => $this->food_transport_2_2_value,
                    'note' => $this->food_transport_2_2_note,
                ],
                [
                    'criteria' => 'food_transport_2_3',
                    'value' => $this->food_transport_2_3_value,
                    'note' => $this->food_transport_2_3_note,
                ],
                [
                    'criteria' => 'general_precautions_1',
                    'value' => $this->general_precautions_1_value,
                    'note' => $this->general_precautions_1_note,
                ],
                [
                    'criteria' => 'general_precautions_2',
                    'value' => $this->general_precautions_2_value,
                    'note' => $this->general_precautions_2_note,
                ],
                [
                    'criteria' => 'general_precautions_3',
                    'value' => $this->general_precautions_3_value,
                    'note' => $this->general_precautions_3_note,
                ],
                [
                    'criteria' => 'general_precautions_4',
                    'value' => $this->general_precautions_4_value,
                    'note' => $this->general_precautions_4_note,
                ],
                [
                    'criteria' => 'general_precautions_5',
                    'value' => $this->general_precautions_5_value,
                    'note' => $this->general_precautions_5_note,
                ],
            ];

            foreach ($InspectionDatas as $InspectionData) {
                if (isset($InspectionData['value'])) {

                    $InspectionData['label_id'] = $label_store->id;

                    if ($this->{$InspectionData['criteria'] . '_file'} && !is_string($this->{$InspectionData['criteria'] . '_file'})) {
                        $filetype = pathinfo($this->{$InspectionData['criteria'] . '_file'}->path(), PATHINFO_EXTENSION);
                        $file_name = "" . $label_store->id . "-" . $InspectionData['criteria'] . "_file.$filetype";
                        $this->{$InspectionData['criteria'] . '_file'}->storeAs('kplh/food_hygiene', $file_name, ['disk' => 'local']);
                        $InspectionData['file'] = $file_name;
                    } else {
                        $InspectionData['file'] = null;
                    }

                    $kplh_data = InspectionData::create($InspectionData);

                    // PICA
                    if ($status != 'draft' && $InspectionData['value'] < 10) {

                        $this->validate([
                            '' . $kplh_data->criteria . '_file' => 'required',
                            '' . $kplh_data->criteria . '_note' => 'required',
                        ]);

                        // $riskCondition = $kplh_data->risks()->create([
                        //     'kplh_data_id' => $kplh_data->id,
                        //     'risk_value' => $kplh_data->value,
                        //     'risk_condition' => $kplh_data->note,
                        // ]);

                        // $picaDocument = $riskCondition->pica()->create([
                        //     'identity_id' => $this->generateIdentityId($kplh_data->created_at), // new field for pica document

                        //     'source' => PicaSource::InspeksiKPLH, // buat enum
                        //     'type' => 'food-hygiene',
                        //     'ccow_id' => $this->ccow_id,
                        //     'company_id' => $this->companyId,
                        //     'section_id' => $this->sectionId,
                        //     'pja_id' => $this->pjaId,
                        //     'pjo_id' => $this->kttId,

                        //     'auditor' => auth()->user()->name,
                        //     'requested' => PicaStatus::NewRequest, // new field for pica document
                        //     'published' => PicaStatus::Publish, // new field for pica document
                        //     'status' => PicaStatus::Open,
                        // ]);

                        // // create pica morph
                        // $picaDocument->pica()->create([
                        //     'source' => 'Inspeksi KPLH',
                        //     'source_id' => $riskCondition->id,
                        //     'picaable_id' => $picaDocument->id,
                        //     'picaable_type' => InspectionRisks::class,
                        // ]);

                        // // create pica file from module
                        // if (isset($kplh_data->file)) {
                        //     $picaDocument->picaFiles()->create([
                        //         'file' => $kplh_data->file,
                        //         'size' => null,
                        //         'type' => null,
                        //     ]);
                        // }

                        // // create pica activity
                        // $picaDocument->activities()->create([
                        //     'description' => 'New Request',
                        //     'user_id' => auth()->user()->id,
                        // ]);
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
        return view('kplh::livewire.food-hygiene.add')->extends('kplh::layouts.no-header');
    }
}
