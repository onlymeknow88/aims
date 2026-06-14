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
        Schema::table('mcu_medical_history', function (Blueprint $table) {

            $table->after('ekg', function ($table) {
                $table->text('ekg_note')->nullable();
            });

            $table->after('xray_thorax', function ($table) {
                $table->text('xray_thorax_note')->nullable();
            });

            $table->decimal('bmi_lower')->nullable()->change();
            $table->decimal('bmi_upper')->nullable()->change();
            // $table->decimal('systolic_blood_pressure')->nullable()->change();
            // $table->decimal('diastolic_blood_pressure')->nullable()->change();
            // $table->decimal('arteries')->nullable()->change();
            // $table->decimal('rr')->nullable()->change();
            // $table->decimal('body_temperature')->nullable()->change();

            // $table->decimal('audiometry_right_air_conduction_500')->nullable()->change();
            // $table->decimal('audiometry_right_air_conduction_1000')->nullable()->change();
            // $table->decimal('audiometry_right_air_conduction_2000')->nullable()->change();
            // $table->decimal('audiometry_right_air_conduction_3000')->nullable()->change();
            // $table->decimal('audiometry_right_air_conduction_4000')->nullable()->change();
            // $table->decimal('audiometry_right_air_conduction_6000')->nullable()->change();
            // $table->decimal('audiometry_right_air_conduction_8000')->nullable()->change();
            // $table->decimal('audiometry_right_air_conduction_htl')->nullable()->change();
            // $table->decimal('audiometry_right_bone_conduction_500')->nullable()->change();
            // $table->decimal('audiometry_right_bone_conduction_1000')->nullable()->change();
            // $table->decimal('audiometry_right_bone_conduction_2000')->nullable()->change();
            // $table->decimal('audiometry_right_bone_conduction_3000')->nullable()->change();
            // $table->decimal('audiometry_right_bone_conduction_4000')->nullable()->change();
            // $table->decimal('audiometry_right_bone_conduction_6000')->nullable()->change();
            // $table->decimal('audiometry_right_bone_conduction_8000')->nullable()->change();
            // $table->decimal('audiometry_right_bone_conduction_htl')->nullable()->change();

            // $table->decimal('audiometry_left_air_conduction_500')->nullable()->change();
            // $table->decimal('audiometry_left_air_conduction_1000')->nullable()->change();
            // $table->decimal('audiometry_left_air_conduction_2000')->nullable()->change();
            // $table->decimal('audiometry_left_air_conduction_3000')->nullable()->change();
            // $table->decimal('audiometry_left_air_conduction_4000')->nullable()->change();
            // $table->decimal('audiometry_left_air_conduction_6000')->nullable()->change();
            // $table->decimal('audiometry_left_air_conduction_8000')->nullable()->change();
            // $table->decimal('audiometry_left_air_conduction_htl')->nullable()->change();
            // $table->decimal('audiometry_left_bone_conduction_500')->nullable()->change();
            // $table->decimal('audiometry_left_bone_conduction_1000')->nullable()->change();
            // $table->decimal('audiometry_left_bone_conduction_2000')->nullable()->change();
            // $table->decimal('audiometry_left_bone_conduction_3000')->nullable()->change();
            // $table->decimal('audiometry_left_bone_conduction_4000')->nullable()->change();
            // $table->decimal('audiometry_left_bone_conduction_6000')->nullable()->change();
            // $table->decimal('audiometry_left_bone_conduction_8000')->nullable()->change();
            // $table->decimal('audiometry_left_bone_conduction_htl')->nullable()->change();

            // $table->decimal('blood_leukosit')->nullable()->change();
            // $table->decimal('blood_thrombosit')->nullable()->change();

            // $table->decimal('blood_led')->nullable()->change();

            // $table->decimal('blood_sgot')->nullable()->change();
            // $table->decimal('blood_sgpt')->nullable()->change();
            // $table->decimal('blood_gamma_gt')->nullable()->change();
            // $table->decimal('blood_cholesterol_total')->nullable()->change();
            // $table->decimal('blood_hdl')->nullable()->change();
            // $table->decimal('blood_ldl')->nullable()->change();
            // $table->decimal('blood_tga')->nullable()->change();

            // $table->decimal('blood_billirubin_direk')->nullable()->change();
            // $table->decimal('blood_billirubin_indirek')->nullable()->change();

            $table->decimal('blood_gdpt')->nullable()->change();
            $table->decimal('blood_g2pp')->nullable()->change();

            $table->decimal('blood_hba1c')->nullable()->change();

            $table->decimal('laboratory_ureum')->nullable()->change();
            $table->decimal('laboratory_bun')->nullable()->change();
            $table->decimal('laboratory_creatinin')->nullable()->change();
            $table->decimal('laboratory_uric_acid')->nullable()->change();
            $table->decimal('laboratory_uric_egfr')->nullable()->change();

            // $table->decimal('laboratory_urinalysis_leukocyte_sediment')->nullable()->change();
            // $table->decimal('laboratory_urinalysis_erythrocyte')->nullable()->change();
            // $table->decimal('laboratory_urinalysis_epitel')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
