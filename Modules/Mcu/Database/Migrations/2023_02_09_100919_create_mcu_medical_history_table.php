<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcu_medical_history', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('employee_id')
                ->references('id')
                ->on('employees')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignUuid('staff_id')
                ->nullable()
                ->references('id')
                ->on('employees')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignUuid('doctor_id')
                ->nullable()
                ->references('id')
                ->on('employees')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('doctor_spesialist_id')
                ->nullable()
                ->references('id')
                ->on('mcu_doctor')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('formula_blood_pressure_id')
                ->nullable()
                ->references('id')
                ->on('mcu_formula_blood_pressure')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('formula_dislipidemia_id')
                ->nullable()
                ->references('id')
                ->on('mcu_formula_dislipidemia')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('provider_id')
                ->nullable()
                ->references('id')
                ->on('mcu_provider')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->text('medical_ex_type')->nullable();
            $table->text('medical_type')->nullable();
            $table->date('mcu_date')->nullable();
            $table->dateTime('mcu_exp_date')->nullable();
            $table->dateTime('mcu_review_date')->nullable();

            $table->text('complaint')->nullable();
            $table->text('previous_disease_history')->nullable();
            $table->text('family_disease_history')->nullable();
            $table->text('alergy')->nullable();
            $table->text('smoking')->nullable();
            $table->integer('smoking_per_day')->nullable();
            $table->text('sports')->nullable();
            $table->text('sports_per_week')->nullable();
            $table->text('sports_type')->nullable();
            $table->text('alcohol')->nullable();

            $table->text('menstrual_menarche')->nullable();
            $table->text('menstrual_cycle')->nullable();
            $table->text('menstrual_pain')->nullable();
            $table->integer('menstrual_period')->nullable();
            $table->integer('pregnant_period')->nullable();
            $table->integer('pregnant_spontan')->nullable();
            $table->integer('pregnant_surgery')->nullable();
            $table->integer('pregnant_abortion')->nullable();
            $table->text('contraception')->nullable();
            $table->text('contraception_type')->nullable();

            $table->text('previous_job')->nullable();
            $table->text('current_job')->nullable();
            $table->text('current_job_details')->nullable();

            $table->text('vaccination_hep_a1')->nullable();
            $table->text('vaccination_hep_a2')->nullable();
            $table->text('vaccination_hep_a3')->nullable();
            $table->text('vaccination_typhoid_1')->nullable();
            $table->text('vaccination_typhoid_3')->nullable();
            $table->text('vaccination_albendandazole')->nullable();

            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('bmi')->nullable();
            $table->text('nutritional_status')->nullable();
            $table->integer('bmi_lower')->nullable();
            $table->integer('bmi_upper')->nullable();
            $table->integer('systolic_blood_pressure')->nullable();
            $table->integer('diastolic_blood_pressure')->nullable();
            $table->integer('arteries')->nullable();
            $table->integer('rr')->nullable();
            $table->integer('body_temperature')->nullable();
            $table->text('blood_pressure_status')->nullable();
            $table->text('heent')->nullable();
            $table->text('orodental_caries')->nullable();
            $table->text('orodental_gangren_radix')->nullable();
            $table->text('cardiovascular_system')->nullable();
            $table->text('respiratorus_system')->nullable();
            $table->text('digestivus_system')->nullable();
            $table->text('genitounrinarius_system')->nullable();
            $table->text('neuromuscular_system')->nullable();
            $table->text('fitness_test')->nullable();

            $table->text('visus_non_correction_od')->nullable();
            $table->text('visus_non_correction_os')->nullable();
            $table->text('visus_non_correction_ods')->nullable();
            $table->text('visus_correction_od')->nullable();
            $table->text('visus_correction_os')->nullable();
            $table->text('visus_correction_ods')->nullable();
            $table->text('visus_impression')->nullable();
            $table->text('visus_reading_test')->nullable();
            $table->text('visus_color_blind')->nullable();
            $table->text('visus_field_of_view')->nullable();
            $table->text('visus_notes')->nullable();

            $table->integer('audiometry_right_air_conduction_500')->nullable();
            $table->integer('audiometry_right_air_conduction_1000')->nullable();
            $table->integer('audiometry_right_air_conduction_2000')->nullable();
            $table->integer('audiometry_right_air_conduction_3000')->nullable();
            $table->integer('audiometry_right_air_conduction_4000')->nullable();
            $table->integer('audiometry_right_air_conduction_6000')->nullable();
            $table->integer('audiometry_right_air_conduction_8000')->nullable();
            $table->integer('audiometry_right_air_conduction_htl')->nullable();
            $table->integer('audiometry_right_bone_conduction_500')->nullable();
            $table->integer('audiometry_right_bone_conduction_1000')->nullable();
            $table->integer('audiometry_right_bone_conduction_2000')->nullable();
            $table->integer('audiometry_right_bone_conduction_3000')->nullable();
            $table->integer('audiometry_right_bone_conduction_4000')->nullable();
            $table->integer('audiometry_right_bone_conduction_6000')->nullable();
            $table->integer('audiometry_right_bone_conduction_8000')->nullable();
            $table->integer('audiometry_right_bone_conduction_htl')->nullable();

            $table->integer('audiometry_left_air_conduction_500')->nullable();
            $table->integer('audiometry_left_air_conduction_1000')->nullable();
            $table->integer('audiometry_left_air_conduction_2000')->nullable();
            $table->integer('audiometry_left_air_conduction_3000')->nullable();
            $table->integer('audiometry_left_air_conduction_4000')->nullable();
            $table->integer('audiometry_left_air_conduction_6000')->nullable();
            $table->integer('audiometry_left_air_conduction_8000')->nullable();
            $table->integer('audiometry_left_air_conduction_htl')->nullable();
            $table->integer('audiometry_left_bone_conduction_500')->nullable();
            $table->integer('audiometry_left_bone_conduction_1000')->nullable();
            $table->integer('audiometry_left_bone_conduction_2000')->nullable();
            $table->integer('audiometry_left_bone_conduction_3000')->nullable();
            $table->integer('audiometry_left_bone_conduction_4000')->nullable();
            $table->integer('audiometry_left_bone_conduction_6000')->nullable();
            $table->integer('audiometry_left_bone_conduction_8000')->nullable();
            $table->integer('audiometry_left_bone_conduction_htl')->nullable();

            $table->text('audiometry_conclusion')->nullable();
            $table->text('audiometry_impression')->nullable();

            $table->decimal('spirometry_fvc', 5, 2)->nullable();
            $table->decimal('spirometry_fev1', 5, 2)->nullable();
            $table->text('spirometry_impression')->nullable();

            $table->text('xray_thorax')->nullable();
            $table->text('ekg')->nullable();
            $table->text('treadmill')->nullable();
            $table->text('echocardiography')->nullable();
            $table->text('additional_diagnosis')->nullable();

            $table->decimal('blood_hb', 5, 2)->nullable();
            $table->decimal('blood_ht', 5, 2)->nullable();
            $table->integer('blood_leukosit')->nullable();
            $table->integer('blood_thrombosit')->nullable();
            $table->decimal('blood_eritrosit', 5, 2)->nullable();
            $table->integer('blood_led')->nullable();
            $table->text('blood_type')->nullable();
            $table->text('blood_rhesus')->nullable();
            $table->integer('blood_sgot')->nullable();
            $table->integer('blood_sgpt')->nullable();
            $table->integer('blood_gamma_gt')->nullable();
            $table->integer('blood_cholesterol_total')->nullable();
            $table->integer('blood_hdl')->nullable();
            $table->integer('blood_ldl')->nullable();
            $table->integer('blood_tga')->nullable();
            $table->text('blood_billirubin_total')->nullable();
            $table->integer('blood_billirubin_direk')->nullable();
            $table->integer('blood_billirubin_indirek')->nullable();
            $table->text('blood_dislipidemia')->nullable();
            $table->integer('blood_gdpt')->nullable();
            $table->integer('blood_g2pp')->nullable();
            $table->text('blood_hyperglycemic')->nullable();
            $table->integer('blood_hba1c')->nullable();
            $table->text('blood_dm_status')->nullable();

            $table->decimal('jakarta_cardiovascular_score', 5, 2)->nullable();
            $table->text('jakarta_cardiovascular_risk_level')->nullable();
            $table->decimal('framingham_score', 5, 2)->nullable();
            $table->text('frammingham_risk_level')->nullable();

            $table->integer('laboratory_ureum')->nullable();
            $table->integer('laboratory_bun')->nullable();
            $table->integer('laboratory_creatinin')->nullable();
            $table->integer('laboratory_uric_acid')->nullable();
            $table->integer('laboratory_uric_egfr')->nullable();
            $table->text('laboratory_hbsag')->nullable();
            $table->text('laboratory_anti_hbs')->nullable();
            $table->text('laboratory_anti_havlgm')->nullable();
            $table->text('laboratory_widal')->nullable();
            $table->text('laboratory_malary')->nullable();
            $table->text('laboratory_urinalysis_color')->nullable();
            $table->text('laboratory_urinalysis_clarity')->nullable();
            $table->decimal('laboratory_urinalysis_ph', 5, 2)->nullable();
            $table->decimal('laboratory_urinalysis_density', 5, 2)->nullable();
            $table->text('laboratory_urinalysis_protein')->nullable();
            $table->text('laboratory_urinalysis_glucose')->nullable();
            $table->text('laboratory_urinalysis_billirubin')->nullable();
            $table->text('laboratory_urinalysis_urobillin')->nullable();
            $table->text('laboratory_urinalysis_keton')->nullable();
            $table->text('laboratory_urinalysis_blood')->nullable();
            $table->text('laboratory_urinalysis_lekositesterase')->nullable();
            $table->text('laboratory_urinalysis_nitrit')->nullable();
            $table->integer('laboratory_urinalysis_leukocyte_sediment')->nullable();
            $table->integer('laboratory_urinalysis_erythrocyte')->nullable();
            $table->integer('laboratory_urinalysis_epitel')->nullable();
            $table->text('laboratory_urinalysis_cylinder')->nullable();
            $table->text('laboratory_urinalysis_crystal')->nullable();
            $table->text('laboratory_urinalysis_bacteria')->nullable();
            $table->text('laboratory_urinalysis_etc')->nullable();

            $table->text('laboratory_urinalysis_amp')->nullable();
            $table->text('laboratory_urinalysis_met')->nullable();
            $table->text('laboratory_urinalysis_bdz')->nullable();
            $table->text('laboratory_urinalysis_coc')->nullable();
            $table->text('laboratory_urinalysis_opi')->nullable();
            $table->text('laboratory_urinalysis_thc')->nullable();
            $table->text('laboratory_urinalysis_feces_analysis')->nullable();
            $table->text('laboratory_urinalysis_feces_culture')->nullable();

            $table->text('additional_exam')->nullable();
            $table->text('findings')->nullable();
            $table->text('amc_matrix_compliance')->nullable();

            $table->text('doctor_status_review')->nullable();
            $table->text('doctor_suggestion')->nullable();
            $table->text('doctor_certificate_number')->nullable();
            $table->text('doctor_expiration')->nullable();
            $table->text('doctor_remark')->nullable();
            $table->text('doctor_referral_diagnosis')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mcu_medical_history');
    }
};
