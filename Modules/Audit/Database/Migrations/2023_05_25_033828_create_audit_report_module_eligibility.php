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
        Schema::create('audit_report_module_eligibility', function (Blueprint $table) {
            $table->uuid('audit_implementation_report_detail_id');
            $table->foreign('audit_implementation_report_detail_id','audit_implementation_report_detail_id_idx_4')
                ->references('id')
                ->on('audit_implementation_report_details')
                ->cascadeOnDelete();
            $table->unsignedBigInteger('audit_master_eligibility_id');
            $table->foreign('audit_master_eligibility_id','master_eligibility_id_idx_2')
                ->references('id')
                ->on('audit_master_eligibilities')
                ->cascadeOnDelete();
            $table->string('value')->nullable();
            $table->timestamps();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_report_module_eligibility');
    }
};
