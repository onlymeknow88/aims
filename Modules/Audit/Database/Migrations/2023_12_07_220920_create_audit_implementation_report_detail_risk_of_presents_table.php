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
        Schema::create('audit_implementation_report_detail_risk_of_presents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('audit_implementation_report_detail_id');
            $table->foreign('audit_implementation_report_detail_id','audit_implementation_report_detail_riskx')
                ->references('id')
                ->on('audit_implementation_report_details')->cascadeOnDelete();
            $table->string('activity')->nullable();
            $table->string('risk')->nullable();
            $table->string('risk_value')->nullable();
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
        Schema::dropIfExists('audit_implementation_report_detail_risk_of_presents');
    }
};
