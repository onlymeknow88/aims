<?php

namespace Modules\Kplh\Http\Livewire\AreaJetty;

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
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Modules\Kplh\Entities\InspectionData;
use Modules\Kplh\Entities\InspectionRisks;
use Modules\Kplh\Entities\KplhLabel;
use Modules\Kplh\Entities\KplhLabelIO;

class Add extends Component
{
    use WithFileUploads,LivewireAlert;

    public $mode, $date, $ccow, $ccow_id, $companyId, $departmentId, $sectionId, $area_location_id, $detail_location, $kttId, $pjaId;
    public $inspectionOfficer = [];
    public $companyType = null;

    public $jetty_1_a_value, $jetty_1_a_file, $jetty_1_a_note, $jetty_1_b_1_value, $jetty_1_b_1_file, $jetty_1_b_1_note, $jetty_1_b_2_value, $jetty_1_b_2_file, $jetty_1_b_2_note, $jetty_1_b_3_value, $jetty_1_b_3_file, $jetty_1_b_3_note;
    public $jetty_1_c_1_value, $jetty_1_c_1_file, $jetty_1_c_1_note, $jetty_1_c_2_value, $jetty_1_c_2_file, $jetty_1_c_2_note, $jetty_1_c_3_value, $jetty_1_c_3_file, $jetty_1_c_3_note;
    public $jetty_1_d_1_value, $jetty_1_d_1_file, $jetty_1_d_1_note, $jetty_1_d_2_value, $jetty_1_d_2_file, $jetty_1_d_2_note, $jetty_1_d_3_value, $jetty_1_d_3_file, $jetty_1_d_3_note, $jetty_1_d_4_value, $jetty_1_d_4_file, $jetty_1_d_4_note;
    public $jetty_1_e_value, $jetty_1_e_file, $jetty_1_e_note;
    public $jetty_1_f_1_value, $jetty_1_f_1_file, $jetty_1_f_1_note, $jetty_1_f_2_value, $jetty_1_f_2_file, $jetty_1_f_2_note;
    public $jetty_1_g_1_value, $jetty_1_g_1_file, $jetty_1_g_1_note, $jetty_1_g_2_value, $jetty_1_g_2_file, $jetty_1_g_2_note, $jetty_1_g_3_value, $jetty_1_g_3_file, $jetty_1_g_3_note;
    public $jetty_1_h_value, $jetty_1_h_file, $jetty_1_h_note;
    public $jetty_1_i_value, $jetty_1_i_file, $jetty_1_i_note;
    public $jetty_1_j_1_value, $jetty_1_j_1_file, $jetty_1_j_1_note, $jetty_1_j_2_value, $jetty_1_j_2_file, $jetty_1_j_2_note, $jetty_1_j_3_value, $jetty_1_j_3_file, $jetty_1_j_3_note;
    public $jetty_2_a_1_value, $jetty_2_a_1_file, $jetty_2_a_1_note, $jetty_2_a_2_value, $jetty_2_a_2_file, $jetty_2_a_2_note, $jetty_2_a_3_value, $jetty_2_a_3_file, $jetty_2_a_3_note;
    public $jetty_2_b_value, $jetty_2_b_file, $jetty_2_b_note;
    public $jetty_2_c_1_value, $jetty_2_c_1_file, $jetty_2_c_1_note, $jetty_2_c_2_value, $jetty_2_c_2_file, $jetty_2_c_2_note, $jetty_2_c_3_value, $jetty_2_c_3_file, $jetty_2_c_3_note, $jetty_2_c_4_value, $jetty_2_c_4_file, $jetty_2_c_4_note;
    public $jetty_2_d_1_value, $jetty_2_d_1_file, $jetty_2_d_1_note, $jetty_2_d_2_value, $jetty_2_d_2_file, $jetty_2_d_2_note;
    public $jetty_2_e_1_value, $jetty_2_e_1_file, $jetty_2_e_1_note, $jetty_2_e_2_value, $jetty_2_e_2_file, $jetty_2_e_2_note, $jetty_2_e_3_value, $jetty_2_e_3_file, $jetty_2_e_3_note;
    public $jetty_2_f_value, $jetty_2_f_file, $jetty_2_f_note, $jetty_2_g_value, $jetty_2_g_file, $jetty_2_g_note, $jetty_2_h_value, $jetty_2_h_file, $jetty_2_h_note;
    public $jetty_2_i_1_value, $jetty_2_i_1_file, $jetty_2_i_1_note, $jetty_2_i_2_value, $jetty_2_i_2_file, $jetty_2_i_2_note, $jetty_2_i_3_value, $jetty_2_i_3_file, $jetty_2_i_3_note;
    public $jetty_2_j_value, $jetty_2_j_file, $jetty_2_j_note, $jetty_2_k_value, $jetty_2_k_file, $jetty_2_k_note, $jetty_2_l_value, $jetty_2_l_file, $jetty_2_l_note;
    public $jetty_3_a_1_value, $jetty_3_a_1_file, $jetty_3_a_1_note, $jetty_3_a_2_value, $jetty_3_a_2_file, $jetty_3_a_2_note;

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
                    'jetty_1_a_value' => 'required',
                    'jetty_1_b_1_value' => 'required',
                    'jetty_1_b_2_value' => 'required',
                    'jetty_1_b_3_value' => 'required',
                    'jetty_1_c_1_value' => 'required',
                    'jetty_1_c_2_value' => 'required',
                    'jetty_1_c_3_value' => 'required',
                    'jetty_1_d_1_value' => 'required',
                    'jetty_1_d_2_value' => 'required',
                    'jetty_1_d_3_value' => 'required',
                    'jetty_1_d_4_value' => 'required',
                    'jetty_1_e_value' => 'required',
                    'jetty_1_f_1_value' => 'required',
                    'jetty_1_f_2_value' => 'required',
                    'jetty_1_g_1_value' => 'required',
                    'jetty_1_g_2_value' => 'required',
                    'jetty_1_g_3_value' => 'required',
                    'jetty_1_h_value' => 'required',
                    'jetty_1_i_value' => 'required',
                    'jetty_1_j_1_value' => 'required',
                    'jetty_1_j_2_value' => 'required',
                    'jetty_1_j_3_value' => 'required',
                    'jetty_2_a_1_value' => 'required',
                    'jetty_2_a_2_value' => 'required',
                    'jetty_2_a_3_value' => 'required',
                    'jetty_2_b_value' => 'required',
                    'jetty_2_c_1_value' => 'required',
                    'jetty_2_c_2_value' => 'required',
                    'jetty_2_c_3_value' => 'required',
                    'jetty_2_c_4_value' => 'required',
                    'jetty_2_d_1_value' => 'required',
                    'jetty_2_d_2_value' => 'required',
                    'jetty_2_e_1_value' => 'required',
                    'jetty_2_e_2_value' => 'required',
                    'jetty_2_e_3_value' => 'required',
                    'jetty_2_f_value' => 'required',
                    'jetty_2_g_value' => 'required',
                    'jetty_2_h_value' => 'required',
                    'jetty_2_i_1_value' => 'required',
                    'jetty_2_i_2_value' => 'required',
                    'jetty_2_i_3_value' => 'required',
                    'jetty_2_j_value' => 'required',
                    'jetty_2_k_value' => 'required',
                    'jetty_2_l_value' => 'required',
                    'jetty_3_a_1_value' => 'required',
                    'jetty_3_a_2_value' => 'required',
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
                'inspect_criteria' => 'area-jetty',
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
                    'criteria' => 'jetty_1_a',
                    'k3_value' => $this->jetty_1_a_value,
                    'note' => $this->jetty_1_a_note,
                ],
                [
                    'criteria' => 'jetty_1_b_1',
                    'k3_value' => $this->jetty_1_b_1_value,
                    'note' => $this->jetty_1_b_1_note,
                ],
                [
                    'criteria' => 'jetty_1_b_2',
                    'k3_value' => $this->jetty_1_b_2_value,
                    'note' => $this->jetty_1_b_2_note,
                ],
                [
                    'criteria' => 'jetty_1_b_3',
                    'k3_value' => $this->jetty_1_b_3_value,
                    'note' => $this->jetty_1_b_3_note,
                ],
                [
                    'criteria' => 'jetty_1_c_1',
                    'k3_value' => $this->jetty_1_c_1_value,
                    'note' => $this->jetty_1_c_1_note,
                ],
                [
                    'criteria' => 'jetty_1_c_2',
                    'k3_value' => $this->jetty_1_c_2_value,
                    'note' => $this->jetty_1_c_2_note,
                ],
                [
                    'criteria' => 'jetty_1_c_3',
                    'k3_value' => $this->jetty_1_c_3_value,
                    'note' => $this->jetty_1_c_3_note,
                ],
                [
                    'criteria' => 'jetty_1_d_1',
                    'k3_value' => $this->jetty_1_d_1_value,
                    'note' => $this->jetty_1_d_1_note,
                ],
                [
                    'criteria' => 'jetty_1_d_2',
                    'k3_value' => $this->jetty_1_d_2_value,
                    'note' => $this->jetty_1_d_2_note,
                ],
                [
                    'criteria' => 'jetty_1_d_3',
                    'k3_value' => $this->jetty_1_d_3_value,
                    'note' => $this->jetty_1_d_3_note,
                ],
                [
                    'criteria' => 'jetty_1_d_4',
                    'k3_value' => $this->jetty_1_d_4_value,
                    'note' => $this->jetty_1_d_4_note,
                ],
                [
                    'criteria' => 'jetty_1_e',
                    'k3_value' => $this->jetty_1_e_value,
                    'note' => $this->jetty_1_e_note,
                ],
                [
                    'criteria' => 'jetty_1_f_1',
                    'k3_value' => $this->jetty_1_f_1_value,
                    'note' => $this->jetty_1_f_1_note,
                ],
                [
                    'criteria' => 'jetty_1_f_2',
                    'k3_value' => $this->jetty_1_f_2_value,
                    'note' => $this->jetty_1_f_2_note,
                ],
                [
                    'criteria' => 'jetty_1_g_1',
                    'k3_value' => $this->jetty_1_g_1_value,
                    'note' => $this->jetty_1_g_1_note,
                ],
                [
                    'criteria' => 'jetty_1_g_2',
                    'k3_value' => $this->jetty_1_g_2_value,
                    'note' => $this->jetty_1_g_2_note,
                ],
                [
                    'criteria' => 'jetty_1_g_3',
                    'k3_value' => $this->jetty_1_g_3_value,
                    'note' => $this->jetty_1_g_3_note,
                ],
                [
                    'criteria' => 'jetty_1_h',
                    'k3_value' => $this->jetty_1_h_value,
                    'note' => $this->jetty_1_h_note,
                ],
                [
                    'criteria' => 'jetty_1_i',
                    'k3_value' => $this->jetty_1_i_value,
                    'note' => $this->jetty_1_i_note,
                ],
                [
                    'criteria' => 'jetty_1_j_1',
                    'k3_value' => $this->jetty_1_j_1_value,
                    'note' => $this->jetty_1_j_1_note,
                ],
                [
                    'criteria' => 'jetty_1_j_2',
                    'k3_value' => $this->jetty_1_j_2_value,
                    'note' => $this->jetty_1_j_2_note,
                ],
                [
                    'criteria' => 'jetty_1_j_3',
                    'k3_value' => $this->jetty_1_j_3_value,
                    'note' => $this->jetty_1_j_3_note,
                ],
                [
                    'criteria' => 'jetty_2_a_1',
                    'k3_value' => $this->jetty_2_a_1_value,
                    'note' => $this->jetty_2_a_1_note,
                ],
                [
                    'criteria' => 'jetty_2_a_2',
                    'k3_value' => $this->jetty_2_a_2_value,
                    'note' => $this->jetty_2_a_2_note,
                ],
                [
                    'criteria' => 'jetty_2_a_3',
                    'k3_value' => $this->jetty_2_a_3_value,
                    'note' => $this->jetty_2_a_3_note,
                ],
                [
                    'criteria' => 'jetty_2_b',
                    'k3_value' => $this->jetty_2_b_value,
                    'note' => $this->jetty_2_b_note,
                ],
                [
                    'criteria' => 'jetty_2_c_1',
                    'k3_value' => $this->jetty_2_c_1_value,
                    'note' => $this->jetty_2_c_1_note,
                ],
                [
                    'criteria' => 'jetty_2_c_2',
                    'k3_value' => $this->jetty_2_c_2_value,
                    'note' => $this->jetty_2_c_2_note,
                ],
                [
                    'criteria' => 'jetty_2_c_3',
                    'k3_value' => $this->jetty_2_c_3_value,
                    'note' => $this->jetty_2_c_3_note,
                ],
                [
                    'criteria' => 'jetty_2_c_4',
                    'k3_value' => $this->jetty_2_c_4_value,
                    'note' => $this->jetty_2_c_4_note,
                ],
                [
                    'criteria' => 'jetty_2_d_1',
                    'k3_value' => $this->jetty_2_d_1_value,
                    'note' => $this->jetty_2_d_1_note,
                ],
                [
                    'criteria' => 'jetty_2_d_2',
                    'k3_value' => $this->jetty_2_d_2_value,
                    'note' => $this->jetty_2_d_2_note,
                ],
                [
                    'criteria' => 'jetty_2_e_1',
                    'k3_value' => $this->jetty_2_e_1_value,
                    'note' => $this->jetty_2_e_1_note,
                ],
                [
                    'criteria' => 'jetty_2_e_2',
                    'k3_value' => $this->jetty_2_e_2_value,
                    'note' => $this->jetty_2_e_2_note,
                ],
                [
                    'criteria' => 'jetty_2_e_3',
                    'k3_value' => $this->jetty_2_e_3_value,
                    'note' => $this->jetty_2_e_3_note,
                ],
                [
                    'criteria' => 'jetty_2_f',
                    'k3_value' => $this->jetty_2_f_value,
                    'note' => $this->jetty_2_f_note,
                ],
                [
                    'criteria' => 'jetty_2_g',
                    'k3_value' => $this->jetty_2_g_value,
                    'note' => $this->jetty_2_g_note,
                ],
                [
                    'criteria' => 'jetty_2_h',
                    'k3_value' => $this->jetty_2_h_value,
                    'note' => $this->jetty_2_h_note,
                ],
                [
                    'criteria' => 'jetty_2_i_1',
                    'k3_value' => $this->jetty_2_i_1_value,
                    'note' => $this->jetty_2_i_1_note,
                ],
                [
                    'criteria' => 'jetty_2_i_2',
                    'k3_value' => $this->jetty_2_i_2_value,
                    'note' => $this->jetty_2_i_2_note,
                ],
                [
                    'criteria' => 'jetty_2_i_3',
                    'k3_value' => $this->jetty_2_i_3_value,
                    'note' => $this->jetty_2_i_3_note,
                ],
                [
                    'criteria' => 'jetty_2_j',
                    'k3_value' => $this->jetty_2_j_value,
                    'note' => $this->jetty_2_j_note,
                ],
                [
                    'criteria' => 'jetty_2_k',
                    'k3_value' => $this->jetty_2_k_value,
                    'note' => $this->jetty_2_k_note,
                ],
                [
                    'criteria' => 'jetty_2_l',
                    'k3_value' => $this->jetty_2_l_value,
                    'note' => $this->jetty_2_l_note,
                ],
                [
                    'criteria' => 'jetty_3_a_1',
                    'k3_value' => $this->jetty_3_a_1_value,
                    'note' => $this->jetty_3_a_1_note,
                ],
                [
                    'criteria' => 'jetty_3_a_2',
                    'k3_value' => $this->jetty_3_a_2_value,
                    'note' => $this->jetty_3_a_2_note,
                ],
            ];

            foreach ($InspectionDatas as $InspectionData) {
                if (isset($InspectionData['k3_value'])) {

                    $InspectionData['label_id'] = $label_store->id;

                    if ($this->{$InspectionData['criteria'] . '_file'} && !is_string($this->{$InspectionData['criteria'] . '_file'})) {
                        $filetype = pathinfo($this->{$InspectionData['criteria'] . '_file'}->path(), PATHINFO_EXTENSION);
                        $file_name = "" . $label_store->id . "-" . $InspectionData['criteria'] . "_file.$filetype";
                        $this->{$InspectionData['criteria'] . '_file'}->storeAs('kplh/jetty', $file_name, ['disk' => 'local']);
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
                        //     'type' => 'area-jetty',
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

            // $this->dispatchBrowserEvent('swal', [
            //     'title' => 'Berhasil',
            //     'icon' => 'success',
            //     'text' => 'Data Inspeksi berhasil di simpan',
            // ]);


            $this->flash('success', 'Data berhasil di simpan!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
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
        return view('kplh::livewire.area-jetty.add')->extends('kplh::layouts.no-header');
    }
}
