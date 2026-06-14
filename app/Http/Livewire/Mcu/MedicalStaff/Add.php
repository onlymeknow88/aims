<?php

namespace App\Http\Livewire\Mcu\MedicalStaff;

use App\Models\Employee;
use App\Models\Mcu\FormulaBloodPressure;
use App\Models\Mcu\FormulaDislipidemia;
use App\Models\Mcu\MedicalHistory;
use App\Models\Mcu\Provider;
use Carbon\Carbon;
use Livewire\Component;

class Add extends Component
{
    public $mode, $type, $provider, $employee_department, $employee_position, $employee_nip, $employee_id_number, $employee_name = '-', $employee_birthdate, $employee_age, $employee_gender, $status, $mcu_details;

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
    public $additional_exam, $findings, $amc_matrix_compliance;
    public $doctor_status_review, $doctor_suggestion, $doctor_certificate_number, $doctor_expiration, $doctor_remark;

    public function mount($type)
    {
        // $this->staff_id = 1;
        $this->type = $type;
        $this->mcu_date = Carbon::now()->format('d M Y');
        $this->mcu_exp_date = Carbon::now()->format('d M Y');
        $this->mcu_review_date = Carbon::now()->format('d M Y');
        $this->provider = Provider::get();

        // Dari default active setting formula
        $FormulaBloodPressure = FormulaBloodPressure::where('status', 'active')->first();
        $this->formula_blood_pressure_id = $FormulaBloodPressure->id;

        $FormulaDislipidemia = FormulaDislipidemia::where('status', 'active')->first();
        $this->formula_dislipidemia_id = $FormulaDislipidemia->id;

        // $this->mcu_details = view('livewire.mcu.medical-staff.forms');

    }

    public function updated($employee_id)
    {
        $e = Employee::find($this->$employee_id);
        if (!empty($e->name)) {
            $this->employee_department = $e->department;
            $this->employee_position = $e->position;
            $this->employee_nip = $e->number;
            $this->employee_id_number = $e->id_number;
            $this->employee_name = $e->name;
            $this->employee_birthdate = Carbon::parse($e->date_of_birth)->format('d M Y');
            $this->employee_age = Carbon::parse($e->date_of_birth)->age;

            $this->employee_gender = $e->gender;
        }
    }
    public function IdealFormula($height, $weight)
    {
        $employee = Employee::find($this->employee_id);
        $gender = $employee->gender;
        $this->bmi = imt_ideal($height, $weight);
        $this->bmi_lower = imt_ideal_limit($gender, $height, 'low');
        $this->bmi_upper = imt_ideal_limit($gender, $height, 'up');
        $this->nutritional_status = nutritional_status($this->bmi);
    }

    public function RiskScore()
    {
        if (($this->blood_hdl && $this->blood_ldl) || $this->blood_tga) {
            $this->blood_cholesterol_total = $this->blood_hdl + $this->blood_ldl;
            $this->Findings();
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

    public function Findings()
    {
        if ($this->blood_cholesterol_total) {
            $bct = "Kolesterol Total = " . $this->blood_cholesterol_total . " mg/dL";
        } else {
            $bct = "";
        }

        $this->findings = "" . $bct . "";
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
        } else {
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
            ]);
            $status = null;
        }
        // $mcu = MedicalHistory::get();
        // $count_mcu = $mcu->count() + 1;

        MedicalHistory::create(
            [
                // 'id_number' => $count_mcu,
                'employee_id' => $this->employee_id,
                'staff_id' => 1,
                'doctor_id' => 1,
                // 'doctor_spesialist_id' => 1,
                'formula_blood_pressure_id' => $this->formula_blood_pressure_id,
                'formula_dislipidemia_id' => $this->formula_dislipidemia_id,
                'provider_id' => $this->provider_id,

                'medical_type' => $this->medical_type,
                'mcu_date' => Carbon::now(),
                // 'mcu_exp_date' => Carbon::now(),
                // 'mcu_review_date' => Carbon::now(),

                'complaint' => $this->complaint,
                'previous_disease_history' => $this->previous_disease_history,
                'family_disease_history' => implode(", ", $this->family_disease_history),
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

                'xray_thorax' => implode(", ", $this->xray_thorax),
                'ekg' => implode(", ", $this->ekg),
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

                'additional_exam' => $this->additional_exam,
                'findings' => $this->findings,
                'amc_matrix_compliance' => $this->amc_matrix_compliance,

                'doctor_status_review' => $status,
                // 'doctor_suggestion' => $this->doctor_suggestion,
                // 'doctor_certificate_number' => $this->doctor_certificate_number,
                // 'doctor_expiration' => $this->doctor_expiration,
                // 'doctor_remark' => $this->doctor_remark,
                // 'doctor_referral_diagnosis' => implode(", ", $this->doctor_referral_diagnosis),
            ]
        );

        // $this->reset();

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Berhasil',
            'icon' => 'success',
            'text' => 'Data MCU berhasil di simpan',
        ]);

        session()->flash('msg', __('Data MCU Tersimpan'));
        session()->flash('alert', 'success');
        redirect()->route('mcu::medical-staff/' . $status);

        // } catch (\Throwable$th) {
        //     session()->flash('msg', $th);
        //     session()->flash('alert', 'danger');
        // }
    }

    public function render()
    {
        return view('livewire.mcu.medical-staff.add', ['staff' => Employee::find($this->staff_id), 'employee' => Employee::all()->except($this->staff_id)])->extends('layouts.no-header');
    }
}
