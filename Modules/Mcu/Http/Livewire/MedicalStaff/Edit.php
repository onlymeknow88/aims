<?php

namespace Modules\Mcu\Http\Livewire\MedicalStaff;

use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Mcu\Entities\FormulaBloodPressure;
use Modules\Mcu\Entities\FormulaDislipidemia;
use Modules\Mcu\Entities\MedicalHistory;
use Modules\Mcu\Entities\Provider;

class Edit extends Component
{
    use WithFileUploads;
    public $formEmployee;
    public $attachments = [], $file, $file_status, $tmp = [], $mode, $mcu_id, $medical_ex_type, $provider, $department, $employeeDepartment, $employeePosition, $employeeNip, $employeeIdNumber, $employeeName, $employeeEmail, $employeeBirthdate, $employeeAge, $employeeGender, $employeeAddress, $status, $mcu_details;

    public $user_id, $employeeId, $doctor_id;
    public $formula_blood_pressure_id, $formula_dislipidemia_id, $provider_id, $medical_type = 'pre-employment', $mcu_date, $mcu_exp_date, $mcu_review_date;
    public $complaint, $previous_disease_history, $family_disease_history = [], $alergy, $smoking, $smoking_per_day, $sports, $sports_per_week, $sports_type, $alcohol;
    public $menstrual_menarche, $menstrual_cycle, $menstrual_pain, $menstrual_period, $pregnant_period, $pregnant_spontan, $pregnant_surgery, $pregnant_abortion, $contraception, $contraception_type;
    public $previous_job, $current_job, $current_job_details;
    public $vaccination_hep_a1, $vaccination_hep_a2, $vaccination_hep_a3, $vaccination_typhoid_1, $vaccination_typhoid_3, $vaccination_albendandazole;
    public $height, $weight, $bmi, $nutritional_status, $bmi_lower, $bmi_upper, $systolic_blood_pressure, $diastolic_blood_pressure, $arteries, $rr, $body_temperature, $blood_pressure_status, $heent, $orodental_caries, $orodental_gangren_radix, $cardiovascular_system, $respiratorus_system, $digestivus_system, $genitounrinarius_system, $neuromuscular_system, $fitness_test;
    public $visus_non_correction_od, $visus_non_correction_os, $visus_non_correction_ods, $visus_correction_od, $visus_correction_os, $visus_correction_ods, $visus_impression, $visus_reading_test, $visus_color_blind, $visus_field_of_view, $visus_notes;
    public $audiometry_right_air_conduction_500, $audiometry_right_air_conduction_1000, $audiometry_right_air_conduction_2000, $audiometry_right_air_conduction_3000, $audiometry_right_air_conduction_4000, $audiometry_right_air_conduction_6000, $audiometry_right_air_conduction_8000, $audiometry_right_air_conduction_htl, $audiometry_right_bone_conduction_500, $audiometry_right_bone_conduction_1000, $audiometry_right_bone_conduction_2000, $audiometry_right_bone_conduction_3000, $audiometry_right_bone_conduction_4000, $audiometry_right_bone_conduction_6000, $audiometry_right_bone_conduction_8000, $audiometry_right_bone_conduction_htl, $audiometry_left_air_conduction_500, $audiometry_left_air_conduction_1000, $audiometry_left_air_conduction_2000, $audiometry_left_air_conduction_3000, $audiometry_left_air_conduction_4000, $audiometry_left_air_conduction_6000, $audiometry_left_air_conduction_8000, $audiometry_left_air_conduction_htl, $audiometry_left_bone_conduction_500, $audiometry_left_bone_conduction_1000, $audiometry_left_bone_conduction_2000, $audiometry_left_bone_conduction_3000, $audiometry_left_bone_conduction_4000, $audiometry_left_bone_conduction_6000, $audiometry_left_bone_conduction_8000, $audiometry_left_bone_conduction_htl;
    public $audiometry_conclusion, $audiometry_impression;
    public $spirometry_fvc, $spirometry_fev1, $spirometry_impression;
    public $xray_thorax = [], $xray_thorax_note, $ekg = [], $ekg_note, $treadmill, $echocardiography, $additional_diagnosis;
    public $blood_hb, $blood_ht, $blood_leukosit, $blood_thrombosit, $blood_eritrosit, $blood_led, $blood_type, $blood_rhesus, $blood_sgot, $blood_sgpt, $blood_gamma_gt, $blood_cholesterol_total = 0, $blood_hdl, $blood_ldl = 0, $blood_tga = 0, $blood_billirubin_total, $blood_billirubin_direk, $blood_billirubin_indirek, $blood_dislipidemia, $blood_gdpt = 0, $blood_g2pp = 0, $blood_hyperglycemic, $blood_hba1c, $blood_dm_status;
    public $jakarta_cardiovascular_score, $jakarta_cardiovascular_risk_level, $framingham_score, $frammingham_risk_level;
    public $laboratory_ureum, $laboratory_bun, $laboratory_creatinin, $laboratory_uric_acid, $laboratory_uric_egfr, $laboratory_hbsag, $laboratory_anti_hbs, $laboratory_anti_havlgm, $laboratory_widal, $laboratory_malary, $laboratory_urinalysis_color, $laboratory_urinalysis_clarity, $laboratory_urinalysis_ph, $laboratory_urinalysis_density, $laboratory_urinalysis_protein, $laboratory_urinalysis_glucose, $laboratory_urinalysis_billirubin, $laboratory_urinalysis_urobillin, $laboratory_urinalysis_keton, $laboratory_urinalysis_blood, $laboratory_urinalysis_lekositesterase, $laboratory_urinalysis_nitrit, $laboratory_urinalysis_leukocyte_sediment, $laboratory_urinalysis_erythrocyte, $laboratory_urinalysis_epitel, $laboratory_urinalysis_cylinder, $laboratory_urinalysis_crystal, $laboratory_urinalysis_bacteria, $laboratory_urinalysis_etc, $laboratory_urinalysis_amp, $laboratory_urinalysis_met, $laboratory_urinalysis_bdz, $laboratory_urinalysis_coc, $laboratory_urinalysis_opi, $laboratory_urinalysis_thc, $laboratory_urinalysis_feces_analysis, $laboratory_urinalysis_feces_culture, $cholinesterase;

    public $findings = [];
    public $doctor_status_review, $doctor_suggestion, $doctor_certificate_number, $doctor_expiration, $doctor_remark;

    protected $messages = [
        'medical_ex_type.required' => 'Harus pilih salah satu Item Pemeriksaan Kesehatan',
        'medical_type.required' => 'Medical Type tidak boleh kosong',
        'employeeIdNumber.required' => 'NIK tidak boleh kosong',
        'employeeEmail.required' => 'Email Karyawan tidak boleh kosong',
        'employeeName.required' => 'Nama Karyawan tidak boleh kosong',
        'employeeDepartment.required' => 'Departemen tidak boleh kosong',
        'employeeBirthdate.required' => 'Tanggal Lahir tidak boleh kosong',
        'employeeGender.required' => 'Jenis Kelamin tidak boleh kosong',
    ];

    public function mount($id)
    {
        $this->user_id = auth()->user()->id;
        $this->provider = Provider::get();
        $this->department = Department::get();

        // Dari default active setting formula
        $FormulaBloodPressure = FormulaBloodPressure::where('status', 'active')->first();
        $this->formula_blood_pressure_id = $FormulaBloodPressure->id;

        $FormulaDislipidemia = FormulaDislipidemia::where('status', 'active')->first();
        $this->formula_dislipidemia_id = $FormulaDislipidemia->id;

        $this->mcu_id = $id;
        $this->mcu_data = MedicalHistory::with('employee')->find($this->mcu_id);

        $carbonNow = Carbon::now();

        if (($this->mcu_data->doctor_status_review != 'draft') && ($carbonNow->diffInMinutes(Carbon::parse($this->mcu_data->updated_at)) > 60)) {
            redirect()->route('mcu::medical-staff-list');
        }

        $this->employeeId = $this->mcu_data->employee_id;
        $this->employeeIdNumber = $this->mcu_data->employee->id_number;
        $this->employeeEmail = $this->mcu_data->employee->user->email;
        $this->employeeName = $this->mcu_data->employee->name;
        $this->employeeDepartment = $this->mcu_data->employee->department_id;
        $this->employeePosition = $this->mcu_data->employee->position;
        $this->employeeNip = $this->mcu_data->employee->number;
        $this->employeeBirthdate = Carbon::parse($this->mcu_data->employee->date_of_birth)->format('F d, Y');
        $this->employeeAge = Carbon::parse($this->mcu_data->employee->date_of_birth)->age;
        $this->employeeGender = $this->mcu_data->employee->gender;
        $this->employeeAddress = $this->mcu_data->address;
        $this->formEmployee = 'disabled';

        $this->formula_blood_pressure_id = $this->mcu_data->formula_blood_pressure_id;
        $this->formula_dislipidemia_id = $this->mcu_data->formula_dislipidemia_id;
        $this->provider_id = $this->mcu_data->provider_id;

        $this->medical_type = $this->mcu_data->medical_type;
        $this->medical_ex_type = $this->mcu_data->medical_ex_type;
        $this->mcu_date = ($this->mcu_data->mcu_date) ? Carbon::parse($this->mcu_data->mcu_date)->format('F d, Y') : null;

        $this->file_exist = "" . $this->mcu_data->employee_id . "-" . slugify($this->mcu_data->mcu_date) . ".pdf";

        if (Storage::disk('public')->exists('mcu/attachment/' . $this->file_exist . '')) {
            $this->file_status = true;
        } else {
            $this->file_status = false;
        }

        $this->complaint = $this->mcu_data->complaint;
        $this->previous_disease_history = $this->mcu_data->previous_disease_history;
        $this->family_disease_history = $this->mcu_data->family_disease_history;
        $this->alergy = $this->mcu_data->alergy;
        $this->smoking = $this->mcu_data->smoking;
        $this->smoking_per_day = $this->mcu_data->smoking_per_day;
        $this->sports = $this->mcu_data->sports;
        $this->sports_per_week = $this->mcu_data->sports_per_week;
        $this->sports_type = $this->mcu_data->sports_type;
        $this->alcohol = $this->mcu_data->alcohol;

        $this->menstrual_menarche = $this->mcu_data->menstrual_menarche;
        $this->menstrual_cycle = $this->mcu_data->menstrual_cycle;
        $this->menstrual_pain = $this->mcu_data->menstrual_pain;
        $this->menstrual_period = $this->mcu_data->menstrual_period;
        $this->pregnant_period = $this->mcu_data->pregnant_period;
        $this->pregnant_spontan = $this->mcu_data->pregnant_spontan;
        $this->pregnant_surgery = $this->mcu_data->pregnant_surgery;
        $this->pregnant_abortion = $this->mcu_data->pregnant_abortion;
        $this->contraception = $this->mcu_data->contraception;
        $this->contraception_type = $this->mcu_data->contraception_type;

        $this->current_job = $this->mcu_data->current_job;
        $this->previous_job = $this->mcu_data->previous_job;
        $this->current_job_details = $this->mcu_data->current_job_details;

        $this->vaccination_hep_a1 = $this->mcu_data->vaccination_hep_a1;
        // $this->vaccination_hep_a1 = ($this->mcu_data->vaccination_hep_a1) ? Carbon::parse($this->mcu_data->vaccination_hep_a1)->format('F d, Y') : null;
        $this->vaccination_hep_a2 = $this->mcu_data->vaccination_hep_a2;
        // $this->vaccination_hep_a2 = ($this->mcu_data->vaccination_hep_a2) ? Carbon::parse($this->mcu_data->vaccination_hep_a2)->format('F d, Y') : null;
        $this->vaccination_hep_a3 = $this->mcu_data->vaccination_hep_a3;
        // $this->vaccination_hep_a3 = ($this->mcu_data->vaccination_hep_a3) ? Carbon::parse($this->mcu_data->vaccination_hep_a3)->format('F d, Y') : null;
        $this->vaccination_typhoid_1 = $this->mcu_data->vaccination_typhoid_1;
        // $this->vaccination_typhoid_1 = ($this->mcu_data->vaccination_typhoid_1) ? Carbon::parse($this->mcu_data->vaccination_typhoid_1)->format('F d, Y') : null;
        $this->vaccination_typhoid_3 = $this->mcu_data->vaccination_typhoid_3;
        // $this->vaccination_typhoid_3 = ($this->mcu_data->vaccination_typhoid_3) ? Carbon::parse($this->mcu_data->vaccination_typhoid_3)->format('F d, Y') : null;
        $this->vaccination_albendandazole = $this->mcu_data->vaccination_albendandazole;
        // $this->vaccination_albendandazole = ($this->mcu_data->vaccination_albendandazole) ? Carbon::parse($this->mcu_data->vaccination_albendandazole)->format('F d, Y') : null;

        $this->height = $this->mcu_data->height;
        $this->weight = $this->mcu_data->weight;
        $this->bmi = $this->mcu_data->bmi;
        $this->nutritional_status = $this->mcu_data->nutritional_status;
        $this->bmi_lower = $this->mcu_data->bmi_lower;
        $this->bmi_upper = $this->mcu_data->bmi_upper;
        $this->systolic_blood_pressure = $this->mcu_data->systolic_blood_pressure;
        $this->diastolic_blood_pressure = $this->mcu_data->diastolic_blood_pressure;
        $this->arteries = $this->mcu_data->arteries;
        $this->rr = $this->mcu_data->rr;
        $this->body_temperature = $this->mcu_data->body_temperature;
        $this->blood_pressure_status = $this->mcu_data->blood_pressure_status;
        $this->heent = $this->mcu_data->heent;
        $this->orodental_caries = $this->mcu_data->orodental_caries;
        $this->orodental_gangren_radix = $this->mcu_data->orodental_gangren_radix;
        $this->cardiovascular_system = $this->mcu_data->cardiovascular_system;
        $this->respiratorus_system = $this->mcu_data->respiratorus_system;
        $this->digestivus_system = $this->mcu_data->digestivus_system;
        $this->genitounrinarius_system = $this->mcu_data->genitounrinarius_system;
        $this->neuromuscular_system = $this->mcu_data->neuromuscular_system;
        $this->fitness_test = $this->mcu_data->fitness_test;

        $this->visus_non_correction_od = $this->mcu_data->visus_non_correction_od;
        $this->visus_non_correction_os = $this->mcu_data->visus_non_correction_os;
        $this->visus_non_correction_ods = $this->mcu_data->visus_non_correction_ods;
        $this->visus_correction_od = $this->mcu_data->visus_correction_od;
        $this->visus_correction_os = $this->mcu_data->visus_correction_os;
        $this->visus_correction_ods = $this->mcu_data->visus_correction_ods;
        $this->visus_impression = $this->mcu_data->visus_impression;
        $this->visus_reading_test = $this->mcu_data->visus_reading_test;
        $this->visus_color_blind = $this->mcu_data->visus_color_blind;
        $this->visus_field_of_view = $this->mcu_data->visus_field_of_view;
        $this->visus_notes = $this->mcu_data->visus_notes;

        $this->audiometry_right_air_conduction_500 = $this->mcu_data->audiometry_right_air_conduction_500;
        $this->audiometry_right_air_conduction_1000 = $this->mcu_data->audiometry_right_air_conduction_1000;
        $this->audiometry_right_air_conduction_2000 = $this->mcu_data->audiometry_right_air_conduction_2000;
        $this->audiometry_right_air_conduction_3000 = $this->mcu_data->audiometry_right_air_conduction_3000;
        $this->audiometry_right_air_conduction_4000 = $this->mcu_data->audiometry_right_air_conduction_4000;
        $this->audiometry_right_air_conduction_6000 = $this->mcu_data->audiometry_right_air_conduction_6000;
        $this->audiometry_right_air_conduction_8000 = $this->mcu_data->audiometry_right_air_conduction_8000;
        $this->audiometry_right_air_conduction_htl = $this->mcu_data->audiometry_right_air_conduction_htl;
        $this->audiometry_right_bone_conduction_500 = $this->mcu_data->audiometry_right_bone_conduction_500;
        $this->audiometry_right_bone_conduction_1000 = $this->mcu_data->audiometry_right_bone_conduction_1000;
        $this->audiometry_right_bone_conduction_2000 = $this->mcu_data->audiometry_right_bone_conduction_2000;
        $this->audiometry_right_bone_conduction_3000 = $this->mcu_data->audiometry_right_bone_conduction_3000;
        $this->audiometry_right_bone_conduction_4000 = $this->mcu_data->audiometry_right_bone_conduction_4000;
        $this->audiometry_right_bone_conduction_6000 = $this->mcu_data->audiometry_right_bone_conduction_6000;
        $this->audiometry_right_bone_conduction_8000 = $this->mcu_data->audiometry_right_bone_conduction_8000;
        $this->audiometry_right_bone_conduction_htl = $this->mcu_data->audiometry_right_bone_conduction_htl;

        $this->audiometry_left_air_conduction_500 = $this->mcu_data->audiometry_left_air_conduction_500;
        $this->audiometry_left_air_conduction_1000 = $this->mcu_data->audiometry_left_air_conduction_1000;
        $this->audiometry_left_air_conduction_2000 = $this->mcu_data->audiometry_left_air_conduction_2000;
        $this->audiometry_left_air_conduction_3000 = $this->mcu_data->audiometry_left_air_conduction_3000;
        $this->audiometry_left_air_conduction_4000 = $this->mcu_data->audiometry_left_air_conduction_4000;
        $this->audiometry_left_air_conduction_6000 = $this->mcu_data->audiometry_left_air_conduction_6000;
        $this->audiometry_left_air_conduction_8000 = $this->mcu_data->audiometry_left_air_conduction_8000;
        $this->audiometry_left_air_conduction_htl = $this->mcu_data->audiometry_left_air_conduction_htl;
        $this->audiometry_left_bone_conduction_500 = $this->mcu_data->audiometry_left_bone_conduction_500;
        $this->audiometry_left_bone_conduction_1000 = $this->mcu_data->audiometry_left_bone_conduction_1000;
        $this->audiometry_left_bone_conduction_2000 = $this->mcu_data->audiometry_left_bone_conduction_2000;
        $this->audiometry_left_bone_conduction_3000 = $this->mcu_data->audiometry_left_bone_conduction_3000;
        $this->audiometry_left_bone_conduction_4000 = $this->mcu_data->audiometry_left_bone_conduction_4000;
        $this->audiometry_left_bone_conduction_6000 = $this->mcu_data->audiometry_left_bone_conduction_6000;
        $this->audiometry_left_bone_conduction_8000 = $this->mcu_data->audiometry_left_bone_conduction_8000;
        $this->audiometry_left_bone_conduction_htl = $this->mcu_data->audiometry_left_bone_conduction_htl;

        $this->audiometry_conclusion = $this->mcu_data->audiometry_conclusion;
        $this->audiometry_impression = $this->mcu_data->audiometry_impression;

        $this->spirometry_fvc = $this->mcu_data->spirometry_fvc;
        $this->spirometry_fev1 = $this->mcu_data->spirometry_fev1;
        $this->spirometry_impression = $this->mcu_data->spirometry_impression;

        $this->xray_thorax = $this->mcu_data->xray_thorax;
        $this->xray_thorax_note = $this->mcu_data->xray_thorax_note;
        $this->ekg = $this->mcu_data->ekg;
        $this->ekg_note = $this->mcu_data->ekg_note;
        $this->treadmill = $this->mcu_data->treadmill;
        $this->echocardiography = $this->mcu_data->echocardiography;
        $this->additional_diagnosis = $this->mcu_data->additional_diagnosis;

        $this->blood_hb = $this->mcu_data->blood_hb;
        $this->blood_ht = $this->mcu_data->blood_ht;
        $this->blood_leukosit = $this->mcu_data->blood_leukosit;
        $this->blood_thrombosit = $this->mcu_data->blood_thrombosit;
        $this->blood_eritrosit = $this->mcu_data->blood_eritrosit;
        $this->blood_led = $this->mcu_data->blood_led;
        $this->blood_type = $this->mcu_data->blood_type;
        $this->blood_rhesus = $this->mcu_data->blood_rhesus;
        $this->blood_sgot = $this->mcu_data->blood_sgot;
        $this->blood_sgpt = $this->mcu_data->blood_sgpt;
        $this->blood_gamma_gt = $this->mcu_data->blood_gamma_gt;
        $this->blood_cholesterol_total = $this->mcu_data->blood_cholesterol_total;
        $this->blood_hdl = $this->mcu_data->blood_hdl;
        $this->blood_ldl = $this->mcu_data->blood_ldl;
        $this->blood_tga = $this->mcu_data->blood_tga;
        $this->blood_billirubin_total = $this->mcu_data->blood_billirubin_total;
        $this->blood_billirubin_direk = $this->mcu_data->blood_billirubin_direk;
        $this->blood_billirubin_indirek = $this->mcu_data->blood_billirubin_indirek;
        $this->blood_dislipidemia = $this->mcu_data->blood_dislipidemia;
        $this->blood_gdpt = $this->mcu_data->blood_gdpt;
        $this->blood_g2pp = $this->mcu_data->blood_g2pp;
        $this->blood_hyperglycemic = $this->mcu_data->blood_hyperglycemic;
        $this->blood_hba1c = $this->mcu_data->blood_hba1c;
        $this->blood_dm_status = $this->mcu_data->blood_dm_status;

        $this->jakarta_cardiovascular_score = $this->mcu_data->jakarta_cardiovascular_score;
        $this->jakarta_cardiovascular_risk_level = $this->mcu_data->jakarta_cardiovascular_risk_level;
        $this->framingham_score = $this->mcu_data->framingham_score;
        $this->frammingham_risk_level = $this->mcu_data->frammingham_risk_level;

        $this->laboratory_ureum = $this->mcu_data->laboratory_ureum;
        $this->laboratory_bun = $this->mcu_data->laboratory_bun;
        $this->laboratory_creatinin = $this->mcu_data->laboratory_creatinin;
        $this->laboratory_uric_acid = $this->mcu_data->laboratory_uric_acid;
        $this->laboratory_uric_egfr = $this->mcu_data->laboratory_uric_egfr;
        $this->laboratory_hbsag = $this->mcu_data->laboratory_hbsag;
        $this->laboratory_anti_hbs = $this->mcu_data->laboratory_anti_hbs;
        $this->laboratory_anti_havlgm = $this->mcu_data->laboratory_anti_havlgm;
        $this->laboratory_widal = $this->mcu_data->laboratory_widal;
        $this->laboratory_malary = $this->mcu_data->laboratory_malary;
        $this->laboratory_urinalysis_color = $this->mcu_data->laboratory_urinalysis_color;
        $this->laboratory_urinalysis_clarity = $this->mcu_data->laboratory_urinalysis_clarity;
        $this->laboratory_urinalysis_ph = $this->mcu_data->laboratory_urinalysis_ph;
        $this->laboratory_urinalysis_density = $this->mcu_data->laboratory_urinalysis_density;
        $this->laboratory_urinalysis_protein = $this->mcu_data->laboratory_urinalysis_protein;
        $this->laboratory_urinalysis_glucose = $this->mcu_data->laboratory_urinalysis_glucose;
        $this->laboratory_urinalysis_billirubin = $this->mcu_data->laboratory_urinalysis_billirubin;
        $this->laboratory_urinalysis_urobillin = $this->mcu_data->laboratory_urinalysis_urobillin;
        $this->laboratory_urinalysis_keton = $this->mcu_data->laboratory_urinalysis_keton;
        $this->laboratory_urinalysis_blood = $this->mcu_data->laboratory_urinalysis_blood;
        $this->laboratory_urinalysis_lekositesterase = $this->mcu_data->laboratory_urinalysis_lekositesterase;
        $this->laboratory_urinalysis_nitrit = $this->mcu_data->laboratory_urinalysis_nitrit;
        $this->laboratory_urinalysis_leukocyte_sediment = $this->mcu_data->laboratory_urinalysis_leukocyte_sediment;
        $this->laboratory_urinalysis_erythrocyte = $this->mcu_data->laboratory_urinalysis_erythrocyte;
        $this->laboratory_urinalysis_epitel = $this->mcu_data->laboratory_urinalysis_epitel;
        $this->laboratory_urinalysis_cylinder = $this->mcu_data->laboratory_urinalysis_cylinder;
        $this->laboratory_urinalysis_crystal = $this->mcu_data->laboratory_urinalysis_crystal;
        $this->laboratory_urinalysis_bacteria = $this->mcu_data->laboratory_urinalysis_bacteria;
        $this->laboratory_urinalysis_etc = $this->mcu_data->laboratory_urinalysis_etc;

        $this->laboratory_urinalysis_amp = $this->mcu_data->laboratory_urinalysis_amp;
        $this->laboratory_urinalysis_met = $this->mcu_data->laboratory_urinalysis_met;
        $this->laboratory_urinalysis_bdz = $this->mcu_data->laboratory_urinalysis_bdz;
        $this->laboratory_urinalysis_coc = $this->mcu_data->laboratory_urinalysis_coc;
        $this->laboratory_urinalysis_opi = $this->mcu_data->laboratory_urinalysis_opi;
        $this->laboratory_urinalysis_thc = $this->mcu_data->laboratory_urinalysis_thc;
        $this->laboratory_urinalysis_feces_analysis = $this->mcu_data->laboratory_urinalysis_feces_analysis;
        $this->laboratory_urinalysis_feces_culture = $this->mcu_data->laboratory_urinalysis_feces_culture;
        $this->cholinesterase = $this->mcu_data->cholinesterase;
    }

    public function checkIdNumber()
    {
    }

    public function updatedEmployeeBirthdate()
    {
        $this->employeeAge = Carbon::parse($this->employeeBirthdate)->age;
    }

    public function updatedFIle()
    {
        $filetype = pathinfo($this->file->path(), PATHINFO_EXTENSION);

        if ($filetype != 'pdf') {
            $this->addError('file', 'Format file wajib PDF');
            $this->file = null;
        }
    }

    public function BloodPressure()
    {
        if ($this->systolic_blood_pressure >= 160 && $this->diastolic_blood_pressure >= 100) {
            $this->findings['systolic_blood_pressure'] = 'Tekanan Darah Sistolik: ' . $this->systolic_blood_pressure . ' mmHg';
            $this->findings['diastolic_blood_pressure'] = 'Tekanan Darah Diastolik : ' . $this->diastolic_blood_pressure . ' mmHg';
        }
    }

    public function IdealFormula()
    {
        if (!$this->employeeAge) {
            $employee = Employee::find($this->employeeId);
            $this->employeeAge = $employee->age;
        }

        if (!$this->employeeGender) {
            $employee = Employee::find($this->employeeId);
            $this->employeeGender = $employee->gender;
        }

        $this->bmi = imt_ideal($this->height, $this->weight);
        // Temuan
        if ($this->bmi >= 35) {
            $this->findings['bmi'] = 'Index massa tubuh : ' . $this->bmi . ' kg/m2';
            $status = 'Curently Unfit';
        }
        $this->bmi_lower = imt_ideal_limit($this->employeeGender, $this->height, 'low');
        $this->bmi_upper = imt_ideal_limit($this->employeeGender, $this->height, 'up');
        $this->nutritional_status = nutritional_status($this->bmi);
    }

    public function RiskScore()
    {
        try {
            // if (($this->blood_hdl && $this->blood_ldl) || $this->blood_tga) {
            $f = FormulaDislipidemia::where('status', 'active')->first();

            $this->blood_dislipidemia = dislipidemia_status(intval($this->blood_cholesterol_total), intval($this->blood_ldl), intval($this->blood_tga), $f);

            if (!$this->employeeAge) {
                $employee = Employee::find($this->employeeId);
                $this->employeeAge = $employee->age;
            }

            if (!$this->employeeGender) {
                $employee = Employee::find($this->employeeId);
                $this->employeeGender = $employee->gender;
            }

            // if ($this->systolic_blood_pressure && $this->sports_per_week && $this->systolic_blood_pressure && $this->family_disease_history && $this->smoking && $this->bmi) {

            if (is_array($this->family_disease_history)) {
                if (in_array('Diabetes', $this->family_disease_history)) {
                    $diabetes = 'yes';
                } else {
                    $diabetes = 'no';
                };
            } else {
                if (str_contains($this->family_disease_history, 'Diabetes')) {
                    $diabetes = 'yes';
                } else {
                    $diabetes = 'no';
                }
            }

            $risk_by_sex_jc_score = risk_by_sex_jc_score($this->employeeGender);
            $risk_by_age_jc_score = risk_by_age_jc_score($this->employeeAge);
            $risk_by_blood_pressure_jc_score = risk_by_blood_pressure_jc_score($this->employeeAge);
            $risk_by_bmi_jc_score = risk_by_bmi_jc_score($this->bmi);
            $risk_by_smoking_jc_score = risk_by_blood_pressure_jc_score($this->smoking);
            $risk_by_diabetes_melitus_jc_score = risk_by_diabetes_melitus_jc_score($diabetes);
            $risk_by_activity_jc_score = risk_by_activity_jc_score($this->sports_per_week);
            $this->jakarta_cardiovascular_score = $risk_by_sex_jc_score + $risk_by_age_jc_score + $risk_by_blood_pressure_jc_score + $risk_by_bmi_jc_score + $risk_by_smoking_jc_score + $risk_by_diabetes_melitus_jc_score + $risk_by_activity_jc_score;
            $this->jakarta_cardiovascular_risk_level = jc_risk_level($this->jakarta_cardiovascular_score);

            // Framingham Risk
            $risk_factor_framingham_score = risk_factor_framingham_score($this->employeeGender, $this->employeeAge);
            $total_colesterol_framingham_score = total_colesterol_framingham_score($this->blood_cholesterol_total, $this->employeeGender);
            $hdl_colesterol_framingham_score = hdl_colesterol_framingham_score($this->blood_hdl, $this->employeeGender);
            $systolic_blood_framingham_score = systolic_blood_framingham_score($this->systolic_blood_pressure);
            $diabetes_melitus_framingham_score = diabetes_melitus_framingham_score($diabetes, $this->employeeGender);
            $smoking_framingham_score = smoking_framingham_score($this->employeeGender, $this->smoking);
            $this->framingham_score = $risk_factor_framingham_score + $total_colesterol_framingham_score + $hdl_colesterol_framingham_score + $systolic_blood_framingham_score + $diabetes_melitus_framingham_score + $smoking_framingham_score;
            $this->frammingham_risk_level = frammingham_risk_level($this->framingham_score);
            // }
            // }
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Error',
                'icon' => 'error',
                'text' => $th->getMessage(),
            ]);
        }
    }

    public function BloodPressureStatus()
    {
        $formula = FormulaBloodPressure::where('status', 'active')->first();

        $this->blood_pressure_status = blood_pressure_status($this->systolic_blood_pressure, $this->diastolic_blood_pressure, $formula);
    }

    public function DislipidemiaStatus()
    {
        $f = FormulaDislipidemia::where('status', 'active')->first();

        $this->blood_dislipidemia = dislipidemia_status(intval($this->blood_cholesterol_total), intval($this->blood_ldl), intval($this->blood_tga), $f);
    }

    public function eGFR()
    {
        if (!$this->employeeAge) {
            $employee = Employee::find($this->employeeId);
            $this->employeeAge = $employee->age;
        }

        if (!$this->employeeGender) {
            $employee = Employee::find($this->employeeId);
            $this->employeeGender = $employee->gender;
        }
        // dd($this->employeeGender, $this->employeeAge, $this->weight, $this->laboratory_creatinin);
        if ($this->laboratory_creatinin > 0) {
            $this->laboratory_uric_egfr = egfr_score($this->employeeGender, $this->employeeAge, $this->weight, $this->laboratory_creatinin);
        } else {
            $this->laboratory_uric_egfr = 0;
        }
    }

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function updated($propertyName, $value)
    {
        if ($propertyName == 'employeeGender' && $this->employeeGender) {
            if ($this->weight && $this->laboratory_creatinin) {
                $this->eGFR();
            }
            if ($this->height && $this->weight && $this->employeeGender) {
                $this->IdealFormula();
            }
        }

        if ($propertyName == 'weight' && $this->weight) {
            if ($this->laboratory_creatinin) {
                $this->eGFR();
            }
            if ($this->height) {
                // $this->blood_cholesterol_total = $this->blood_hdl + $this->blood_ldl;
                if ($this->employeeGender) {
                    $this->IdealFormula();
                }
            }
        }

        if ($propertyName == 'height' && $this->height) {
            if ($this->weight) {
                // $this->blood_cholesterol_total = $this->blood_hdl + $this->blood_ldl;
                if ($this->employeeGender) {
                    $this->IdealFormula();
                }
            }
        }

        if ($propertyName == 'blood_ldl' && $this->blood_ldl) {
            $this->DislipidemiaStatus();
        }

        if ($propertyName == 'blood_tga' && $this->blood_tga) {

            if ($this->systolic_blood_pressure && $this->diastolic_blood_pressure) {
                $this->BloodPressureStatus();
            }
            $this->DislipidemiaStatus();
        }

        if ($propertyName == 'blood_cholesterol_total' && $this->blood_cholesterol_total) {
            $this->DislipidemiaStatus();
        }

        if ($propertyName == 'systolic_blood_pressure' && $this->systolic_blood_pressure) {
            if ($this->diastolic_blood_pressure) {
                $this->BloodPressure();
                $this->BloodPressureStatus();
            }
        }

        if ($propertyName == 'diastolic_blood_pressure' && $this->diastolic_blood_pressure) {
            if ($this->systolic_blood_pressure) {
                $this->BloodPressure();
                $this->BloodPressureStatus();
            }
        }

        if ($propertyName == 'sports_per_week') {
        }
        if ($propertyName == 'family_disease_history') {
        }
        if ($propertyName == 'bmi') {
        }

        if ($propertyName == 'arteries' && $this->arteries) {
            if ($this->arteries > 100 || $this->arteries < 60) {
                $this->findings['arteries'] = 'Nadi : ' . $this->arteries . ' x/m';
                $status = 'Curently Unfit';
            }
        }

        if ($propertyName == 'employeeIdNumber') {
        }
        if ($propertyName == 'laboratory_creatinin' && $this->laboratory_creatinin) {
            $this->eGFR();
        }

        if ($propertyName == 'blood_gdpt' && $this->blood_gdpt) {
            $this->blood_hyperglycemic = hiperglikemia_status($this->blood_gdpt, $this->blood_g2pp);
        }

        if ($propertyName == 'blood_g2pp' && $this->blood_g2pp) {
            $this->blood_hyperglycemic = hiperglikemia_status($this->blood_gdpt, $this->blood_g2pp);
        }

        if ($propertyName == 'blood_billirubin_direk' && $this->blood_billirubin_direk) {
            if ($this->blood_billirubin_indirek) {
                $this->blood_billirubin_total = $this->blood_billirubin_direk + $this->blood_billirubin_indirek;
            }
        }

        if ($propertyName == 'blood_billirubin_indirek' && $this->blood_billirubin_indirek) {
            if ($this->blood_billirubin_direk) {
                $this->blood_billirubin_total = $this->blood_billirubin_direk + $this->blood_billirubin_indirek;
            }
        }
    }

    public function save()
    {
        try {
            if ($this->mode == 'draft') {
                $this->validate([
                    'mcu_date' => 'required',
                    'medical_type' => 'required',
                    'medical_ex_type' => 'required',
                ]);
                $status = 'draft';
            } elseif ($this->mode == 'save') {
                $this->validate([
                    'medical_type' => 'required',
                    'medical_ex_type' => 'required',
                    'mcu_date' => 'required',
                    'provider_id' => 'required',
                    'complaint' => 'required',
                    'previous_disease_history' => 'required',
                    // 'family_disease_history' => 'required',
                    // 'alergy' => 'required',
                    'smoking' => 'required',
                    'sports' => 'required',
                    // 'sports_per_week' => 'required',
                    'alcohol' => 'required',
                    'height' => 'required',
                    'weight' => 'required',
                    'systolic_blood_pressure' => 'required',
                    'diastolic_blood_pressure' => 'required',

                    'current_job' => 'required',
                    'previous_job' => 'required',
                    'current_job_details' => 'required',

                    'blood_hb' => 'required',
                    'blood_ht' => 'required',
                    'blood_leukosit' => 'required',
                    'blood_thrombosit' => 'required',
                    'blood_eritrosit' => 'required',
                    'blood_led' => 'required',
                    'blood_type' => 'required',
                    'blood_rhesus' => 'required',
                    'blood_sgot' => 'required',
                    'blood_sgpt' => 'required',
                    'blood_gamma_gt' => 'required',
                    'blood_cholesterol_total' => 'required',
                    'blood_hdl' => 'required',
                    'blood_ldl' => 'required',
                    'blood_tga' => 'required',
                    'blood_billirubin_total' => 'required',
                    'blood_billirubin_direk' => 'required',
                    'blood_billirubin_indirek' => 'required',
                    'blood_dislipidemia' => 'required',
                    // 'blood_gdpt' => 'required',
                    // 'blood_g2pp' => 'required',
                    'blood_hyperglycemic' => 'required',
                    // 'blood_hba1c' => 'required',
                    'blood_dm_status' => 'required',

                    'laboratory_ureum' => 'required',
                    // 'laboratory_bun' => 'required',
                    'laboratory_creatinin' => 'required',
                    'laboratory_uric_acid' => 'required',
                    'laboratory_uric_egfr' => 'required',

                    'laboratory_urinalysis_color' => 'required',
                    'laboratory_urinalysis_clarity' => 'required',
                    'laboratory_urinalysis_ph' => 'required',
                    'laboratory_urinalysis_density' => 'required',
                    'laboratory_urinalysis_protein' => 'required',
                    'laboratory_urinalysis_glucose' => 'required',
                    'laboratory_urinalysis_billirubin' => 'required',
                    'laboratory_urinalysis_urobillin' => 'required',
                    'laboratory_urinalysis_keton' => 'required',
                    'laboratory_urinalysis_blood' => 'required',
                    'laboratory_urinalysis_lekositesterase' => 'required',
                    'laboratory_urinalysis_nitrit' => 'required',
                    'laboratory_urinalysis_leukocyte_sediment' => 'required',
                    'laboratory_urinalysis_erythrocyte' => 'required',
                    'laboratory_urinalysis_epitel' => 'required',
                    'laboratory_urinalysis_cylinder' => 'required',
                    'laboratory_urinalysis_crystal' => 'required',
                    'laboratory_urinalysis_bacteria' => 'required',
                    'laboratory_urinalysis_etc' => 'required',

                    'laboratory_urinalysis_amp' => 'required',
                    'laboratory_urinalysis_met' => 'required',
                    'laboratory_urinalysis_bdz' => 'required',
                    'laboratory_urinalysis_coc' => 'required',
                    'laboratory_urinalysis_opi' => 'required',
                    'laboratory_urinalysis_thc' => 'required',
                ]);

                if ($this->employeeAge <= 55) {
                    $this->validate([
                        'visus_non_correction_od' => 'required',
                        'visus_non_correction_os' => 'required',
                        'visus_non_correction_ods' => 'required',
                        'visus_correction_od' => 'required',
                        'visus_correction_os' => 'required',
                        'visus_correction_ods' => 'required',
                        'visus_impression' => 'required',
                        'visus_reading_test' => 'required',
                        'visus_color_blind' => 'required',
                        // 'visus_field_of_view' => 'required',
                        'visus_notes' => 'required',

                        'laboratory_hbsag' => 'required',

                        'laboratory_malary' => 'required',

                        // drug test
                        'laboratory_urinalysis_amp' => 'required',
                        'laboratory_urinalysis_met' => 'required',
                        'laboratory_urinalysis_bdz' => 'required',
                        'laboratory_urinalysis_coc' => 'required',
                        'laboratory_urinalysis_opi' => 'required',
                        'laboratory_urinalysis_thc' => 'required',

                        // Amphetamine,
                        // Ophiate,
                        // Cannabis/THC,
                        // Benzodiazephine,
                        // Cocaine dan
                        // Metamphetamine

                        // xray dada
                        // 'choline_esterase' => 'required',
                    ]);
                    if ($this->medical_type == 'pre-retirement') {
                        $this->validate([
                            'laboratory_widal' => 'required',
                        ]);
                    }
                }

                if ($this->medical_ex_type == 'general-housekeeping') {

                    $this->validate([
                        'cholinesterase' => 'required',
                    ]);
                }

                if ($this->medical_ex_type == 'food-handler') {

                    if ($this->medical_type != 'pre-retirement') {
                        $this->validate([

                            'laboratory_urinalysis_feces_analysis' => 'required',
                            'laboratory_urinalysis_feces_culture' => 'required',
                            // 'cholinesterase' => 'required',
                        ]);
                    }

                    if ($this->medical_type == 'pre-retirement') {
                        $this->validate([
                            'laboratory_widal' => 'required',
                        ]);
                    } elseif ($this->medical_type == 'pre-employment') {
                        $this->validate([
                            'laboratory_urinalysis_feces_analysis' => 'required',
                            'laboratory_urinalysis_feces_culture' => 'required',
                            // 'cholinesterase' => 'required',
                        ]);
                    } elseif ($this->medical_type == 'periodic') {
                        $this->validate([
                            'laboratory_urinalysis_feces_analysis' => 'required',
                            'laboratory_urinalysis_feces_culture' => 'required',
                            // 'cholinesterase' => 'required',
                        ]);
                    }
                }

                $status = 'In Review';
            }

            DB::beginTransaction();

            if ($this->family_disease_history) {
                if (is_array($this->family_disease_history)) {
                    $family_disease_history = implode(", ", $this->family_disease_history);
                } else {
                    $family_disease_history = $this->family_disease_history;
                }
            } else {
                $family_disease_history = null;
            }

            // laboratory_urinalysis_feces_analysis
            if ($this->laboratory_urinalysis_feces_analysis) {
                if (is_array($this->laboratory_urinalysis_feces_analysis)) {
                    $laboratory_urinalysis_feces_analysis = implode(", ", $this->laboratory_urinalysis_feces_analysis);
                } else {
                    $laboratory_urinalysis_feces_analysis = $this->laboratory_urinalysis_feces_analysis;
                }
            } else {
                $laboratory_urinalysis_feces_analysis = null;
            }
            if (!empty($this->xray_thorax)) {
                if (is_array($this->xray_thorax)) {

                    $xray_thorax = implode(", ", $this->xray_thorax);
                } else {
                    $xray_thorax = $this->xray_thorax;
                }
            } else {
                $xray_thorax = null;
            }
            if (!empty($this->ekg)) {
                if (is_array($this->ekg)) {

                    $ekg = implode(", ", $this->ekg);
                } else {
                    $ekg = $this->ekg;
                }
            } else {
                $ekg = null;
            }

            if ($this->mode == 'save') {

                // findings (temuan)
                if ($this->complaint) {
                    $this->findings['complaint'] = $this->complaint;
                }

                if ($this->family_disease_history) {
                    $this->findings['family_disease_history'] = $this->family_disease_history;
                }

                // tekanan darah
                if ($this->blood_pressure_status == 'Pre - Hipertensi') {
                    $this->findings['blood_pressure_status'] = 'Pre - Hipertensi';
                    $this->findings['systolic_blood_pressure'] = 'Tekanan Darah Sistolik: ' . $this->systolic_blood_pressure . ' mmHg';
                    $this->findings['diastolic_blood_pressure'] = 'Tekanan Darah Diastolik : ' . $this->diastolic_blood_pressure . ' mmHg';
                } elseif ($this->blood_pressure_status == 'Hipertensi Tingkat 1') {
                    $this->findings['blood_pressure_status'] = 'Hipertensi Tingkat 1';
                    $this->findings['systolic_blood_pressure'] = 'Tekanan Darah Sistolik: ' . $this->systolic_blood_pressure . ' mmHg';
                    $this->findings['diastolic_blood_pressure'] = 'Tekanan Darah Diastolik : ' . $this->diastolic_blood_pressure . ' mmHg';
                } elseif ($this->blood_pressure_status == 'Hipertensi Tingkat 2') {
                    $this->findings['blood_pressure_status'] = 'Hipertensi Tingkat 2';
                    $this->findings['systolic_blood_pressure'] = 'Tekanan Darah Sistolik: ' . $this->systolic_blood_pressure . ' mmHg';
                    $this->findings['diastolic_blood_pressure'] = 'Tekanan Darah Diastolik : ' . $this->diastolic_blood_pressure . ' mmHg';
                } else {
                    $this->findings['blood_pressure_status'] = 'Hipertensi Tingkat 2';
                    $this->findings['systolic_blood_pressure'] = 'Tekanan Darah Sistolik: ' . $this->systolic_blood_pressure . ' mmHg';
                    $this->findings['diastolic_blood_pressure'] = 'Tekanan Darah Diastolik : ' . $this->diastolic_blood_pressure . ' mmHg';
                }

                // nadi
                if ($this->arteries > 100 || $this->arteries < 60) {
                    $this->findings['arteries'] = '' . $this->arteries . ' x/m';
                }

                // Indeks Massa Tubuh (bmi)
                if ($this->bmi > 35 || $this->bmi < 18) {
                    // if ($this->bmi > 35 || $this->bmi < 30 || ($this->bmi >= 18 && $this->bmi < 25)) {
                    $this->findings['bmi'] = '' . $this->bmi . ' kg/m2';
                }

                // kulit
                if ($this->genitounrinarius_system != 'Normal') {
                    // if ($this->bmi > 35 || $this->bmi < 30 || ($this->bmi >= 18 && $this->bmi < 25)) {
                    $this->findings['genitounrinarius_system'] = $this->genitounrinarius_system;
                }

                // Mata
                if ($this->visus_non_correction_od != '6/6') {
                    $this->findings['visus_non_correction_od'] = $this->visus_non_correction_od;
                }
                if ($this->visus_non_correction_os != '6/6') {
                    $this->findings['visus_non_correction_os'] = $this->visus_non_correction_os;
                }
                if ($this->visus_non_correction_ods != '6/6') {
                    $this->findings['visus_non_correction_ods'] = $this->visus_non_correction_ods;
                }
                if ($this->visus_correction_od != '6/6') {
                    $this->findings['visus_correction_od'] = $this->visus_correction_od;
                }
                if ($this->visus_correction_os != '6/6') {
                    $this->findings['visus_correction_os'] = $this->visus_correction_os;
                }
                if ($this->visus_correction_ods != '6/6') {
                    $this->findings['visus_correction_ods'] = $this->visus_correction_ods;
                }

                if ($this->visus_impression != 'Normal') {
                    $this->findings['visus_impression'] = $this->visus_impression;
                }

                if ($this->visus_color_blind != 'Normal') {
                    $this->findings['visus_color_blind'] = $this->visus_color_blind;
                }

                //Laboratorium: Darah
                if (!$this->employeeGender) {
                    $employee = Employee::find($this->employeeId);
                    $this->employeeGender = $employee->gender;
                }

                if ($this->employeeGender == 'male' && $this->blood_hb < 12) {
                    $this->findings['blood_hb'] = '' . $this->blood_hb . ' g/dL';
                }

                if ($this->employeeGender == 'female' && $this->blood_hb < 11) {
                    $this->findings['blood_hb'] = '' . $this->blood_hb . ' g/dL';
                }

                if ($this->blood_leukosit < 3000 || $this->blood_leukosit > 20000) {
                    $this->findings['blood_leukosit'] = '' . $this->blood_leukosit . ' /mm3';
                }

                if ($this->blood_thrombosit < 100000 || $this->blood_thrombosit > 500000) {
                    $this->findings['blood_thrombosit'] = '' . $this->blood_thrombosit . ' /mm3';
                }

                // Laju Endap Darah
                if ($this->blood_led > 50) {
                    $this->findings['blood_led'] = '' . $this->blood_led . ' /mm';
                }

                if ($this->blood_cholesterol_total > 200) {
                    $this->findings['blood_cholesterol_total'] = '' . $this->blood_cholesterol_total . ' mg/dL';
                }

                if ($this->blood_tga > 150) {
                    $this->findings['blood_tga'] = '' . $this->blood_tga . ' mg/dL';
                }

                if ($this->laboratory_ureum > 43) {
                    $this->findings['laboratory_ureum'] = '' . $this->laboratory_ureum . ' mg/dL';
                }

                if ($this->laboratory_creatinin > 3) {
                    $this->findings['laboratory_creatinin'] = '' . $this->laboratory_creatinin . ' mg/dL';
                }

                if ($this->employeeGender == 'male' && $this->laboratory_uric_acid > 7) {
                    $this->findings['laboratory_uric_acid'] = '' . $this->laboratory_uric_acid . ' mg/dL';
                }

                if ($this->employeeGender == 'female' && $this->laboratory_uric_acid > 5) {
                    $this->findings['laboratory_uric_acid'] = '' . $this->laboratory_uric_acid . ' mg/dL';
                }

                if ($this->blood_sgot < 17 || $this->blood_sgot >= 59) {
                    $this->findings['blood_sgot'] = '' . $this->blood_sgot . ' U/L';
                }

                if ($this->blood_sgpt < 21 || $this->blood_sgpt >= 72) {
                    $this->findings['blood_sgpt'] = '' . $this->blood_sgpt . ' U/L';
                }

                if ($this->blood_gamma_gt < 0 || $this->blood_gamma_gt >= 40) {
                    $this->findings['blood_gamma_gt'] = '' . $this->blood_gamma_gt . ' U/L';
                }

                // Glukosa darah puasa
                // Glukosa darah 2 jam post prandial
                // HBsAg

                // Eritrosit
                if ($this->laboratory_urinalysis_erythrocyte < 2 || $this->laboratory_urinalysis_erythrocyte > 2) {
                    $this->findings['laboratory_urinalysis_erythrocyte'] = '' . $this->laboratory_urinalysis_erythrocyte . ' LPB';
                }

                // Lekosit
                if ($this->laboratory_urinalysis_leukocyte_sediment < 5 || $this->laboratory_urinalysis_leukocyte_sediment > 5) {
                    $this->findings['laboratory_urinalysis_leukocyte_sediment'] = '' . $this->laboratory_urinalysis_leukocyte_sediment . ' LPB';
                }

                // Protein
                if ($this->laboratory_urinalysis_protein != 'Negatif') {
                    $this->findings['laboratory_urinalysis_protein'] = $this->laboratory_urinalysis_protein;
                }

                // Glukosa
                if ($this->laboratory_urinalysis_glucose != 'Negatif') {
                    $this->findings['laboratory_urinalysis_glucose'] = $this->laboratory_urinalysis_glucose;
                }

                // Keton
                if ($this->laboratory_urinalysis_keton != 'Negatif') {
                    $this->findings['laboratory_urinalysis_keton'] = $this->laboratory_urinalysis_keton;
                }

                // Kristal
                if ($this->laboratory_urinalysis_crystal != 'Negatif') {
                    $this->findings['laboratory_urinalysis_crystal'] = $this->laboratory_urinalysis_crystal;
                }

                // Bakteri
                if ($this->laboratory_urinalysis_bacteria != 'Negatif') {
                    $this->findings['laboratory_urinalysis_bacteria'] = $this->laboratory_urinalysis_bacteria;
                }

                // Jamur

                // Tinja Eritrosit
                if ($laboratory_urinalysis_feces_analysis && $laboratory_urinalysis_feces_analysis != 'Negatif') {
                    $this->findings['laboratory_urinalysis_feces_analysis'] = $laboratory_urinalysis_feces_analysis;
                }

                // X-Ray
                if ($this->xray_thorax && $this->xray_thorax != 'Normal') {
                    $this->findings['xray_thorax'] = $this->xray_thorax;
                }

                // treadmill
                if ($this->treadmill && $this->treadmill != 'Negatif iskemic respon') {
                    $this->findings['treadmill'] = $this->treadmill;
                }

                // audiometri

                // spirometri
                if ($this->spirometry_fvc && $this->spirometry_fvc < 60) {
                    $this->findings['spirometry_fvc'] = '' . $this->spirometry_fvc . ' %';
                }
                if ($this->spirometry_fev1 && $this->spirometry_fev1 < 60) {
                    $this->findings['spirometry_fev1'] = '' . $this->spirometry_fev1 . ' %';
                }

                // dd($this->findings);
                if ($this->medical_type && $this->medical_ex_type) {
                    $status = doctor_status_review($this->medical_type, $this->medical_ex_type, $this->findings);
                } else {
                    $status = null;
                }
                // findings end
            }

            $amc_matrix_compliance = ($this->findings) ? 'Tidak Sesuai' : 'Sesuai';

            $mcu_date = Carbon::parse($this->mcu_date);
            $mcu_exp_date = $mcu_date->addYear();

            $mcudata = [
                'formula_blood_pressure_id' => $this->formula_blood_pressure_id,
                'formula_dislipidemia_id' => $this->formula_dislipidemia_id,
                'provider_id' => $this->provider_id,

                'medical_type' => $this->medical_type,
                'medical_ex_type' => $this->medical_ex_type,
                'mcu_exp_date' => $mcu_exp_date,
                'mcu_date' => Carbon::parse($this->mcu_date),

                'complaint' => $this->complaint,
                'previous_disease_history' => $this->previous_disease_history,
                'family_disease_history' => $family_disease_history,
                'alergy' => $this->alergy,
                'smoking' => $this->smoking,
                'smoking_per_day' => $this->smoking_per_day,
                'sports' => $this->sports,
                'sports_per_week' => $this->sports_per_week,
                'sports_type' => $this->sports_type,
                'alcohol' => $this->alcohol,

                'menstrual_menarche' => $this->menstrual_menarche,
                'menstrual_cycle' => $this->menstrual_cycle,
                'menstrual_pain' => $this->menstrual_pain,
                'menstrual_period' => $this->menstrual_period,
                'pregnant_period' => $this->pregnant_period,
                'pregnant_spontan' => $this->pregnant_spontan,
                'pregnant_surgery' => $this->pregnant_surgery,
                'pregnant_abortion' => $this->pregnant_abortion,
                'contraception' => $this->contraception,
                'contraception_type' => $this->contraception_type,

                'current_job' => $this->current_job,
                'previous_job' => $this->previous_job,
                'current_job_details' => $this->current_job_details,

                'vaccination_hep_a1' => $this->vaccination_hep_a1,
                'vaccination_hep_a2' => $this->vaccination_hep_a2,
                'vaccination_hep_a3' => $this->vaccination_hep_a3,
                'vaccination_typhoid_1' => $this->vaccination_typhoid_1,
                'vaccination_typhoid_3' => $this->vaccination_typhoid_3,
                'vaccination_albendandazole' => $this->vaccination_albendandazole,

                'height' => $this->height,
                'weight' => $this->weight,
                'bmi' => $this->bmi,
                'nutritional_status' => $this->nutritional_status,
                'bmi_lower' => $this->bmi_lower,
                'bmi_upper' => $this->bmi_upper,
                'systolic_blood_pressure' => $this->systolic_blood_pressure,
                'diastolic_blood_pressure' => $this->diastolic_blood_pressure,
                'arteries' => $this->arteries,
                'rr' => $this->rr,
                'body_temperature' => $this->body_temperature,
                'blood_pressure_status' => $this->blood_pressure_status,
                'heent' => $this->heent,
                'orodental_caries' => $this->orodental_caries,
                'orodental_gangren_radix' => $this->orodental_gangren_radix,
                'cardiovascular_system' => $this->cardiovascular_system,
                'respiratorus_system' => $this->respiratorus_system,
                'digestivus_system' => $this->digestivus_system,
                'genitounrinarius_system' => $this->genitounrinarius_system,
                'neuromuscular_system' => $this->neuromuscular_system,
                'fitness_test' => $this->fitness_test,

                'visus_non_correction_od' => $this->visus_non_correction_od,
                'visus_non_correction_os' => $this->visus_non_correction_os,
                'visus_non_correction_ods' => $this->visus_non_correction_ods,
                'visus_correction_od' => $this->visus_correction_od,
                'visus_correction_os' => $this->visus_correction_os,
                'visus_correction_ods' => $this->visus_correction_ods,
                'visus_impression' => $this->visus_impression,
                'visus_reading_test' => $this->visus_reading_test,
                'visus_color_blind' => $this->visus_color_blind,
                'visus_field_of_view' => $this->visus_field_of_view,
                'visus_notes' => $this->visus_notes,

                'audiometry_right_air_conduction_500' => $this->audiometry_right_air_conduction_500,
                'audiometry_right_air_conduction_1000' => $this->audiometry_right_air_conduction_1000,
                'audiometry_right_air_conduction_2000' => $this->audiometry_right_air_conduction_2000,
                'audiometry_right_air_conduction_3000' => $this->audiometry_right_air_conduction_3000,
                'audiometry_right_air_conduction_4000' => $this->audiometry_right_air_conduction_4000,
                'audiometry_right_air_conduction_6000' => $this->audiometry_right_air_conduction_6000,
                'audiometry_right_air_conduction_8000' => $this->audiometry_right_air_conduction_8000,
                'audiometry_right_air_conduction_htl' => $this->audiometry_right_air_conduction_htl,
                'audiometry_right_bone_conduction_500' => $this->audiometry_right_bone_conduction_500,
                'audiometry_right_bone_conduction_1000' => $this->audiometry_right_bone_conduction_1000,
                'audiometry_right_bone_conduction_2000' => $this->audiometry_right_bone_conduction_2000,
                'audiometry_right_bone_conduction_3000' => $this->audiometry_right_bone_conduction_3000,
                'audiometry_right_bone_conduction_4000' => $this->audiometry_right_bone_conduction_4000,
                'audiometry_right_bone_conduction_6000' => $this->audiometry_right_bone_conduction_6000,
                'audiometry_right_bone_conduction_8000' => $this->audiometry_right_bone_conduction_8000,
                'audiometry_right_bone_conduction_htl' => $this->audiometry_right_bone_conduction_htl,

                'audiometry_left_air_conduction_500' => $this->audiometry_left_air_conduction_500,
                'audiometry_left_air_conduction_1000' => $this->audiometry_left_air_conduction_1000,
                'audiometry_left_air_conduction_2000' => $this->audiometry_left_air_conduction_2000,
                'audiometry_left_air_conduction_3000' => $this->audiometry_left_air_conduction_3000,
                'audiometry_left_air_conduction_4000' => $this->audiometry_left_air_conduction_4000,
                'audiometry_left_air_conduction_6000' => $this->audiometry_left_air_conduction_6000,
                'audiometry_left_air_conduction_8000' => $this->audiometry_left_air_conduction_8000,
                'audiometry_left_air_conduction_htl' => $this->audiometry_left_air_conduction_htl,
                'audiometry_left_bone_conduction_500' => $this->audiometry_left_bone_conduction_500,
                'audiometry_left_bone_conduction_1000' => $this->audiometry_left_bone_conduction_1000,
                'audiometry_left_bone_conduction_2000' => $this->audiometry_left_bone_conduction_2000,
                'audiometry_left_bone_conduction_3000' => $this->audiometry_left_bone_conduction_3000,
                'audiometry_left_bone_conduction_4000' => $this->audiometry_left_bone_conduction_4000,
                'audiometry_left_bone_conduction_6000' => $this->audiometry_left_bone_conduction_6000,
                'audiometry_left_bone_conduction_8000' => $this->audiometry_left_bone_conduction_8000,
                'audiometry_left_bone_conduction_htl' => $this->audiometry_left_bone_conduction_htl,

                'audiometry_conclusion' => $this->audiometry_conclusion,
                'audiometry_impression' => $this->audiometry_impression,

                'spirometry_fvc' => $this->spirometry_fvc,
                'spirometry_fev1' => $this->spirometry_fev1,
                'spirometry_impression' => $this->spirometry_impression,

                'xray_thorax' => $xray_thorax,
                'xray_thorax_note' => $this->xray_thorax_note,
                'ekg' => $ekg,
                'ekg_note' => $this->ekg_note,
                'treadmill' => $this->treadmill,
                'echocardiography' => $this->echocardiography,
                'additional_diagnosis' => $this->additional_diagnosis,

                'blood_hb' => $this->blood_hb,
                'blood_ht' => $this->blood_ht,
                'blood_leukosit' => $this->blood_leukosit,
                'blood_thrombosit' => $this->blood_thrombosit,
                'blood_eritrosit' => $this->blood_eritrosit,
                'blood_led' => $this->blood_led,
                'blood_type' => $this->blood_type,
                'blood_rhesus' => $this->blood_rhesus,
                'blood_sgot' => $this->blood_sgot,
                'blood_sgpt' => $this->blood_sgpt,
                'blood_gamma_gt' => $this->blood_gamma_gt,
                'blood_cholesterol_total' => $this->blood_cholesterol_total,
                'blood_hdl' => $this->blood_hdl,
                'blood_ldl' => $this->blood_ldl,
                'blood_tga' => $this->blood_tga,
                'blood_billirubin_total' => $this->blood_billirubin_total,
                'blood_billirubin_direk' => $this->blood_billirubin_direk,
                'blood_billirubin_indirek' => $this->blood_billirubin_indirek,
                'blood_dislipidemia' => $this->blood_dislipidemia,
                'blood_gdpt' => $this->blood_gdpt,
                'blood_g2pp' => $this->blood_g2pp,
                'blood_hyperglycemic' => $this->blood_hyperglycemic,
                'blood_hba1c' => $this->blood_hba1c,
                'blood_dm_status' => $this->blood_dm_status,

                'jakarta_cardiovascular_score' => $this->jakarta_cardiovascular_score,
                'jakarta_cardiovascular_risk_level' => $this->jakarta_cardiovascular_risk_level,
                'framingham_score' => $this->framingham_score,
                'frammingham_risk_level' => $this->frammingham_risk_level,

                'laboratory_ureum' => $this->laboratory_ureum,
                'laboratory_bun' => $this->laboratory_bun,
                'laboratory_creatinin' => $this->laboratory_creatinin,
                'laboratory_uric_acid' => $this->laboratory_uric_acid,
                'laboratory_uric_egfr' => $this->laboratory_uric_egfr,
                'laboratory_hbsag' => $this->laboratory_hbsag,
                'laboratory_anti_hbs' => $this->laboratory_anti_hbs,
                'laboratory_anti_havlgm' => $this->laboratory_anti_havlgm,
                'laboratory_widal' => $this->laboratory_widal,
                'laboratory_malary' => $this->laboratory_malary,
                'laboratory_urinalysis_color' => $this->laboratory_urinalysis_color,
                'laboratory_urinalysis_clarity' => $this->laboratory_urinalysis_clarity,
                'laboratory_urinalysis_ph' => $this->laboratory_urinalysis_ph,
                'laboratory_urinalysis_density' => $this->laboratory_urinalysis_density,
                'laboratory_urinalysis_protein' => $this->laboratory_urinalysis_protein,
                'laboratory_urinalysis_glucose' => $this->laboratory_urinalysis_glucose,
                'laboratory_urinalysis_billirubin' => $this->laboratory_urinalysis_billirubin,
                'laboratory_urinalysis_urobillin' => $this->laboratory_urinalysis_urobillin,
                'laboratory_urinalysis_keton' => $this->laboratory_urinalysis_keton,
                'laboratory_urinalysis_blood' => $this->laboratory_urinalysis_blood,
                'laboratory_urinalysis_lekositesterase' => $this->laboratory_urinalysis_lekositesterase,
                'laboratory_urinalysis_nitrit' => $this->laboratory_urinalysis_nitrit,
                'laboratory_urinalysis_leukocyte_sediment' => $this->laboratory_urinalysis_leukocyte_sediment,
                'laboratory_urinalysis_erythrocyte' => $this->laboratory_urinalysis_erythrocyte,
                'laboratory_urinalysis_epitel' => $this->laboratory_urinalysis_epitel,
                'laboratory_urinalysis_cylinder' => $this->laboratory_urinalysis_cylinder,
                'laboratory_urinalysis_crystal' => $this->laboratory_urinalysis_crystal,
                'laboratory_urinalysis_bacteria' => $this->laboratory_urinalysis_bacteria,
                'laboratory_urinalysis_etc' => $this->laboratory_urinalysis_etc,

                'laboratory_urinalysis_amp' => $this->laboratory_urinalysis_amp,
                'laboratory_urinalysis_met' => $this->laboratory_urinalysis_met,
                'laboratory_urinalysis_bdz' => $this->laboratory_urinalysis_bdz,
                'laboratory_urinalysis_coc' => $this->laboratory_urinalysis_coc,
                'laboratory_urinalysis_opi' => $this->laboratory_urinalysis_opi,
                'laboratory_urinalysis_thc' => $this->laboratory_urinalysis_thc,
                'laboratory_urinalysis_feces_analysis' => $laboratory_urinalysis_feces_analysis,
                'laboratory_urinalysis_feces_culture' => $this->laboratory_urinalysis_feces_culture,
                'cholinesterase' => $this->cholinesterase,

                'findings' => $this->findings,
                'amc_matrix_compliance' => $amc_matrix_compliance,

                'doctor_status_review' => $status,
            ];

            $update = MedicalHistory::where('id', $this->mcu_id)->update($mcudata);

            if ($this->file) {
                $file_name = "" . $this->employeeId . "-" . slugify(Carbon::parse($this->mcu_date)->format('Y-m-d')) . ".pdf";
                Storage::disk('public')->putFileAs('mcu/attachment', $this->file, $file_name);
            }
            // dd($file_name);

            // dd('stop');
            DB::commit();

            $this->dispatchBrowserEvent('swal', [
                'title' => 'Berhasil',
                'icon' => 'success',
                'text' => 'Update Data MCU berhasil di simpan',
            ]);

            redirect()->route('mcu::medical-staff');
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
        if (Auth::user()->hasPermissionTo('MCU - Edit MCU')) {
            $user_id = auth()->user()->id;
            return view('mcu::livewire.medical-staff.edit', ['staff' => Employee::where('user_id', $user_id)->first(), 'employee' => Employee::all()->where('user_id', '!=', $user_id)])->extends('mcu::layouts.no-header');
        } else {
            return abort(404);
        }
    }
}
