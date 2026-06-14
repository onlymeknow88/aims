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
        Schema::create('pica_documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('source');
            $table->string('type')->nullable();
            $table->date('date')->nullable();
            $table->uuid('ccow_id')->nullable();
            $table->uuid('company_id')->nullable();
            $table->uuid('section_id')->nullable();
            $table->uuid('location_id')->nullable();
            $table->string('location_detail')->nullable();
            $table->string('company_detail')->nullable();
            $table->uuid('pja_id')->nullable();
            $table->uuid('pjo_id')->nullable();
            $table->string('auditor')->nullable();
            $table->text('non_compliance')->nullable();
            $table->text('non_compliance_root_cause')->nullable();
            $table->text('corrective_action')->nullable();
            $table->date('target_settlement_date')->nullable();
            $table->date('settlement_date')->nullable();
            $table->string('remarks')->nullable();


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
        Schema::dropIfExists('pica_documents');
    }
};
