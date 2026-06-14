<?php

namespace App\Http\Livewire\Mcu\MedicalStaff;

use App\Models\Employee;
use App\Models\Mcu\FormulaBloodPressure;
use App\Models\Mcu\FormulaDislipidemia;
use App\Models\Mcu\MedicalHistory;
use App\Models\Mcu\Provider;
use Carbon\Carbon;
use Livewire\Component;

class Forms extends Component
{
    public $mode, $mcu_id, $medical_ex_type, $type, $provider, $employee_department, $employee_position, $employee_nip, $employee_id_number, $employee_name = '-', $employee_birthdate, $employee_age, $employee_gender, $status, $mcu_details;

    public $employee_id, $staff_id = 1, $doctor_id;
    public $formula_blood_pressure_id, $formula_dislipidemia_id, $provider_id, $medical_type, $mcu_date, $mcu_exp_date, $mcu_review_date;
    public $complaint, $previous_disease_history, $family_disease_history = [], $alergy, $smoking, $smoking_per_day, $sports, $sports_per_week, $sports_type, $alcohol;
    public $menstrual_menarche, $menstrual_cycle, $menstrual_pain, $menstrual_period, $pregnant_period, $pregnant_spontan, $pregnant_surgery, $pregnant_abortion, $contraception, $contraception_type;
    public $previous_job, $current_job, $current_job_details;
    public $vaccination_hep_a1, $vaccination_hep_a2, $vaccination_hep_a3, $vaccination_typhoid_1, $vaccination_typhoid_3, $vaccination_albendandazole;
    public $height, $weight, $bmi, $nutritional_status, $bmi_lower, $bmi_upper, $systolic_blood_pressure, $diastolic_blood_pressure, $arteries, $rr, $body_temperature, $blood_pressure_status, $heent, $orodental_caries, $orodental_gangren_radix, $cardiovascular_system, $respiratorus_system, $digestivus_system, $genitounrinarius_system, $neuromuscular_system, $fitness_test;
    public $visus_non_correction_od, $visus_non_correction_os, $visus_non_correction_ods, $visus_correction_od, $visus_correction_os, $visus_correction_ods, $visus_impression, $visus_reading_test, $visus_color_blind, $visus_field_of_view, $visus_notes;
    public $audiometry_right_air_conduction_500, $audiometry_right_air_conduction_1000, $audiometry_right_air_conduction_2000, $audiometry_right_air_conduction_3000, $audiometry_right_air_conduction_4000, $audiometry_right_air_conduction_6000, $audiometry_right_air_conduction_8000, $audiometry_right_air_conduction_htl, $audiometry_right_bone_conduction_500, $audiometry_right_bone_conduction_1000, $audiometry_right_bone_conduction_2000, $audiometry_right_bone_conduction_3000, $audiometry_right_bone_conduction_4000, $audiometry_right_bone_conduction_6000, $audiometry_right_bone_conduction_8000, $audiometry_right_bone_conduction_htl, $audiometry_left_air_conduction_500, $audiometry_left_air_conduction_1000, $audiometry_left_air_conduction_2000, $audiometry_left_air_conduction_3000, $audiometry_left_air_conduction_4000, $audiometry_left_air_conduction_6000, $audiometry_left_air_conduction_8000, $audiometry_left_air_conduction_htl, $audiometry_left_bone_conduction_500, $audiometry_left_bone_conduction_1000, $audiometry_left_bone_conduction_2000, $audiometry_left_bone_conduction_3000, $audiometry_left_bone_conduction_4000, $audiometry_left_bone_conduction_6000, $audiometry_left_bone_conduction_8000, $audiometry_left_bone_conduction_htl;
    public $audiometry_conclusion, $audiometry_impression;
    public $spirometry_fvc, $spirometry_fev1, $spirometry_impression;
    public $xray_thorax = [], $ekg = [], $treadmill, $echocardiography, $additional_diagnosis;
    public $blood_hb, $blood_ht, $blood_leukosit, $blood_thrombosit, $blood_eritrosit, $blood_led, $blood_type, $blood_rhesus, $blood_sgot, $blood_sgpt, $blood_gamma_gt, $blood_cholesterol_total, $blood_hdl, $blood_ldl, $blood_tga, $blood_billirubin_total, $blood_billirubin_direk, $blood_billirubin_indirek, $blood_dislipidemia, $blood_gdpt, $blood_g2pp, $blood_hyperglycemic, $blood_hba1c, $blood_dm_status;
    public $jakarta_cardiovascular_score, $jakarta_cardiovascular_risk_level, $framingham_score, $frammingham_risk_level;
    public $laboratory_ureum, $laboratory_bun, $laboratory_creatinin, $laboratory_uric_acid, $laboratory_uric_egfr, $laboratory_hbsag, $laboratory_anti_hbs, $laboratory_anti_havlgm, $laboratory_widal, $laboratory_malary, $laboratory_urinalysis_color, $laboratory_urinalysis_clarity, $laboratory_urinalysis_ph, $laboratory_urinalysis_density, $laboratory_urinalysis_protein, $laboratory_urinalysis_glucose, $laboratory_urinalysis_billirubin, $laboratory_urinalysis_urobillin, $laboratory_urinalysis_keton, $laboratory_urinalysis_blood, $laboratory_urinalysis_lekositesterase, $laboratory_urinalysis_nitrit, $laboratory_urinalysis_leukocyte_sediment, $laboratory_urinalysis_erythrocyte, $laboratory_urinalysis_epitel, $laboratory_urinalysis_cylinder, $laboratory_urinalysis_crystal, $laboratory_urinalysis_bacteria, $laboratory_urinalysis_etc, $laboratory_urinalysis_amp, $laboratory_urinalysis_met, $laboratory_urinalysis_bdz, $laboratory_urinalysis_coc, $laboratory_urinalysis_opi, $laboratory_urinalysis_thc, $laboratory_urinalysis_feces_analysis, $laboratory_urinalysis_feces_culture;
    // public $additional_exam, $findings, $amc_matrix_compliance;
    public $findings = [];
    public $doctor_status_review, $doctor_suggestion, $doctor_certificate_number, $doctor_expiration, $doctor_remark;

    public function mount($type)
    {
        // dd($type);
        $this->staff_id = 1; // get from session
        if (strlen($type) > 15) {
            $this->mcu_id = $type;
            $mcu_data = MedicalHistory::with('employee')->find($this->mcu_id);

            $carbonNow = Carbon::now();

            if (($mcu_data->doctor_status_review != 'draft') && ($carbonNow->diffInMinutes(Carbon::parse($mcu_data->updated_at)) > 60)) {
                redirect()->route('mcu::medical-staff-list');
            }
            // dd($mcu_data);
            $this->medical_ex_type = $mcu_data->medical_ex_type;
            $this->medical_type = $mcu_data->medical_type;

            $this->employee_id = $mcu_data->employee_id;

            $this->employee_department = $mcu_data['employee']['department'];
            $this->employee_position = $mcu_data['employee']['position'];
            $this->employee_nip = $mcu_data['employee']['number'];
            $this->employee_id_number = $mcu_data['employee']['id_number'];
            $this->employee_name = $mcu_data['employee']['name'];
            $this->employee_birthdate = Carbon::parse($mcu_data['employee']['date_of_birth'])->format('d M Y');
            $this->employee_age = Carbon::parse($mcu_data['employee']['date_of_birth'])->age;

            $this->employee_gender = $mcu_data['employee']['gender'];

            $this->staff_id = 1;
            $this->doctor_id = 1;
            $this->formula_blood_pressure_id = $mcu_data->formula_blood_pressure_id;
            $this->formula_dislipidemia_id = $mcu_data->formula_dislipidemia_id;
            $this->provider_id = $mcu_data->provider_id;

            $this->medical_type = $mcu_data->medical_type;
            $this->mcu_date = $mcu_data->mcu_date;

            $this->complaint = $mcu_data->complaint;
            $this->previous_disease_history = $mcu_data->previous_disease_history;
            $this->family_disease_history = $mcu_data->family_disease_history;
            $this->alergy = $mcu_data->alergy;
            $this->smoking = $mcu_data->smoking;
            $this->smoking_per_day = $mcu_data->smoking_per_day;
            $this->sports = $mcu_data->sports;
            $this->sports_per_week = $mcu_data->sports_per_week;
            $this->sports_type = $mcu_data->sports_type;
            $this->alcohol = $mcu_data->alcohol;

            $this->menstrual_menarche = $mcu_data->menstrual_menarche;
            $this->menstrual_cycle = $mcu_data->menstrual_cycle;
            $this->menstrual_pain = $mcu_data->menstrual_pain;
            $this->menstrual_period = $mcu_data->menstrual_period;
            $this->pregnant_period = $mcu_data->pregnant_period;
            $this->pregnant_spontan = $mcu_data->pregnant_spontan;
            $this->pregnant_surgery = $mcu_data->pregnant_surgery;
            $this->pregnant_abortion = $mcu_data->pregnant_abortion;
            $this->contraception = $mcu_data->contraception;
            $this->contraception_type = $mcu_data->contraception_type;

            $this->current_job = $mcu_data->current_job;
            $this->previous_job = $mcu_data->previous_job;
            $this->current_job_details = $mcu_data->current_job_details;

            $this->vaccination_hep_a1 = $mcu_data->vaccination_hep_a1;
            $this->vaccination_hep_a2 = $mcu_data->vaccination_hep_a2;
            $this->vaccination_hep_a3 = $mcu_data->vaccination_hep_a3;
            $this->vaccination_typhoid_1 = $mcu_data->vaccination_typhoid_1;
            $this->vaccination_typhoid_3 = $mcu_data->vaccination_typhoid_3;
            $this->vaccination_albendandazole = $mcu_data->vaccination_albendandazole;

            $this->height = $mcu_data->height;
            $this->weight = $mcu_data->weight;
            $this->bmi = $mcu_data->bmi;
            $this->nutritional_status = $mcu_data->nutritional_status;
            $this->bmi_lower = $mcu_data->bmi_lower;
            $this->bmi_upper = $mcu_data->bmi_upper;
            $this->systolic_blood_pressure = $mcu_data->systolic_blood_pressure;
            $this->diastolic_blood_pressure = $mcu_data->diastolic_blood_pressure;
            $this->arteries = $mcu_data->arteries;
            $this->rr = $mcu_data->rr;
            $this->body_temperature = $mcu_data->body_temperature;
            $this->blood_pressure_status = $mcu_data->blood_pressure_status;
            $this->heent = $mcu_data->heent;
            $this->orodental_caries = $mcu_data->orodental_caries;
            $this->orodental_gangren_radix = $mcu_data->orodental_gangren_radix;
            $this->cardiovascular_system = $mcu_data->cardiovascular_system;
            $this->respiratorus_system = $mcu_data->respiratorus_system;
            $this->digestivus_system = $mcu_data->digestivus_system;
            $this->genitounrinarius_system = $mcu_data->genitounrinarius_system;
            $this->neuromuscular_system = $mcu_data->neuromuscular_system;
            $this->fitness_test = $mcu_data->fitness_test;

            $this->visus_non_correction_od = $mcu_data->visus_non_correction_od;
            $this->visus_non_correction_os = $mcu_data->visus_non_correction_os;
            $this->visus_non_correction_ods = $mcu_data->visus_non_correction_ods;
            $this->visus_correction_od = $mcu_data->visus_correction_od;
            $this->visus_correction_os = $mcu_data->visus_correction_os;
            $this->visus_correction_ods = $mcu_data->visus_correction_ods;
            $this->visus_impression = $mcu_data->visus_impression;
            $this->visus_reading_test = $mcu_data->visus_reading_test;
            $this->visus_color_blind = $mcu_data->visus_color_blind;
            $this->visus_field_of_view = $mcu_data->visus_field_of_view;
            $this->visus_notes = $mcu_data->visus_notes;

            $this->audiometry_right_air_conduction_500 = $mcu_data->audiometry_right_air_conduction_500;
            $this->audiometry_right_air_conduction_1000 = $mcu_data->audiometry_right_air_conduction_1000;
            $this->audiometry_right_air_conduction_2000 = $mcu_data->audiometry_right_air_conduction_2000;
            $this->audiometry_right_air_conduction_3000 = $mcu_data->audiometry_right_air_conduction_3000;
            $this->audiometry_right_air_conduction_4000 = $mcu_data->audiometry_right_air_conduction_4000;
            $this->audiometry_right_air_conduction_6000 = $mcu_data->audiometry_right_air_conduction_6000;
            $this->audiometry_right_air_conduction_8000 = $mcu_data->audiometry_right_air_conduction_8000;
            $this->audiometry_right_air_conduction_htl = $mcu_data->audiometry_right_air_conduction_htl;
            $this->audiometry_right_bone_conduction_500 = $mcu_data->audiometry_right_bone_conduction_500;
            $this->audiometry_right_bone_conduction_1000 = $mcu_data->audiometry_right_bone_conduction_1000;
            $this->audiometry_right_bone_conduction_2000 = $mcu_data->audiometry_right_bone_conduction_2000;
            $this->audiometry_right_bone_conduction_3000 = $mcu_data->audiometry_right_bone_conduction_3000;
            $this->audiometry_right_bone_conduction_4000 = $mcu_data->audiometry_right_bone_conduction_4000;
            $this->audiometry_right_bone_conduction_6000 = $mcu_data->audiometry_right_bone_conduction_6000;
            $this->audiometry_right_bone_conduction_8000 = $mcu_data->audiometry_right_bone_conduction_8000;
            $this->audiometry_right_bone_conduction_htl = $mcu_data->audiometry_right_bone_conduction_htl;

            $this->audiometry_left_air_conduction_500 = $mcu_data->audiometry_left_air_conduction_500;
            $this->audiometry_left_air_conduction_1000 = $mcu_data->audiometry_left_air_conduction_1000;
            $this->audiometry_left_air_conduction_2000 = $mcu_data->audiometry_left_air_conduction_2000;
            $this->audiometry_left_air_conduction_3000 = $mcu_data->audiometry_left_air_conduction_3000;
            $this->audiometry_left_air_conduction_4000 = $mcu_data->audiometry_left_air_conduction_4000;
            $this->audiometry_left_air_conduction_6000 = $mcu_data->audiometry_left_air_conduction_6000;
            $this->audiometry_left_air_conduction_8000 = $mcu_data->audiometry_left_air_conduction_8000;
            $this->audiometry_left_air_conduction_htl = $mcu_data->audiometry_left_air_conduction_htl;
            $this->audiometry_left_bone_conduction_500 = $mcu_data->audiometry_left_bone_conduction_500;
            $this->audiometry_left_bone_conduction_1000 = $mcu_data->audiometry_left_bone_conduction_1000;
            $this->audiometry_left_bone_conduction_2000 = $mcu_data->audiometry_left_bone_conduction_2000;
            $this->audiometry_left_bone_conduction_3000 = $mcu_data->audiometry_left_bone_conduction_3000;
            $this->audiometry_left_bone_conduction_4000 = $mcu_data->audiometry_left_bone_conduction_4000;
            $this->audiometry_left_bone_conduction_6000 = $mcu_data->audiometry_left_bone_conduction_6000;
            $this->audiometry_left_bone_conduction_8000 = $mcu_data->audiometry_left_bone_conduction_8000;
            $this->audiometry_left_bone_conduction_htl = $mcu_data->audiometry_left_bone_conduction_htl;

            $this->audiometry_conclusion = $mcu_data->audiometry_conclusion;
            $this->audiometry_impression = $mcu_data->audiometry_impression;

            $this->spirometry_fvc = $mcu_data->spirometry_fvc;
            $this->spirometry_fev1 = $mcu_data->spirometry_fev1;
            $this->spirometry_impression = $mcu_data->spirometry_impression;

            $this->xray_thorax = $mcu_data->xray_thorax;
            $this->ekg = $mcu_data->ekg;
            $this->treadmill = $mcu_data->treadmill;
            $this->echocardiography = $mcu_data->echocardiography;
            $this->additional_diagnosis = $mcu_data->additional_diagnosis;

            $this->blood_hb = $mcu_data->blood_hb;
            $this->blood_ht = $mcu_data->blood_ht;
            $this->blood_leukosit = $mcu_data->blood_leukosit;
            $this->blood_thrombosit = $mcu_data->blood_thrombosit;
            $this->blood_eritrosit = $mcu_data->blood_eritrosit;
            $this->blood_led = $mcu_data->blood_led;
            $this->blood_type = $mcu_data->blood_type;
            $this->blood_rhesus = $mcu_data->blood_rhesus;
            $this->blood_sgot = $mcu_data->blood_sgot;
            $this->blood_sgpt = $mcu_data->blood_sgpt;
            $this->blood_gamma_gt = $mcu_data->blood_gamma_gt;
            $this->blood_cholesterol_total = $mcu_data->blood_cholesterol_total;
            $this->blood_hdl = $mcu_data->blood_hdl;
            $this->blood_ldl = $mcu_data->blood_ldl;
            $this->blood_tga = $mcu_data->blood_tga;
            $this->blood_billirubin_total = $mcu_data->blood_billirubin_total;
            $this->blood_billirubin_direk = $mcu_data->blood_billirubin_direk;
            $this->blood_billirubin_indirek = $mcu_data->blood_billirubin_indirek;
            $this->blood_dislipidemia = $mcu_data->blood_dislipidemia;
            $this->blood_gdpt = $mcu_data->blood_gdpt;
            $this->blood_g2pp = $mcu_data->blood_g2pp;
            $this->blood_hyperglycemic = $mcu_data->blood_hyperglycemic;
            $this->blood_hba1c = $mcu_data->blood_hba1c;
            $this->blood_dm_status = $mcu_data->blood_dm_status;

            $this->jakarta_cardiovascular_score = $mcu_data->jakarta_cardiovascular_score;
            $this->jakarta_cardiovascular_risk_level = $mcu_data->jakarta_cardiovascular_risk_level;
            $this->framingham_score = $mcu_data->framingham_score;
            $this->frammingham_risk_level = $mcu_data->frammingham_risk_level;

            $this->laboratory_ureum = $mcu_data->laboratory_ureum;
            $this->laboratory_bun = $mcu_data->laboratory_bun;
            $this->laboratory_creatinin = $mcu_data->laboratory_creatinin;
            $this->laboratory_uric_acid = $mcu_data->laboratory_uric_acid;
            $this->laboratory_uric_egfr = $mcu_data->laboratory_uric_egfr;
            $this->laboratory_hbsag = $mcu_data->laboratory_hbsag;
            $this->laboratory_anti_hbs = $mcu_data->laboratory_anti_hbs;
            $this->laboratory_anti_havlgm = $mcu_data->laboratory_anti_havlgm;
            $this->laboratory_widal = $mcu_data->laboratory_widal;
            $this->laboratory_malary = $mcu_data->laboratory_malary;
            $this->laboratory_urinalysis_color = $mcu_data->laboratory_urinalysis_color;
            $this->laboratory_urinalysis_clarity = $mcu_data->laboratory_urinalysis_clarity;
            $this->laboratory_urinalysis_ph = $mcu_data->laboratory_urinalysis_ph;
            $this->laboratory_urinalysis_density = $mcu_data->laboratory_urinalysis_density;
            $this->laboratory_urinalysis_protein = $mcu_data->laboratory_urinalysis_protein;
            $this->laboratory_urinalysis_glucose = $mcu_data->laboratory_urinalysis_glucose;
            $this->laboratory_urinalysis_billirubin = $mcu_data->laboratory_urinalysis_billirubin;
            $this->laboratory_urinalysis_urobillin = $mcu_data->laboratory_urinalysis_urobillin;
            $this->laboratory_urinalysis_keton = $mcu_data->laboratory_urinalysis_keton;
            $this->laboratory_urinalysis_blood = $mcu_data->laboratory_urinalysis_blood;
            $this->laboratory_urinalysis_lekositesterase = $mcu_data->laboratory_urinalysis_lekositesterase;
            $this->laboratory_urinalysis_nitrit = $mcu_data->laboratory_urinalysis_nitrit;
            $this->laboratory_urinalysis_leukocyte_sediment = $mcu_data->laboratory_urinalysis_leukocyte_sediment;
            $this->laboratory_urinalysis_erythrocyte = $mcu_data->laboratory_urinalysis_erythrocyte;
            $this->laboratory_urinalysis_epitel = $mcu_data->laboratory_urinalysis_epitel;
            $this->laboratory_urinalysis_cylinder = $mcu_data->laboratory_urinalysis_cylinder;
            $this->laboratory_urinalysis_crystal = $mcu_data->laboratory_urinalysis_crystal;
            $this->laboratory_urinalysis_bacteria = $mcu_data->laboratory_urinalysis_bacteria;
            $this->laboratory_urinalysis_etc = $mcu_data->laboratory_urinalysis_etc;

            $this->laboratory_urinalysis_amp = $mcu_data->laboratory_urinalysis_amp;
            $this->laboratory_urinalysis_met = $mcu_data->laboratory_urinalysis_met;
            $this->laboratory_urinalysis_bdz = $mcu_data->laboratory_urinalysis_bdz;
            $this->laboratory_urinalysis_coc = $mcu_data->laboratory_urinalysis_coc;
            $this->laboratory_urinalysis_opi = $mcu_data->laboratory_urinalysis_opi;
            $this->laboratory_urinalysis_thc = $mcu_data->laboratory_urinalysis_thc;
            $this->laboratory_urinalysis_feces_analysis = $mcu_data->laboratory_urinalysis_feces_analysis;
            $this->laboratory_urinalysis_feces_culture = $mcu_data->laboratory_urinalysis_feces_culture;
            // $this->additional_exam = $mcu_data->additional_exam;
            // $this->doctor_status_review = $status;
        } else {
            $this->type = $type;
        }

        $this->mcu_date = Carbon::now()->format('M d Y');
        $this->mcu_exp_date = Carbon::now()->format('M d Y');
        $this->mcu_review_date = Carbon::now()->format('M d Y');
        $this->provider = Provider::get();

        // Dari default active setting formula
        $FormulaBloodPressure = FormulaBloodPressure::where('status', 'active')->first();
        $this->formula_blood_pressure_id = $FormulaBloodPressure->id;

        $FormulaDislipidemia = FormulaDislipidemia::where('status', 'active')->first();
        $this->formula_dislipidemia_id = $FormulaDislipidemia->id;
        // $this->mcu_details = view('livewire.mcu.medical-staff.forms');
    }

    public function updated($employee_id, $systolic_blood_pressure = 0, $diastolic_blood_pressure = 0)
    {
        $e = Employee::with('companys', 'departments')->find($this->$employee_id);
        // dd($e['departments']['name']);
        if (!empty($e->name)) {
            // $this->employee_department = $e['departments']['name'];
            $this->employee_department = $e->department;
            $this->employee_position = $e->position;
            $this->employee_nip = $e->number;
            $this->employee_id_number = $e->id_number;
            $this->employee_name = $e->name;
            $this->employee_birthdate = Carbon::parse($e->date_of_birth)->format('d M Y');
            $this->employee_age = Carbon::parse($e->date_of_birth)->age;

            $this->employee_gender = $e->gender;
        }

        if ($this->systolic_blood_pressure >= 160 && $this->diastolic_blood_pressure >= 100) {
            $this->findings['systolic_blood_pressure'] = 'Tekanan Darah Sistolik: ' . $this->systolic_blood_pressure . ' mmHg';
            $this->findings['diastolic_blood_pressure'] = 'Tekanan Darah Diastolik : ' . $this->diastolic_blood_pressure . ' mmHg';
        }

    }
// Temuan
    // public function updatedBmi($bmi)
    // {
    //     if ($this->bmi >= 35) {
    //         $this->findings['bmi'] = 'Index massa tubuh : ' . $this->bmi . ' kg/m2';
    //         $status = 'Curently Unfit';
    //     }
    // }

    public function updatedArteries($arteries)
    {
        if ($this->arteries > 100 || $this->arteries < 60) {
            $this->findings['arteries'] = 'Nadi : ' . $this->arteries . ' x/m';
            $status = 'Curently Unfit';
        }
        dd($this->findings);
    }

    public function IdealFormula($height, $weight)
    {
        $employee = Employee::find($this->employee_id);
        $gender = $employee->gender;
        $this->bmi = imt_ideal($height, $weight);
        // Temuan
        if ($this->bmi >= 35) {
            $this->findings['bmi'] = 'Index massa tubuh : ' . $this->bmi . ' kg/m2';
            $status = 'Curently Unfit';
        }
        $this->bmi_lower = imt_ideal_limit($gender, $height, 'low');
        $this->bmi_upper = imt_ideal_limit($gender, $height, 'up');
        $this->nutritional_status = nutritional_status($this->bmi);
    }

    public function RiskScore()
    {
        if (($this->blood_hdl && $this->blood_ldl) || $this->blood_tga) {
            $this->blood_cholesterol_total = $this->blood_hdl + $this->blood_ldl;
            // $this->Findings();
            $f = FormulaDislipidemia::where('status', 'active')->first();

            $this->blood_dislipidemia = dislipidemia_status($this->blood_hdl, $this->blood_ldl, $this->blood_tga, $f);

            $employee = Employee::find($this->employee_id);

            if ($employee && $this->systolic_blood_pressure && $this->sports_per_week && $this->systolic_blood_pressure && $this->family_disease_history && $this->smoking && $this->bmi) {

                $gender = $employee->gender;
                $age = $employee->age;

                if (in_array('Diabetes', $this->family_disease_history)) {
                    $diabetes = 'yes';
                } else {
                    $diabetes = 'no';
                };

                $risk_by_sex_jc_score = risk_by_sex_jc_score($gender);
                $risk_by_age_jc_score = risk_by_age_jc_score($age);
                $risk_by_blood_pressure_jc_score = risk_by_blood_pressure_jc_score($age);
                $risk_by_bmi_jc_score = risk_by_bmi_jc_score($this->bmi);
                $risk_by_smoking_jc_score = risk_by_blood_pressure_jc_score($this->smoking);
                $risk_by_diabetes_melitus_jc_score = risk_by_diabetes_melitus_jc_score($diabetes);
                $risk_by_activity_jc_score = risk_by_activity_jc_score($this->sports_per_week);
                $this->jakarta_cardiovascular_score = $risk_by_sex_jc_score + $risk_by_age_jc_score + $risk_by_blood_pressure_jc_score + $risk_by_bmi_jc_score + $risk_by_smoking_jc_score + $risk_by_diabetes_melitus_jc_score + $risk_by_activity_jc_score;
                $this->jakarta_cardiovascular_risk_level = jc_risk_level($this->jakarta_cardiovascular_score);

                // Framingham Risk
                $risk_factor_framingham_score = risk_factor_framingham_score($gender, $age);
                $total_colesterol_framingham_score = total_colesterol_framingham_score($this->blood_cholesterol_total, $gender);
                $hdl_colesterol_framingham_score = hdl_colesterol_framingham_score($this->blood_hdl, $gender);
                $systolic_blood_framingham_score = systolic_blood_framingham_score($this->systolic_blood_pressure);
                $diabetes_melitus_framingham_score = diabetes_melitus_framingham_score($diabetes, $gender);
                $smoking_framingham_score = smoking_framingham_score($gender, $this->smoking);
                $this->framingham_score = $risk_factor_framingham_score + $total_colesterol_framingham_score + $hdl_colesterol_framingham_score + $systolic_blood_framingham_score + $diabetes_melitus_framingham_score + $smoking_framingham_score;
                $this->frammingham_risk_level = frammingham_risk_level($this->framingham_score);
            }
        }

    }
    public function BloodPressureStatus($s, $d)
    {
        $formula = FormulaBloodPressure::where('status', 'active')->first();

        $this->blood_pressure_status = blood_pressure_status($s, $d, $formula);
    }
    public function DislipidemiaStatus()
    {
        $f = FormulaDislipidemia::where('status', 'active')->first();

        $this->blood_dislipidemia = dislipidemia_status($this->blood_hdl, $this->blood_ldl, $this->blood_tga, $f);
    }
    public function HiperglikemiaStatus()
    {
        $this->blood_hyperglycemic = hiperglikemia_status($this->blood_g2pp);
    }

    public function eGFR($weight, $creatinin)
    {
        $employee = Employee::find($this->employee_id);
        $gender = $employee->gender;
        $age = $employee->age;

        $this->laboratory_uric_egfr = egfr_score($gender, $age, $weight, $creatinin);
    }

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function save()
    {
        // dd($this->mode);
        // try {
        if ($this->mode == 'draft') {
            $this->validate([
                'employee_id' => 'required',
                // 'mcu_date' => 'required',
            ]);
            $status = 'draft';
        } elseif ($this->mode == 'save') {
            $this->validate([
                'employee_id' => 'required',
                'mcu_date' => 'required',
                'complaint' => 'required',
                'previous_disease_history' => 'required',
                'family_disease_history' => 'required',
                'alergy' => 'required',
                'smoking' => 'required',
                'sports' => 'required',
                'alcohol' => 'required',
                'height' => 'required',
                'weight' => 'required',
                'systolic_blood_pressure' => 'required',
                'diastolic_blood_pressure' => 'required',
            ]);
            $status = null;
        }
        // $mcu = MedicalHistory::get();
        // $count_mcu = $mcu->count() + 1;
        if ($this->family_disease_history) {
            if (is_array($this->family_disease_history)) {
                $family_disease_history = implode(", ", $this->family_disease_history);
            } else {
                $family_disease_history = $this->family_disease_history;
            }
        } else {
            $family_disease_history = null;
        }
        if (!empty($this->xray_thorax)) {
            $xray_thorax = implode(", ", $this->xray_thorax);
        } else {
            $xray_thorax = null;
        }
        if (!empty($this->ekg)) {
            $ekg = implode(", ", $this->ekg);
        } else {
            $ekg = null;
        }

        $findings = findings($this->blood_cholesterol_total);

        $amc_matrix_compliance = "-"; //Sesuai /Tidak Sesuai
        // } else {
        // }

        $mcu_date = Carbon::parse($this->mcu_date);
        $mcu_exp_date = $mcu_date->addYear();

        $mcudata = [
            // 'id_number' => $count_mcu,
            'employee_id' => $this->employee_id,
            'staff_id' => 1,
            'doctor_id' => 1,
            // 'doctor_spesialist_id' => 1,
            'formula_blood_pressure_id' => $this->formula_blood_pressure_id,
            'formula_dislipidemia_id' => $this->formula_dislipidemia_id,
            'provider_id' => $this->provider_id,

            'medical_type' => $this->medical_type,
            'medical_ex_type' => $this->medical_ex_type,
            'mcu_date' => $mcu_date,
            'mcu_exp_date' => $mcu_exp_date,
            // 'mcu_review_date' => Carbon::now(),

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
            'ekg' => $ekg,
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
            'laboratory_urinalysis_feces_analysis' => $this->laboratory_urinalysis_feces_analysis,
            'laboratory_urinalysis_feces_culture' => $this->laboratory_urinalysis_feces_culture,

            // 'additional_exam' => $this->additional_exam,
            'findings' => $this->findings,
            'amc_matrix_compliance' => $amc_matrix_compliance,

            'doctor_status_review' => $status,
            // 'doctor_suggestion' => $this->doctor_suggestion,
            // 'doctor_certificate_number' => $this->doctor_certificate_number,
            // 'doctor_expiration' => $this->doctor_expiration,
            // 'doctor_remark' => $this->doctor_remark,
            // 'doctor_referral_diagnosis' => implode(", ", $this->doctor_referral_diagnosis),
        ];

        if ($this->mcu_id) {
            // MedicalHistory::create($mcudata);
            MedicalHistory::where('id', $this->mcu_id)->update($mcudata);
        } else {
            MedicalHistory::create($mcudata);
        }

        // $this->reset();

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            'text' => 'Data MCU berhasil di simpan',
        ]);

        session()->flash('msg', __('Data MCU Tersimpan'));
        session()->flash('alert', 'success');
        redirect()->route('mcu::medical-staff-list');

        // } catch (\Throwable$th) {
        //     session()->flash('msg', $th);
        //     session()->flash('alert', 'danger');
        // }
    }

    public function render()
    {
        return view('livewire.mcu.medical-staff.forms', ['staff' => Employee::find($this->staff_id), 'employee' => Employee::all()->except($this->staff_id)])->extends('layouts.no-header');
    }

}
