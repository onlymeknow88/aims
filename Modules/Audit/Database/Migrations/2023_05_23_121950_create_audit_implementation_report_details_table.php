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
        Schema::create('audit_implementation_report_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('audit_implementation_report_module_id');
            $table->foreign('audit_implementation_report_module_id','implementation_report_detail_idx')
                ->references('id')
                ->on('audit_implementation_report_modules')->cascadeOnDelete();
            $table->foreignUuid('company_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('permission_type')->nullable();
            $table->string('commodity_type')->nullable();
            $table->unsignedBigInteger('audit_risk_severity_id')->nullable();
            $table->foreign('audit_risk_severity_id','audit_risk_severity_id')->references('id')->on('audit_risk_severities')->nullOnDelete();
            $table->foreignId('audit_man_days_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('man_power')->default(0);
            $table->unsignedBigInteger('man_days')->default(0);
            $table->unsignedBigInteger('total_auditor')->default(0);
            $table->unsignedBigInteger('total_adjustment_factor')->default(0);
            $table->unsignedFloat('total_man_days')->default(0);
            $table->unsignedFloat('first_step_total_man_days')->default(0);
            $table->unsignedFloat('second_step_total_man_days')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('implementation_report_details');
    }
};
