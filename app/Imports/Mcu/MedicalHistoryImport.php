<?php

namespace App\Imports\Mcu;

use App\Models\Employee;
use App\Models\Mcu\FormulaBloodPressure;
use App\Models\Mcu\FormulaDislipidemia;
use App\Models\Mcu\MedicalHistory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class MedicalHistoryImport implements ToModel, WithValidation, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    use Importable;

    public function model(array $row)
    {
        // if (!isset($row[0])) {
        //     return null;
        // }
        // dd(date::excelToDateTimeObject($row['mcu_date']));
        // dd(Carbon::createFromFormat('d/m/Y', $row['tanggal'])->format('Y-m-d'));
        // parse($row['tanggal'])->format('d M Y , H:m:s')
        // $count_mcu = MedicalHistory::get()->count() + 1;
        // $id_number = $count_mcu++;
        $employee = Employee::where('id_number', $row['id_number'])->first();
        $staff_id = 1; // asline seko session id

        $FormulaBloodPressure = FormulaBloodPressure::where('status', 'active')->first();
        $formula_blood_pressure_id = $FormulaBloodPressure->id;

        $FormulaDislipidemia = FormulaDislipidemia::where('status', 'active')->first();
        $formula_dislipidemia_id = $FormulaDislipidemia->id;

        // return (string) Str::uuid();
        // return (string) Str::orderedUuid();

        return new MedicalHistory([
            'id' => Str::orderedUuid(),
            // 'id_number' => $id_number,
            'employee_id' => $employee->id,
            'staff_id' => $staff_id,
            // 'doctor_id' => $doctor_id,
            // 'doctor_spesialist_id' => 1,
            'formula_blood_pressure_id' => $formula_blood_pressure_id,
            'formula_dislipidemia_id' => $formula_dislipidemia_id,
            'provider_id' => $row['provider_id'],

            'medical_type' => $row['medical_type'],
            'mcu_date' => $row['mcu_date'],
            // 'mcu_date' => Carbon::now(),
            // 'mcu_exp_date' => Carbon::now(),
            // 'mcu_review_date' => Carbon::now(),

            'complaint' => $row['complaint'],
            'previous_disease_history' => $row['previous_disease_history'],
            'family_disease_history' => $row['family_disease_history'],
            'alergy' => $row['alergy'],
            'smoking' => $row['smoking'],
            'smoking_per_day' => $row['smoking_per_day'],
            'sports' => $row['sports'],
            'sports_per_week' => $row['sports_per_week'],
            'sports_type' => $row['sports_type'],
            'alcohol' => $row['alcohol'],

            'menstrual_menarche' => $row['menstrual_menarche'],
            'menstrual_cycle' => $row['menstrual_cycle'],
            'menstrual_pain' => $row['menstrual_pain'],
            'menstrual_period' => $row['menstrual_period'],
            'pregnant_period' => $row['pregnant_period'],
            'pregnant_spontan' => $row['pregnant_spontan'],
            'pregnant_surgery' => $row['pregnant_surgery'],
            'pregnant_abortion' => $row['pregnant_abortion'],
            'contraception' => $row['contraception'],
            'contraception_type' => $row['contraception_type'],

            'current_job' => $row['current_job'],
            'previous_job' => $row['previous_job'],
            'current_job_details' => $row['current_job_details'],

            'vaccination_hep_a1' => $row['vaccination_hep_a1'],
            'vaccination_hep_a2' => $row['vaccination_hep_a2'],
            'vaccination_hep_a3' => $row['vaccination_hep_a3'],
            'vaccination_typhoid_1' => $row['vaccination_typhoid_1'],
            'vaccination_typhoid_3' => $row['vaccination_typhoid_3'],
            'vaccination_albendandazole' => $row['vaccination_albendandazole'],

            'height' => $row['height'],
            'weight' => $row['weight'],
            'bmi' => $row['bmi'],
            'nutritional_status' => $row['nutritional_status'],
            'bmi_lower' => $row['bmi_lower'],
            'bmi_upper' => $row['bmi_upper'],
            'systolic_blood_pressure' => $row['systolic_blood_pressure'],
            'diastolic_blood_pressure' => $row['diastolic_blood_pressure'],
            'arteries' => $row['arteries'],
            'rr' => $row['rr'],
            'body_temperature' => $row['body_temperature'],
            'blood_pressure_status' => $row['blood_pressure_status'],
            'heent' => $row['heent'],
            'orodental_caries' => $row['orodental_caries'],
            'orodental_gangren_radix' => $row['orodental_gangren_radix'],
            'cardiovascular_system' => $row['cardiovascular_system'],
            'respiratorus_system' => $row['respiratorus_system'],
            'digestivus_system' => $row['digestivus_system'],
            'genitounrinarius_system' => $row['genitounrinarius_system'],
            'neuromuscular_system' => $row['neuromuscular_system'],
            'fitness_test' => $row['fitness_test'],

            'visus_non_correction_od' => $row['visus_non_correction_od'],
            'visus_non_correction_os' => $row['visus_non_correction_os'],
            'visus_non_correction_ods' => $row['visus_non_correction_ods'],
            'visus_correction_od' => $row['visus_correction_od'],
            'visus_correction_os' => $row['visus_correction_os'],
            'visus_correction_ods' => $row['visus_correction_ods'],
            'visus_impression' => $row['visus_impression'],
            'visus_reading_test' => $row['visus_reading_test'],
            'visus_color_blind' => $row['visus_color_blind'],
            'visus_field_of_view' => $row['visus_field_of_view'],
            'visus_notes' => $row['visus_notes'],

            'audiometry_right_air_conduction_500' => $row['audiometry_right_air_conduction_500'],
            'audiometry_right_air_conduction_1000' => $row['audiometry_right_air_conduction_1000'],
            'audiometry_right_air_conduction_2000' => $row['audiometry_right_air_conduction_2000'],
            'audiometry_right_air_conduction_3000' => $row['audiometry_right_air_conduction_3000'],
            'audiometry_right_air_conduction_4000' => $row['audiometry_right_air_conduction_4000'],
            'audiometry_right_air_conduction_6000' => $row['audiometry_right_air_conduction_6000'],
            'audiometry_right_air_conduction_8000' => $row['audiometry_right_air_conduction_8000'],
            'audiometry_right_air_conduction_htl' => $row['audiometry_right_air_conduction_htl'],
            'audiometry_right_bone_conduction_500' => $row['audiometry_right_bone_conduction_500'],
            'audiometry_right_bone_conduction_1000' => $row['audiometry_right_bone_conduction_1000'],
            'audiometry_right_bone_conduction_2000' => $row['audiometry_right_bone_conduction_2000'],
            'audiometry_right_bone_conduction_3000' => $row['audiometry_right_bone_conduction_3000'],
            'audiometry_right_bone_conduction_4000' => $row['audiometry_right_bone_conduction_4000'],
            'audiometry_right_bone_conduction_6000' => $row['audiometry_right_bone_conduction_6000'],
            'audiometry_right_bone_conduction_8000' => $row['audiometry_right_bone_conduction_8000'],
            'audiometry_right_bone_conduction_htl' => $row['audiometry_right_bone_conduction_htl'],

            'audiometry_left_air_conduction_500' => $row['audiometry_left_air_conduction_500'],
            'audiometry_left_air_conduction_1000' => $row['audiometry_left_air_conduction_1000'],
            'audiometry_left_air_conduction_2000' => $row['audiometry_left_air_conduction_2000'],
            'audiometry_left_air_conduction_3000' => $row['audiometry_left_air_conduction_3000'],
            'audiometry_left_air_conduction_4000' => $row['audiometry_left_air_conduction_4000'],
            'audiometry_left_air_conduction_6000' => $row['audiometry_left_air_conduction_6000'],
            'audiometry_left_air_conduction_8000' => $row['audiometry_left_air_conduction_8000'],
            'audiometry_left_air_conduction_htl' => $row['audiometry_left_air_conduction_htl'],
            'audiometry_left_bone_conduction_500' => $row['audiometry_left_bone_conduction_500'],
            'audiometry_left_bone_conduction_1000' => $row['audiometry_left_bone_conduction_1000'],
            'audiometry_left_bone_conduction_2000' => $row['audiometry_left_bone_conduction_2000'],
            'audiometry_left_bone_conduction_3000' => $row['audiometry_left_bone_conduction_3000'],
            'audiometry_left_bone_conduction_4000' => $row['audiometry_left_bone_conduction_4000'],
            'audiometry_left_bone_conduction_6000' => $row['audiometry_left_bone_conduction_6000'],
            'audiometry_left_bone_conduction_8000' => $row['audiometry_left_bone_conduction_8000'],
            'audiometry_left_bone_conduction_htl' => $row['audiometry_left_bone_conduction_htl'],

            'audiometry_conclusion' => $row['audiometry_conclusion'],
            'audiometry_impression' => $row['audiometry_impression'],

            'spirometry_fvc' => $row['spirometry_fvc'],
            'spirometry_fev1' => $row['spirometry_fev1'],
            'spirometry_impression' => $row['spirometry_impression'],

            'xray_thorax' => $row['xray_thorax'],
            'ekg' => $row['ekg'],
            'treadmill' => $row['treadmill'],
            'echocardiography' => $row['echocardiography'],
            'additional_diagnosis' => $row['additional_diagnosis'],

            'blood_hb' => $row['blood_hb'],
            'blood_ht' => $row['blood_ht'],
            'blood_leukosit' => $row['blood_leukosit'],
            'blood_thrombosit' => $row['blood_thrombosit'],
            'blood_eritrosit' => $row['blood_eritrosit'],
            'blood_led' => $row['blood_led'],
            'blood_type' => $row['blood_type'],
            'blood_rhesus' => $row['blood_rhesus'],
            'blood_sgot' => $row['blood_sgot'],
            'blood_sgpt' => $row['blood_sgpt'],
            'blood_gamma_gt' => $row['blood_gamma_gt'],
            'blood_cholesterol_total' => $row['blood_cholesterol_total'],
            'blood_hdl' => $row['blood_hdl'],
            'blood_ldl' => $row['blood_ldl'],
            'blood_tga' => $row['blood_tga'],
            'blood_billirubin_total' => $row['blood_billirubin_total'],
            'blood_billirubin_direk' => $row['blood_billirubin_direk'],
            'blood_billirubin_indirek' => $row['blood_billirubin_indirek'],
            'blood_dislipidemia' => $row['blood_dislipidemia'],
            'blood_gdpt' => $row['blood_gdpt'],
            'blood_g2pp' => $row['blood_g2pp'],
            'blood_hyperglycemic' => $row['blood_hyperglycemic'],
            'blood_hba1c' => $row['blood_hba1c'],
            'blood_dm_status' => $row['blood_dm_status'],

            'jakarta_cardiovascular_score' => $row['jakarta_cardiovascular_score'],
            'jakarta_cardiovascular_risk_level' => $row['jakarta_cardiovascular_risk_level'],
            'framingham_score' => $row['framingham_score'],
            'frammingham_risk_level' => $row['frammingham_risk_level'],

            'laboratory_ureum' => $row['laboratory_ureum'],
            'laboratory_bun' => $row['laboratory_bun'],
            'laboratory_creatinin' => $row['laboratory_creatinin'],
            'laboratory_uric_acid' => $row['laboratory_uric_acid'],
            'laboratory_uric_egfr' => $row['laboratory_uric_egfr'],
            'laboratory_hbsag' => $row['laboratory_hbsag'],
            'laboratory_anti_hbs' => $row['laboratory_anti_hbs'],
            'laboratory_anti_havlgm' => $row['laboratory_anti_havlgm'],
            'laboratory_widal' => $row['laboratory_widal'],
            'laboratory_malary' => $row['laboratory_malary'],
            'laboratory_urinalysis_color' => $row['laboratory_urinalysis_color'],
            'laboratory_urinalysis_clarity' => $row['laboratory_urinalysis_clarity'],
            'laboratory_urinalysis_ph' => $row['laboratory_urinalysis_ph'],
            'laboratory_urinalysis_density' => $row['laboratory_urinalysis_density'],
            'laboratory_urinalysis_protein' => $row['laboratory_urinalysis_protein'],
            'laboratory_urinalysis_glucose' => $row['laboratory_urinalysis_glucose'],
            'laboratory_urinalysis_billirubin' => $row['laboratory_urinalysis_billirubin'],
            'laboratory_urinalysis_urobillin' => $row['laboratory_urinalysis_urobillin'],
            'laboratory_urinalysis_keton' => $row['laboratory_urinalysis_keton'],
            'laboratory_urinalysis_blood' => $row['laboratory_urinalysis_blood'],
            'laboratory_urinalysis_lekositesterase' => $row['laboratory_urinalysis_lekositesterase'],
            'laboratory_urinalysis_nitrit' => $row['laboratory_urinalysis_nitrit'],
            'laboratory_urinalysis_leukocyte_sediment' => $row['laboratory_urinalysis_leukocyte_sediment'],
            'laboratory_urinalysis_erythrocyte' => $row['laboratory_urinalysis_erythrocyte'],
            'laboratory_urinalysis_epitel' => $row['laboratory_urinalysis_epitel'],
            'laboratory_urinalysis_cylinder' => $row['laboratory_urinalysis_cylinder'],
            'laboratory_urinalysis_crystal' => $row['laboratory_urinalysis_crystal'],
            'laboratory_urinalysis_bacteria' => $row['laboratory_urinalysis_bacteria'],
            'laboratory_urinalysis_etc' => $row['laboratory_urinalysis_etc'],

            'laboratory_urinalysis_amp' => $row['laboratory_urinalysis_amp'],
            'laboratory_urinalysis_met' => $row['laboratory_urinalysis_met'],
            'laboratory_urinalysis_bdz' => $row['laboratory_urinalysis_bdz'],
            'laboratory_urinalysis_coc' => $row['laboratory_urinalysis_coc'],
            'laboratory_urinalysis_opi' => $row['laboratory_urinalysis_opi'],
            'laboratory_urinalysis_thc' => $row['laboratory_urinalysis_thc'],
            'laboratory_urinalysis_feces_analysis' => $row['laboratory_urinalysis_feces_analysis'],
            'laboratory_urinalysis_feces_culture' => $row['laboratory_urinalysis_feces_culture'],

            'additional_exam' => $row['additional_exam'],
            'findings' => $row['findings'],
            'amc_matrix_compliance' => $row['amc_matrix_compliance'],

            'doctor_status_review' => null,

            // 'doctor_suggestion' => $doctor_suggestion,
            // 'doctor_certificate_number' => $doctor_certificate_number,
            // 'doctor_expiration' => $doctor_expiration,
            // 'doctor_remark' => $doctor_remark,
            // 'doctor_referral_diagnosis' => implode(", ", $doctor_referral_diagnosis),
        ]);
    }
    public function rules(): array
    {
        return [
            '*.id_number' => 'required',
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }
    public function chunkSize(): int
    {
        return 1000;
    }

}
