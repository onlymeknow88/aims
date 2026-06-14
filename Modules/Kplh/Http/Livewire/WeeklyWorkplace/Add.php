<?php

namespace Modules\Kplh\Http\Livewire\WeeklyWorkplace;

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

    public $workplace_a_1_value, $workplace_a_1_file, $workplace_a_1_note, $workplace_a_2_value, $workplace_a_2_file, $workplace_a_2_note, $workplace_a_3_value, $workplace_a_3_file, $workplace_a_3_note, $workplace_a_4_value, $workplace_a_4_file, $workplace_a_4_note, $workplace_a_5_value, $workplace_a_5_file, $workplace_a_5_note, $workplace_a_6_value, $workplace_a_6_file, $workplace_a_6_note, $workplace_a_7_value, $workplace_a_7_file, $workplace_a_7_note, $workplace_a_8_value, $workplace_a_8_file, $workplace_a_8_note, $workplace_a_9_value, $workplace_a_9_file, $workplace_a_9_note, $workplace_a_10_value, $workplace_a_10_file, $workplace_a_10_note, $workplace_a_11_value, $workplace_a_11_file, $workplace_a_11_note, $workplace_a_12_value, $workplace_a_12_file, $workplace_a_12_note, $workplace_a_13_value, $workplace_a_13_file, $workplace_a_13_note;
    public $workplace_b_1_value, $workplace_b_1_file, $workplace_b_1_note, $workplace_b_2_value, $workplace_b_2_file, $workplace_b_2_note, $workplace_b_3_value, $workplace_b_3_file, $workplace_b_3_note, $workplace_b_4_value, $workplace_b_4_file, $workplace_b_4_note, $workplace_b_5_value, $workplace_b_5_file, $workplace_b_5_note, $workplace_b_6_value, $workplace_b_6_file, $workplace_b_6_note, $workplace_b_7_value, $workplace_b_7_file, $workplace_b_7_note;
    public $workplace_c_1_value, $workplace_c_1_file, $workplace_c_1_note, $workplace_c_2_value, $workplace_c_2_file, $workplace_c_2_note, $workplace_c_3_value, $workplace_c_3_file, $workplace_c_3_note;
    public $workplace_d_1_value, $workplace_d_1_file, $workplace_d_1_note, $workplace_d_2_value, $workplace_d_2_file, $workplace_d_2_note, $workplace_d_3_value, $workplace_d_3_file, $workplace_d_3_note, $workplace_d_4_value, $workplace_d_4_file, $workplace_d_4_note, $workplace_d_5_value, $workplace_d_5_file, $workplace_d_5_note, $workplace_d_6_value, $workplace_d_6_file, $workplace_d_6_note, $workplace_d_7_value, $workplace_d_7_file, $workplace_d_7_note, $workplace_d_8_value, $workplace_d_8_file, $workplace_d_8_note, $workplace_d_9_value, $workplace_d_9_file, $workplace_d_9_note;
    public $workplace_e_1_value, $workplace_e_1_file, $workplace_e_1_note, $workplace_e_2_value, $workplace_e_2_file, $workplace_e_2_note, $workplace_e_3_value, $workplace_e_3_file, $workplace_e_3_note, $workplace_e_4_value, $workplace_e_4_file, $workplace_e_4_note, $workplace_e_5_value, $workplace_e_5_file, $workplace_e_5_note, $workplace_e_6_value, $workplace_e_6_file, $workplace_e_6_note;
    public $workplace_f_1_value, $workplace_f_1_file, $workplace_f_1_note, $workplace_f_2_value, $workplace_f_2_file, $workplace_f_2_note, $workplace_f_3_value, $workplace_f_3_file, $workplace_f_3_note, $workplace_f_4_value, $workplace_f_4_file, $workplace_f_4_note, $workplace_f_5_value, $workplace_f_5_file, $workplace_f_5_note, $workplace_f_6_value, $workplace_f_6_file, $workplace_f_6_note, $workplace_f_7_value, $workplace_f_7_file, $workplace_f_7_note, $workplace_f_8_value, $workplace_f_8_file, $workplace_f_8_note, $workplace_f_9_value, $workplace_f_9_file, $workplace_f_9_note;
    public $workplace_g_1_value, $workplace_g_1_file, $workplace_g_1_note, $workplace_g_2_value, $workplace_g_2_file, $workplace_g_2_note, $workplace_g_3_value, $workplace_g_3_file, $workplace_g_3_note, $workplace_g_4_value, $workplace_g_4_file, $workplace_g_4_note, $workplace_g_5_value, $workplace_g_5_file, $workplace_g_5_note, $workplace_g_6_value, $workplace_g_6_file, $workplace_g_6_note, $workplace_g_7_value, $workplace_g_7_file, $workplace_g_7_note, $workplace_g_8_value, $workplace_g_8_file, $workplace_g_8_note;
    public $workplace_h_1_value, $workplace_h_1_file, $workplace_h_1_note, $workplace_h_2_value, $workplace_h_2_file, $workplace_h_2_note, $workplace_h_3_value, $workplace_h_3_file, $workplace_h_3_note, $workplace_h_4_value, $workplace_h_4_file, $workplace_h_4_note, $workplace_h_5_value, $workplace_h_5_file, $workplace_h_5_note, $workplace_h_6_value, $workplace_h_6_file, $workplace_h_6_note;
    public $workplace_i_1_value, $workplace_i_1_file, $workplace_i_1_note, $workplace_i_2_value, $workplace_i_2_file, $workplace_i_2_note, $workplace_i_3_value, $workplace_i_3_file, $workplace_i_3_note, $workplace_i_4_value, $workplace_i_4_file, $workplace_i_4_note, $workplace_i_5_value, $workplace_i_5_file, $workplace_i_5_note, $workplace_i_6_value, $workplace_i_6_file, $workplace_i_6_note, $workplace_i_7_value, $workplace_i_7_file, $workplace_i_7_note, $workplace_i_8_value, $workplace_i_8_file, $workplace_i_8_note;
    public $workplace_j_1_value, $workplace_j_1_file, $workplace_j_1_note, $workplace_j_2_value, $workplace_j_2_file, $workplace_j_2_note, $workplace_j_3_value, $workplace_j_3_file, $workplace_j_3_note, $workplace_j_4_value, $workplace_j_4_file, $workplace_j_4_note, $workplace_j_5_value, $workplace_j_5_file, $workplace_j_5_note, $workplace_j_6_value, $workplace_j_6_file, $workplace_j_6_note, $workplace_j_7_value, $workplace_j_7_file, $workplace_j_7_note, $workplace_j_8_value, $workplace_j_8_file, $workplace_j_8_note;
    public $workplace_k_1_value, $workplace_k_1_file, $workplace_k_1_note, $workplace_k_2_value, $workplace_k_2_file, $workplace_k_2_note, $workplace_k_3_value, $workplace_k_3_file, $workplace_k_3_note, $workplace_k_4_value, $workplace_k_4_file, $workplace_k_4_note, $workplace_k_5_value, $workplace_k_5_file, $workplace_k_5_note, $workplace_k_6_value, $workplace_k_6_file, $workplace_k_6_note, $workplace_k_7_value, $workplace_k_7_file, $workplace_k_7_note, $workplace_k_8_value, $workplace_k_8_file, $workplace_k_8_note, $workplace_k_9_value, $workplace_k_9_file, $workplace_k_9_note, $workplace_k_10_value, $workplace_k_10_file, $workplace_k_10_note, $workplace_k_11_value, $workplace_k_11_file, $workplace_k_11_note, $workplace_k_12_value, $workplace_k_12_file, $workplace_k_12_note;
    public $workplace_l_1_value, $workplace_l_1_file, $workplace_l_1_note, $workplace_l_2_value, $workplace_l_2_file, $workplace_l_2_note, $workplace_l_3_value, $workplace_l_3_file, $workplace_l_3_note, $workplace_l_4_value, $workplace_l_4_file, $workplace_l_4_note, $workplace_l_5_value, $workplace_l_5_file, $workplace_l_5_note, $workplace_l_6_value, $workplace_l_6_file, $workplace_l_6_note, $workplace_l_7_value, $workplace_l_7_file, $workplace_l_7_note, $workplace_l_8_value, $workplace_l_8_file, $workplace_l_8_note, $workplace_l_9_value, $workplace_l_9_file, $workplace_l_9_note, $workplace_l_10_value, $workplace_l_10_file, $workplace_l_10_note, $workplace_l_11_value, $workplace_l_11_file, $workplace_l_11_note, $workplace_l_12_value, $workplace_l_12_file, $workplace_l_12_note, $workplace_l_13_value, $workplace_l_13_file, $workplace_l_13_note;
    public $workplace_m_1_value, $workplace_m_1_file, $workplace_m_1_note, $workplace_m_2_value, $workplace_m_2_file, $workplace_m_2_note, $workplace_m_3_value, $workplace_m_3_file, $workplace_m_3_note, $workplace_m_4_value, $workplace_m_4_file, $workplace_m_4_note;
    public $workplace_n_1_value, $workplace_n_1_file, $workplace_n_1_note, $workplace_n_2_value, $workplace_n_2_file, $workplace_n_2_note, $workplace_n_3_value, $workplace_n_3_file, $workplace_n_3_note, $workplace_n_4_value, $workplace_n_4_file, $workplace_n_4_note, $workplace_n_5_value, $workplace_n_5_file, $workplace_n_5_note, $workplace_n_6_value, $workplace_n_6_file, $workplace_n_6_note, $workplace_n_7_value, $workplace_n_7_file, $workplace_n_7_note, $workplace_n_8_value, $workplace_n_8_file, $workplace_n_8_note, $workplace_n_9_value, $workplace_n_9_file, $workplace_n_9_note, $workplace_n_10_value, $workplace_n_10_file, $workplace_n_10_note, $workplace_n_11_value, $workplace_n_11_file, $workplace_n_11_note, $workplace_n_12_value, $workplace_n_12_file, $workplace_n_12_note, $workplace_n_13_value, $workplace_n_13_file, $workplace_n_13_note, $workplace_n_14_value, $workplace_n_14_file, $workplace_n_14_note, $workplace_n_15_value, $workplace_n_15_file, $workplace_n_15_note, $workplace_n_16_value, $workplace_n_16_file, $workplace_n_16_note;
    public $workplace_o_1_value, $workplace_o_1_file, $workplace_o_1_note, $workplace_o_2_value, $workplace_o_2_file, $workplace_o_2_note, $workplace_o_3_value, $workplace_o_3_file, $workplace_o_3_note, $workplace_o_4_value, $workplace_o_4_file, $workplace_o_4_note, $workplace_o_5_value, $workplace_o_5_file, $workplace_o_5_note, $workplace_o_6_value, $workplace_o_6_file, $workplace_o_6_note;
    public $workplace_p_1_value, $workplace_p_1_file, $workplace_p_1_note, $workplace_p_2_value, $workplace_p_2_file, $workplace_p_2_note, $workplace_p_3_value, $workplace_p_3_file, $workplace_p_3_note, $workplace_p_4_value, $workplace_p_4_file, $workplace_p_4_note, $workplace_p_5_value, $workplace_p_5_file, $workplace_p_5_note, $workplace_p_6_value, $workplace_p_6_file, $workplace_p_6_note, $workplace_p_7_value, $workplace_p_7_file, $workplace_p_7_note, $workplace_p_8_value, $workplace_p_8_file, $workplace_p_8_note;
    public $workplace_q_1_value, $workplace_q_1_file, $workplace_q_1_note, $workplace_q_2_value, $workplace_q_2_file, $workplace_q_2_note, $workplace_q_3_value, $workplace_q_3_file, $workplace_q_3_note, $workplace_q_4_value, $workplace_q_4_file, $workplace_q_4_note, $workplace_q_5_value, $workplace_q_5_file, $workplace_q_5_note, $workplace_q_6_value, $workplace_q_6_file, $workplace_q_6_note, $workplace_q_7_value, $workplace_q_7_file, $workplace_q_7_note, $workplace_q_8_value, $workplace_q_8_file, $workplace_q_8_note, $workplace_q_9_value, $workplace_q_9_file, $workplace_q_9_note, $workplace_q_10_value, $workplace_q_10_file, $workplace_q_10_note;
    public $workplace_r_1_value, $workplace_r_1_file, $workplace_r_1_note, $workplace_r_2_value, $workplace_r_2_file, $workplace_r_2_note, $workplace_r_3_value, $workplace_r_3_file, $workplace_r_3_note, $workplace_r_4_value, $workplace_r_4_file, $workplace_r_4_note, $workplace_r_5_value, $workplace_r_5_file, $workplace_r_5_note;
    public $workplace_s_1_value, $workplace_s_1_file, $workplace_s_1_note, $workplace_s_2_value, $workplace_s_2_file, $workplace_s_2_note, $workplace_s_3_value, $workplace_s_3_file, $workplace_s_3_note, $workplace_s_4_value, $workplace_s_4_file, $workplace_s_4_note, $workplace_s_5_value, $workplace_s_5_file, $workplace_s_5_note, $workplace_s_6_value, $workplace_s_6_file, $workplace_s_6_note, $workplace_s_7_value, $workplace_s_7_file, $workplace_s_7_note, $workplace_s_8_value, $workplace_s_8_file, $workplace_s_8_note, $workplace_s_9_value, $workplace_s_9_file, $workplace_s_9_note;

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
            $this->kttId = $this->ccow->user_id;

            $this->employees = Employee::where(function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->whereHas('department', function ($query) {
                        $query->where('company_id', $this->ccow_id);
                    });
                });
            })->get();
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
                    'workplace_a_1_value' => 'required',
                    'workplace_a_2_value' => 'required',
                    'workplace_a_3_value' => 'required',
                    'workplace_a_4_value' => 'required',
                    'workplace_a_5_value' => 'required',
                    'workplace_a_6_value' => 'required',
                    'workplace_a_7_value' => 'required',
                    'workplace_a_8_value' => 'required',
                    'workplace_a_9_value' => 'required',
                    'workplace_a_10_value' => 'required',
                    'workplace_a_11_value' => 'required',
                    'workplace_a_12_value' => 'required',
                    'workplace_a_13_value' => 'required',

                    'workplace_b_1_value' => 'required',
                    'workplace_b_2_value' => 'required',
                    'workplace_b_3_value' => 'required',
                    'workplace_b_4_value' => 'required',
                    'workplace_b_5_value' => 'required',
                    'workplace_b_6_value' => 'required',
                    'workplace_b_7_value' => 'required',

                    'workplace_c_1_value' => 'required',
                    'workplace_c_2_value' => 'required',
                    'workplace_c_3_value' => 'required',

                    'workplace_d_1_value' => 'required',
                    'workplace_d_2_value' => 'required',
                    'workplace_d_3_value' => 'required',
                    'workplace_d_4_value' => 'required',
                    'workplace_d_5_value' => 'required',
                    'workplace_d_6_value' => 'required',
                    'workplace_d_7_value' => 'required',
                    'workplace_d_8_value' => 'required',
                    'workplace_d_9_value' => 'required',

                    'workplace_e_1_value' => 'required',
                    'workplace_e_2_value' => 'required',
                    'workplace_e_3_value' => 'required',
                    'workplace_e_4_value' => 'required',
                    'workplace_e_5_value' => 'required',
                    'workplace_e_6_value' => 'required',

                    'workplace_f_1_value' => 'required',
                    'workplace_f_2_value' => 'required',
                    'workplace_f_3_value' => 'required',
                    'workplace_f_4_value' => 'required',
                    'workplace_f_5_value' => 'required',
                    'workplace_f_6_value' => 'required',
                    'workplace_f_7_value' => 'required',
                    'workplace_f_8_value' => 'required',
                    'workplace_f_9_value' => 'required',

                    'workplace_g_1_value' => 'required',
                    'workplace_g_2_value' => 'required',
                    'workplace_g_3_value' => 'required',
                    'workplace_g_4_value' => 'required',
                    'workplace_g_5_value' => 'required',
                    'workplace_g_6_value' => 'required',
                    'workplace_g_7_value' => 'required',
                    'workplace_g_8_value' => 'required',

                    'workplace_h_1_value' => 'required',
                    'workplace_h_2_value' => 'required',
                    'workplace_h_3_value' => 'required',
                    'workplace_h_4_value' => 'required',
                    'workplace_h_5_value' => 'required',
                    'workplace_h_6_value' => 'required',

                    'workplace_i_1_value' => 'required',
                    'workplace_i_2_value' => 'required',
                    'workplace_i_3_value' => 'required',
                    'workplace_i_4_value' => 'required',
                    'workplace_i_5_value' => 'required',
                    'workplace_i_6_value' => 'required',
                    'workplace_i_7_value' => 'required',
                    'workplace_i_8_value' => 'required',

                    'workplace_j_1_value' => 'required',
                    'workplace_j_2_value' => 'required',
                    'workplace_j_3_value' => 'required',
                    'workplace_j_4_value' => 'required',
                    'workplace_j_5_value' => 'required',
                    'workplace_j_6_value' => 'required',
                    'workplace_j_7_value' => 'required',
                    'workplace_j_8_value' => 'required',

                    'workplace_k_1_value' => 'required',
                    'workplace_k_2_value' => 'required',
                    'workplace_k_3_value' => 'required',
                    'workplace_k_4_value' => 'required',
                    'workplace_k_5_value' => 'required',
                    'workplace_k_6_value' => 'required',
                    'workplace_k_7_value' => 'required',
                    'workplace_k_8_value' => 'required',
                    'workplace_k_9_value' => 'required',
                    'workplace_k_10_value' => 'required',
                    'workplace_k_11_value' => 'required',
                    'workplace_k_12_value' => 'required',

                    'workplace_l_1_value' => 'required',
                    'workplace_l_2_value' => 'required',
                    'workplace_l_3_value' => 'required',
                    'workplace_l_4_value' => 'required',
                    'workplace_l_5_value' => 'required',
                    'workplace_l_6_value' => 'required',
                    'workplace_l_7_value' => 'required',
                    'workplace_l_8_value' => 'required',
                    'workplace_l_9_value' => 'required',
                    'workplace_l_10_value' => 'required',
                    'workplace_l_11_value' => 'required',
                    'workplace_l_12_value' => 'required',
                    'workplace_l_13_value' => 'required',

                    'workplace_m_1_value' => 'required',
                    'workplace_m_2_value' => 'required',
                    'workplace_m_3_value' => 'required',
                    'workplace_m_4_value' => 'required',

                    'workplace_n_1_value' => 'required',
                    'workplace_n_2_value' => 'required',
                    'workplace_n_3_value' => 'required',
                    'workplace_n_4_value' => 'required',
                    'workplace_n_5_value' => 'required',
                    'workplace_n_6_value' => 'required',
                    'workplace_n_7_value' => 'required',
                    'workplace_n_8_value' => 'required',
                    'workplace_n_9_value' => 'required',
                    'workplace_n_10_value' => 'required',
                    'workplace_n_11_value' => 'required',
                    'workplace_n_12_value' => 'required',
                    'workplace_n_13_value' => 'required',
                    'workplace_n_14_value' => 'required',
                    'workplace_n_15_value' => 'required',
                    'workplace_n_16_value' => 'required',

                    'workplace_o_1_value' => 'required',
                    'workplace_o_2_value' => 'required',
                    'workplace_o_3_value' => 'required',
                    'workplace_o_4_value' => 'required',
                    'workplace_o_5_value' => 'required',
                    'workplace_o_6_value' => 'required',

                    'workplace_p_1_value' => 'required',
                    'workplace_p_2_value' => 'required',
                    'workplace_p_3_value' => 'required',
                    'workplace_p_4_value' => 'required',
                    'workplace_p_5_value' => 'required',
                    'workplace_p_6_value' => 'required',
                    'workplace_p_7_value' => 'required',
                    'workplace_p_8_value' => 'required',

                    'workplace_q_1_value' => 'required',
                    'workplace_q_2_value' => 'required',
                    'workplace_q_3_value' => 'required',
                    'workplace_q_4_value' => 'required',
                    'workplace_q_5_value' => 'required',
                    'workplace_q_6_value' => 'required',
                    'workplace_q_7_value' => 'required',
                    'workplace_q_8_value' => 'required',
                    'workplace_q_9_value' => 'required',
                    'workplace_q_10_value' => 'required',

                    'workplace_r_1_value' => 'required',
                    'workplace_r_2_value' => 'required',
                    'workplace_r_3_value' => 'required',
                    'workplace_r_4_value' => 'required',
                    'workplace_r_5_value' => 'required',

                    'workplace_s_1_value' => 'required',
                    'workplace_s_2_value' => 'required',
                    'workplace_s_3_value' => 'required',
                    'workplace_s_4_value' => 'required',
                    'workplace_s_5_value' => 'required',
                    'workplace_s_6_value' => 'required',
                    'workplace_s_7_value' => 'required',
                    'workplace_s_8_value' => 'required',
                    'workplace_s_9_value' => 'required',
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
                'inspect_criteria' => 'workplace',
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
                    'criteria' => 'workplace_a_1',
                    'k3_value' => $this->workplace_a_1_value,
                    'note' => $this->workplace_a_1_note,
                ],
                [
                    'criteria' => 'workplace_a_2',
                    'k3_value' => $this->workplace_a_2_value,
                    'note' => $this->workplace_a_2_note,
                ],
                [
                    'criteria' => 'workplace_a_3',
                    'k3_value' => $this->workplace_a_3_value,
                    'note' => $this->workplace_a_3_note,
                ],
                [
                    'criteria' => 'workplace_a_4',
                    'k3_value' => $this->workplace_a_4_value,
                    'note' => $this->workplace_a_4_note,
                ],
                [
                    'criteria' => 'workplace_a_5',
                    'k3_value' => $this->workplace_a_5_value,
                    'note' => $this->workplace_a_5_note,
                ],
                [
                    'criteria' => 'workplace_a_6',
                    'k3_value' => $this->workplace_a_6_value,
                    'note' => $this->workplace_a_6_note,
                ],
                [
                    'criteria' => 'workplace_a_7',
                    'k3_value' => $this->workplace_a_7_value,
                    'note' => $this->workplace_a_7_note,
                ],
                [
                    'criteria' => 'workplace_a_8',
                    'k3_value' => $this->workplace_a_8_value,
                    'note' => $this->workplace_a_8_note,
                ],
                [
                    'criteria' => 'workplace_a_9',
                    'k3_value' => $this->workplace_a_9_value,
                    'note' => $this->workplace_a_9_note,
                ],
                [
                    'criteria' => 'workplace_a_10',
                    'k3_value' => $this->workplace_a_10_value,
                    'note' => $this->workplace_a_10_note,
                ],
                [
                    'criteria' => 'workplace_a_11',
                    'k3_value' => $this->workplace_a_11_value,
                    'note' => $this->workplace_a_11_note,
                ],
                [
                    'criteria' => 'workplace_a_12',
                    'k3_value' => $this->workplace_a_12_value,
                    'note' => $this->workplace_a_12_note,
                ],
                [
                    'criteria' => 'workplace_a_13',
                    'k3_value' => $this->workplace_a_13_value,
                    'note' => $this->workplace_a_13_note,
                ],
                [
                    'criteria' => 'workplace_b_1',
                    'k3_value' => $this->workplace_b_1_value,
                    'note' => $this->workplace_b_1_note,
                ],
                [
                    'criteria' => 'workplace_b_2',
                    'k3_value' => $this->workplace_b_2_value,
                    'note' => $this->workplace_b_2_note,
                ],
                [
                    'criteria' => 'workplace_b_3',
                    'k3_value' => $this->workplace_b_3_value,
                    'note' => $this->workplace_b_3_note,
                ],
                [
                    'criteria' => 'workplace_b_4',
                    'k3_value' => $this->workplace_b_4_value,
                    'note' => $this->workplace_b_4_note,
                ],
                [
                    'criteria' => 'workplace_b_5',
                    'k3_value' => $this->workplace_b_5_value,
                    'note' => $this->workplace_b_5_note,
                ],
                [
                    'criteria' => 'workplace_b_6',
                    'k3_value' => $this->workplace_b_6_value,
                    'note' => $this->workplace_b_6_note,
                ],
                [
                    'criteria' => 'workplace_b_7',
                    'k3_value' => $this->workplace_b_7_value,
                    'note' => $this->workplace_b_7_note,
                ],
                [
                    'criteria' => 'workplace_c_1',
                    'k3_value' => $this->workplace_c_1_value,
                    'note' => $this->workplace_c_1_note,
                ],
                [
                    'criteria' => 'workplace_c_2',
                    'k3_value' => $this->workplace_c_2_value,
                    'note' => $this->workplace_c_2_note,
                ],
                [
                    'criteria' => 'workplace_c_3',
                    'k3_value' => $this->workplace_c_3_value,
                    'note' => $this->workplace_c_3_note,
                ],

                [
                    'criteria' => 'workplace_d_1',
                    'k3_value' => $this->workplace_d_1_value,
                    'note' => $this->workplace_d_1_note,
                ],
                [
                    'criteria' => 'workplace_d_2',
                    'k3_value' => $this->workplace_d_2_value,
                    'note' => $this->workplace_d_2_note,
                ],
                [
                    'criteria' => 'workplace_d_3',
                    'k3_value' => $this->workplace_d_3_value,
                    'note' => $this->workplace_d_3_note,
                ],
                [
                    'criteria' => 'workplace_d_4',
                    'k3_value' => $this->workplace_d_4_value,
                    'note' => $this->workplace_d_4_note,
                ],
                [
                    'criteria' => 'workplace_d_5',
                    'k3_value' => $this->workplace_d_5_value,
                    'note' => $this->workplace_d_5_note,
                ],
                [
                    'criteria' => 'workplace_d_6',
                    'k3_value' => $this->workplace_d_6_value,
                    'note' => $this->workplace_d_6_note,
                ],
                [
                    'criteria' => 'workplace_d_7',
                    'k3_value' => $this->workplace_d_7_value,
                    'note' => $this->workplace_d_7_note,
                ],
                [
                    'criteria' => 'workplace_d_8',
                    'k3_value' => $this->workplace_d_8_value,
                    'note' => $this->workplace_d_8_note,
                ],
                [
                    'criteria' => 'workplace_d_9',
                    'k3_value' => $this->workplace_d_9_value,
                    'note' => $this->workplace_d_9_note,
                ],
                [
                    'criteria' => 'workplace_e_1',
                    'k3_value' => $this->workplace_e_1_value,
                    'note' => $this->workplace_e_1_note,
                ],
                [
                    'criteria' => 'workplace_e_2',
                    'k3_value' => $this->workplace_e_2_value,
                    'note' => $this->workplace_e_2_note,
                ],
                [
                    'criteria' => 'workplace_e_3',
                    'k3_value' => $this->workplace_e_3_value,
                    'note' => $this->workplace_e_3_note,
                ],
                [
                    'criteria' => 'workplace_e_4',
                    'k3_value' => $this->workplace_e_4_value,
                    'note' => $this->workplace_e_4_note,
                ],
                [
                    'criteria' => 'workplace_e_5',
                    'k3_value' => $this->workplace_e_5_value,
                    'note' => $this->workplace_e_5_note,
                ],
                [
                    'criteria' => 'workplace_e_6',
                    'k3_value' => $this->workplace_e_6_value,
                    'note' => $this->workplace_e_6_note,
                ],
                [
                    'criteria' => 'workplace_f_1',
                    'k3_value' => $this->workplace_f_1_value,
                    'note' => $this->workplace_f_1_note,
                ],
                [
                    'criteria' => 'workplace_f_2',
                    'k3_value' => $this->workplace_f_2_value,
                    'note' => $this->workplace_f_2_note,
                ],
                [
                    'criteria' => 'workplace_f_3',
                    'k3_value' => $this->workplace_f_3_value,
                    'note' => $this->workplace_f_3_note,
                ],
                [
                    'criteria' => 'workplace_f_4',
                    'k3_value' => $this->workplace_f_4_value,
                    'note' => $this->workplace_f_4_note,
                ],
                [
                    'criteria' => 'workplace_f_5',
                    'k3_value' => $this->workplace_f_5_value,
                    'note' => $this->workplace_f_5_note,
                ],
                [
                    'criteria' => 'workplace_f_6',
                    'k3_value' => $this->workplace_f_6_value,
                    'note' => $this->workplace_f_6_note,
                ],
                [
                    'criteria' => 'workplace_f_7',
                    'k3_value' => $this->workplace_f_7_value,
                    'note' => $this->workplace_f_7_note,
                ],
                [
                    'criteria' => 'workplace_f_8',
                    'k3_value' => $this->workplace_f_8_value,
                    'note' => $this->workplace_f_8_note,
                ],
                [
                    'criteria' => 'workplace_f_9',
                    'k3_value' => $this->workplace_f_9_value,
                    'note' => $this->workplace_f_9_note,
                ],

                [
                    'criteria' => 'workplace_g_1',
                    'k3_value' => $this->workplace_g_1_value,
                    'note' => $this->workplace_g_1_note,
                ],
                [
                    'criteria' => 'workplace_g_2',
                    'k3_value' => $this->workplace_g_2_value,
                    'note' => $this->workplace_g_2_note,
                ],
                [
                    'criteria' => 'workplace_g_3',
                    'k3_value' => $this->workplace_g_3_value,
                    'note' => $this->workplace_g_3_note,
                ],
                [
                    'criteria' => 'workplace_g_4',
                    'k3_value' => $this->workplace_g_4_value,
                    'note' => $this->workplace_g_4_note,
                ],
                [
                    'criteria' => 'workplace_g_5',
                    'k3_value' => $this->workplace_g_5_value,
                    'note' => $this->workplace_g_5_note,
                ],
                [
                    'criteria' => 'workplace_g_6',
                    'k3_value' => $this->workplace_g_6_value,
                    'note' => $this->workplace_g_6_note,
                ],
                [
                    'criteria' => 'workplace_g_7',
                    'k3_value' => $this->workplace_g_7_value,
                    'note' => $this->workplace_g_7_note,
                ],
                [
                    'criteria' => 'workplace_g_8',
                    'k3_value' => $this->workplace_g_8_value,
                    'note' => $this->workplace_g_8_note,
                ],

                [
                    'criteria' => 'workplace_h_1',
                    'k3_value' => $this->workplace_h_1_value,
                    'note' => $this->workplace_h_1_note,
                ],
                [
                    'criteria' => 'workplace_h_2',
                    'k3_value' => $this->workplace_h_2_value,
                    'note' => $this->workplace_h_2_note,
                ],
                [
                    'criteria' => 'workplace_h_3',
                    'k3_value' => $this->workplace_h_3_value,
                    'note' => $this->workplace_h_3_note,
                ],
                [
                    'criteria' => 'workplace_h_4',
                    'k3_value' => $this->workplace_h_4_value,
                    'note' => $this->workplace_h_4_note,
                ],
                [
                    'criteria' => 'workplace_h_5',
                    'k3_value' => $this->workplace_h_5_value,
                    'note' => $this->workplace_h_5_note,
                ],
                [
                    'criteria' => 'workplace_h_6',
                    'k3_value' => $this->workplace_h_6_value,
                    'note' => $this->workplace_h_6_note,
                ],

                [
                    'criteria' => 'workplace_i_1',
                    'k3_value' => $this->workplace_i_1_value,
                    'note' => $this->workplace_i_1_note,
                ],
                [
                    'criteria' => 'workplace_i_2',
                    'k3_value' => $this->workplace_i_2_value,
                    'note' => $this->workplace_i_2_note,
                ],
                [
                    'criteria' => 'workplace_i_3',
                    'k3_value' => $this->workplace_i_3_value,
                    'note' => $this->workplace_i_3_note,
                ],
                [
                    'criteria' => 'workplace_i_4',
                    'k3_value' => $this->workplace_i_4_value,
                    'note' => $this->workplace_i_4_note,
                ],
                [
                    'criteria' => 'workplace_i_5',
                    'k3_value' => $this->workplace_i_5_value,
                    'note' => $this->workplace_i_5_note,
                ],
                [
                    'criteria' => 'workplace_i_6',
                    'k3_value' => $this->workplace_i_6_value,
                    'note' => $this->workplace_i_6_note,
                ],
                [
                    'criteria' => 'workplace_i_7',
                    'k3_value' => $this->workplace_i_7_value,
                    'note' => $this->workplace_i_7_note,
                ],
                [
                    'criteria' => 'workplace_i_8',
                    'k3_value' => $this->workplace_i_8_value,
                    'note' => $this->workplace_i_8_note,
                ],

                [
                    'criteria' => 'workplace_j_1',
                    'k3_value' => $this->workplace_j_1_value,
                    'note' => $this->workplace_j_1_note,
                ],
                [
                    'criteria' => 'workplace_j_2',
                    'k3_value' => $this->workplace_j_2_value,
                    'note' => $this->workplace_j_2_note,
                ],
                [
                    'criteria' => 'workplace_j_3',
                    'k3_value' => $this->workplace_j_3_value,
                    'note' => $this->workplace_j_3_note,
                ],
                [
                    'criteria' => 'workplace_j_4',
                    'k3_value' => $this->workplace_j_4_value,
                    'note' => $this->workplace_j_4_note,
                ],
                [
                    'criteria' => 'workplace_j_5',
                    'k3_value' => $this->workplace_j_5_value,
                    'note' => $this->workplace_j_5_note,
                ],
                [
                    'criteria' => 'workplace_j_6',
                    'k3_value' => $this->workplace_j_6_value,
                    'note' => $this->workplace_j_6_note,
                ],
                [
                    'criteria' => 'workplace_j_7',
                    'k3_value' => $this->workplace_j_7_value,
                    'note' => $this->workplace_j_7_note,
                ],
                [
                    'criteria' => 'workplace_j_8',
                    'k3_value' => $this->workplace_j_8_value,
                    'note' => $this->workplace_j_8_note,
                ],

                [
                    'criteria' => 'workplace_k_1',
                    'k3_value' => $this->workplace_k_1_value,
                    'note' => $this->workplace_k_1_note,
                ],
                [
                    'criteria' => 'workplace_k_2',
                    'k3_value' => $this->workplace_k_2_value,
                    'note' => $this->workplace_k_2_note,
                ],
                [
                    'criteria' => 'workplace_k_3',
                    'k3_value' => $this->workplace_k_3_value,
                    'note' => $this->workplace_k_3_note,
                ],
                [
                    'criteria' => 'workplace_k_4',
                    'k3_value' => $this->workplace_k_4_value,
                    'note' => $this->workplace_k_4_note,
                ],
                [
                    'criteria' => 'workplace_k_5',
                    'k3_value' => $this->workplace_k_5_value,
                    'note' => $this->workplace_k_5_note,
                ],
                [
                    'criteria' => 'workplace_k_6',
                    'k3_value' => $this->workplace_k_6_value,
                    'note' => $this->workplace_k_6_note,
                ],
                [
                    'criteria' => 'workplace_k_7',
                    'k3_value' => $this->workplace_k_7_value,
                    'note' => $this->workplace_k_7_note,
                ],
                [
                    'criteria' => 'workplace_k_8',
                    'k3_value' => $this->workplace_k_8_value,
                    'note' => $this->workplace_k_8_note,
                ],
                [
                    'criteria' => 'workplace_k_9',
                    'k3_value' => $this->workplace_k_9_value,
                    'note' => $this->workplace_k_9_note,
                ],
                [
                    'criteria' => 'workplace_k_10',
                    'k3_value' => $this->workplace_k_10_value,
                    'note' => $this->workplace_k_10_note,
                ],
                [
                    'criteria' => 'workplace_k_11',
                    'k3_value' => $this->workplace_k_11_value,
                    'note' => $this->workplace_k_11_note,
                ],
                [
                    'criteria' => 'workplace_k_12',
                    'k3_value' => $this->workplace_k_12_value,
                    'note' => $this->workplace_k_12_note,
                ],

                [
                    'criteria' => 'workplace_l_1',
                    'k3_value' => $this->workplace_l_1_value,
                    'note' => $this->workplace_l_1_note,
                ],
                [
                    'criteria' => 'workplace_l_2',
                    'k3_value' => $this->workplace_l_2_value,
                    'note' => $this->workplace_l_2_note,
                ],
                [
                    'criteria' => 'workplace_l_3',
                    'k3_value' => $this->workplace_l_3_value,
                    'note' => $this->workplace_l_3_note,
                ],
                [
                    'criteria' => 'workplace_l_4',
                    'k3_value' => $this->workplace_l_4_value,
                    'note' => $this->workplace_l_4_note,
                ],
                [
                    'criteria' => 'workplace_l_5',
                    'k3_value' => $this->workplace_l_5_value,
                    'note' => $this->workplace_l_5_note,
                ],
                [
                    'criteria' => 'workplace_l_6',
                    'k3_value' => $this->workplace_l_6_value,
                    'note' => $this->workplace_l_6_note,
                ],
                [
                    'criteria' => 'workplace_l_7',
                    'k3_value' => $this->workplace_l_7_value,
                    'note' => $this->workplace_l_7_note,
                ],
                [
                    'criteria' => 'workplace_l_8',
                    'k3_value' => $this->workplace_l_8_value,
                    'note' => $this->workplace_l_8_note,
                ],
                [
                    'criteria' => 'workplace_l_9',
                    'k3_value' => $this->workplace_l_9_value,
                    'note' => $this->workplace_l_9_note,
                ],
                [
                    'criteria' => 'workplace_l_10',
                    'k3_value' => $this->workplace_l_10_value,
                    'note' => $this->workplace_l_10_note,
                ],
                [
                    'criteria' => 'workplace_l_11',
                    'k3_value' => $this->workplace_l_11_value,
                    'note' => $this->workplace_l_11_note,
                ],
                [
                    'criteria' => 'workplace_l_12',
                    'k3_value' => $this->workplace_l_12_value,
                    'note' => $this->workplace_l_12_note,
                ],
                [
                    'criteria' => 'workplace_l_13',
                    'k3_value' => $this->workplace_l_13_value,
                    'note' => $this->workplace_l_13_note,
                ],

                [
                    'criteria' => 'workplace_m_1',
                    'k3_value' => $this->workplace_m_1_value,
                    'note' => $this->workplace_m_1_note,
                ],
                [
                    'criteria' => 'workplace_m_2',
                    'k3_value' => $this->workplace_m_2_value,
                    'note' => $this->workplace_m_2_note,
                ],
                [
                    'criteria' => 'workplace_m_3',
                    'k3_value' => $this->workplace_m_3_value,
                    'note' => $this->workplace_m_3_note,
                ],
                [
                    'criteria' => 'workplace_m_4',
                    'k3_value' => $this->workplace_m_4_value,
                    'note' => $this->workplace_m_4_note,
                ],

                [
                    'criteria' => 'workplace_n_1',
                    'k3_value' => $this->workplace_n_1_value,
                    'note' => $this->workplace_n_1_note,
                ],
                [
                    'criteria' => 'workplace_n_2',
                    'k3_value' => $this->workplace_n_2_value,
                    'note' => $this->workplace_n_2_note,
                ],
                [
                    'criteria' => 'workplace_n_3',
                    'k3_value' => $this->workplace_n_3_value,
                    'note' => $this->workplace_n_3_note,
                ],
                [
                    'criteria' => 'workplace_n_4',
                    'k3_value' => $this->workplace_n_4_value,
                    'note' => $this->workplace_n_4_note,
                ],
                [
                    'criteria' => 'workplace_n_5',
                    'k3_value' => $this->workplace_n_5_value,
                    'note' => $this->workplace_n_5_note,
                ],
                [
                    'criteria' => 'workplace_n_6',
                    'k3_value' => $this->workplace_n_6_value,
                    'note' => $this->workplace_n_6_note,
                ],
                [
                    'criteria' => 'workplace_n_7',
                    'k3_value' => $this->workplace_n_7_value,
                    'note' => $this->workplace_n_7_note,
                ],
                [
                    'criteria' => 'workplace_n_8',
                    'k3_value' => $this->workplace_n_8_value,
                    'note' => $this->workplace_n_8_note,
                ],
                [
                    'criteria' => 'workplace_n_9',
                    'k3_value' => $this->workplace_n_9_value,
                    'note' => $this->workplace_n_9_note,
                ],
                [
                    'criteria' => 'workplace_n_10',
                    'k3_value' => $this->workplace_n_10_value,
                    'note' => $this->workplace_n_10_note,
                ],
                [
                    'criteria' => 'workplace_n_11',
                    'k3_value' => $this->workplace_n_11_value,
                    'note' => $this->workplace_n_11_note,
                ],
                [
                    'criteria' => 'workplace_n_12',
                    'k3_value' => $this->workplace_n_12_value,
                    'note' => $this->workplace_n_12_note,
                ],
                [
                    'criteria' => 'workplace_n_13',
                    'k3_value' => $this->workplace_n_13_value,
                    'note' => $this->workplace_n_13_note,
                ],
                [
                    'criteria' => 'workplace_n_14',
                    'k3_value' => $this->workplace_n_14_value,
                    'note' => $this->workplace_n_14_note,
                ],
                [
                    'criteria' => 'workplace_n_15',
                    'k3_value' => $this->workplace_n_15_value,
                    'note' => $this->workplace_n_15_note,
                ],
                [
                    'criteria' => 'workplace_n_16',
                    'k3_value' => $this->workplace_n_16_value,
                    'note' => $this->workplace_n_16_note,
                ],

                [
                    'criteria' => 'workplace_o_1',
                    'k3_value' => $this->workplace_o_1_value,
                    'note' => $this->workplace_o_1_note,
                ],
                [
                    'criteria' => 'workplace_o_2',
                    'k3_value' => $this->workplace_o_2_value,
                    'note' => $this->workplace_o_2_note,
                ],
                [
                    'criteria' => 'workplace_o_3',
                    'k3_value' => $this->workplace_o_3_value,
                    'note' => $this->workplace_o_3_note,
                ],
                [
                    'criteria' => 'workplace_o_4',
                    'k3_value' => $this->workplace_o_4_value,
                    'note' => $this->workplace_o_4_note,
                ],
                [
                    'criteria' => 'workplace_o_5',
                    'k3_value' => $this->workplace_o_5_value,
                    'note' => $this->workplace_o_5_note,
                ],
                [
                    'criteria' => 'workplace_o_6',
                    'k3_value' => $this->workplace_o_6_value,
                    'note' => $this->workplace_o_6_note,
                ],

                [
                    'criteria' => 'workplace_p_1',
                    'k3_value' => $this->workplace_p_1_value,
                    'note' => $this->workplace_p_1_note,
                ],
                [
                    'criteria' => 'workplace_p_2',
                    'k3_value' => $this->workplace_p_2_value,
                    'note' => $this->workplace_p_2_note,
                ],
                [
                    'criteria' => 'workplace_p_3',
                    'k3_value' => $this->workplace_p_3_value,
                    'note' => $this->workplace_p_3_note,
                ],
                [
                    'criteria' => 'workplace_p_4',
                    'k3_value' => $this->workplace_p_4_value,
                    'note' => $this->workplace_p_4_note,
                ],
                [
                    'criteria' => 'workplace_p_5',
                    'k3_value' => $this->workplace_p_5_value,
                    'note' => $this->workplace_p_5_note,
                ],
                [
                    'criteria' => 'workplace_p_6',
                    'k3_value' => $this->workplace_p_6_value,
                    'note' => $this->workplace_p_6_note,
                ],
                [
                    'criteria' => 'workplace_p_7',
                    'k3_value' => $this->workplace_p_7_value,
                    'note' => $this->workplace_p_7_note,
                ],
                [
                    'criteria' => 'workplace_p_8',
                    'k3_value' => $this->workplace_p_8_value,
                    'note' => $this->workplace_p_8_note,
                ],

                [
                    'criteria' => 'workplace_q_1',
                    'k3_value' => $this->workplace_q_1_value,
                    'note' => $this->workplace_q_1_note,
                ],
                [
                    'criteria' => 'workplace_q_2',
                    'k3_value' => $this->workplace_q_2_value,
                    'note' => $this->workplace_q_2_note,
                ],
                [
                    'criteria' => 'workplace_q_3',
                    'k3_value' => $this->workplace_q_3_value,
                    'note' => $this->workplace_q_3_note,
                ],
                [
                    'criteria' => 'workplace_q_4',
                    'k3_value' => $this->workplace_q_4_value,
                    'note' => $this->workplace_q_4_note,
                ],
                [
                    'criteria' => 'workplace_q_5',
                    'k3_value' => $this->workplace_q_5_value,
                    'note' => $this->workplace_q_5_note,
                ],
                [
                    'criteria' => 'workplace_q_6',
                    'k3_value' => $this->workplace_q_6_value,
                    'note' => $this->workplace_q_6_note,
                ],
                [
                    'criteria' => 'workplace_q_7',
                    'k3_value' => $this->workplace_q_7_value,
                    'note' => $this->workplace_q_7_note,
                ],
                [
                    'criteria' => 'workplace_q_8',
                    'k3_value' => $this->workplace_q_8_value,
                    'note' => $this->workplace_q_8_note,
                ],
                [
                    'criteria' => 'workplace_q_9',
                    'k3_value' => $this->workplace_q_9_value,
                    'note' => $this->workplace_q_9_note,
                ],
                [
                    'criteria' => 'workplace_q_10',
                    'k3_value' => $this->workplace_q_10_value,
                    'note' => $this->workplace_q_10_note,
                ],

                [
                    'criteria' => 'workplace_r_1',
                    'k3_value' => $this->workplace_r_1_value,
                    'note' => $this->workplace_r_1_note,
                ],
                [
                    'criteria' => 'workplace_r_2',
                    'k3_value' => $this->workplace_r_2_value,
                    'note' => $this->workplace_r_2_note,
                ],
                [
                    'criteria' => 'workplace_r_3',
                    'k3_value' => $this->workplace_r_3_value,
                    'note' => $this->workplace_r_3_note,
                ],
                [
                    'criteria' => 'workplace_r_4',
                    'k3_value' => $this->workplace_r_4_value,
                    'note' => $this->workplace_r_4_note,
                ],
                [
                    'criteria' => 'workplace_r_5',
                    'k3_value' => $this->workplace_r_5_value,
                    'note' => $this->workplace_r_5_note,
                ],

                [
                    'criteria' => 'workplace_s_1',
                    'k3_value' => $this->workplace_s_1_value,
                    'note' => $this->workplace_s_1_note,
                ],
                [
                    'criteria' => 'workplace_s_2',
                    'k3_value' => $this->workplace_s_2_value,
                    'note' => $this->workplace_s_2_note,
                ],
                [
                    'criteria' => 'workplace_s_3',
                    'k3_value' => $this->workplace_s_3_value,
                    'note' => $this->workplace_s_3_note,
                ],
                [
                    'criteria' => 'workplace_s_4',
                    'k3_value' => $this->workplace_s_4_value,
                    'note' => $this->workplace_s_4_note,
                ],
                [
                    'criteria' => 'workplace_s_5',
                    'k3_value' => $this->workplace_s_5_value,
                    'note' => $this->workplace_s_5_note,
                ],
                [
                    'criteria' => 'workplace_s_6',
                    'k3_value' => $this->workplace_s_6_value,
                    'note' => $this->workplace_s_6_note,
                ],
                [
                    'criteria' => 'workplace_s_7',
                    'k3_value' => $this->workplace_s_7_value,
                    'note' => $this->workplace_s_7_note,
                ],
                [
                    'criteria' => 'workplace_s_8',
                    'k3_value' => $this->workplace_s_8_value,
                    'note' => $this->workplace_s_8_note,
                ],
                [
                    'criteria' => 'workplace_s_9',
                    'k3_value' => $this->workplace_s_9_value,
                    'note' => $this->workplace_s_9_note,
                ],

            ];

            foreach ($InspectionDatas as $InspectionData) {
                if (isset($InspectionData['k3_value'])) {

                    $InspectionData['label_id'] = $label_store->id;

                    if ($this->{$InspectionData['criteria'] . '_file'} && !is_string($this->{$InspectionData['criteria'] . '_file'})) {
                        $filetype = pathinfo($this->{$InspectionData['criteria'] . '_file'}->path(), PATHINFO_EXTENSION);
                        $file_name = "" . $label_store->id . "-" . $InspectionData['criteria'] . "_file.$filetype";
                        $this->{$InspectionData['criteria'] . '_file'}->storeAs('kplh/workplace', $file_name, ['disk' => 'local']);
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
                        //     'type' => 'workplace',
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
                // dd($label_store->maker->name);
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
            redirect()->route('kplh::list-workplace');

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
        return view('kplh::livewire.weekly-workplace.add')->extends('kplh::layouts.no-header');

    }
}
