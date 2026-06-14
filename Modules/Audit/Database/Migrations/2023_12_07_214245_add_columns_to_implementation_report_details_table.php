<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audit_implementation_report_details', function (Blueprint $table) {
            $table->foreignUuid('audited_company_id_2')
                ->nullable()
                ->references('id')
                ->on('companies')
                ->cascadeOnDelete();
            $table->string('proven_by')->nullable();

            $table->string('company_form_number')->nullable();

            $table->year('risk_of_present_year')->nullable();
            $table->year('risk_of_future_year')->nullable();
            $table->year('trend_location_year')->nullable();
            $table->year('trend_activity_year')->nullable();
            $table->year('trend_position_year')->nullable();
            $table->year('trend_deviation_year')->nullable();
            $table->year('trend_factors_causing_year')->nullable();
            $table->year('mining_equipment_work_year')->nullable();
            $table->year('key_leading_indicator_year')->nullable();
            $table->year('internal_audit_year')->nullable();

            $table->string('data_audit_1')->nullable();
            $table->string('data_audit_2')->nullable();
            $table->string('data_audit_3')->nullable();
            $table->string('data_audit_4')->nullable();
            $table->string('data_audit_5')->nullable();

            $table->year('previous_period_year')->nullable();
            $table->year('internal_audit_verification_year')->nullable();
            $table->year('achievement_assessment_verification_year')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audit_implementation_report_details', function (Blueprint $table) {

        });
    }
};
