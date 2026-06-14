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
            $table->foreignUuid('head_company_id')
                ->nullable()
                ->references('id')
                ->on('companies')
                ->cascadeOnDelete();
            $table->string('appointment_letter_number')->nullable();
            $table->date('letter_date')->nullable();
            $table->foreignUuid('audited_company_id')
                ->nullable()
                ->references('id')
                ->on('companies')
                ->cascadeOnDelete();

            $table->date('initial_contact_date')->nullable();
            $table->string('media')->nullable();
            $table->foreignUuid('auditi_delegation_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
            $table->string('auditi_delegation')->nullable();
            $table->string('auditi_delegation_position')->nullable();

            $table->date('determination_of_eligibility_date')->nullable();
            $table->string('organizational_profile')->nullable();
            $table->string('risk_profile')->nullable();
            $table->string('safety_performance_data')->nullable();
            $table->string('auditi_collaboration')->nullable();
            $table->string('time_availability')->nullable();
            $table->string('other_resources_availability')->nullable();
            $table->string('fulfillment_of_safety')->nullable();

            $table->foreignUuid('adequacy_company_id')
                ->nullable()
                ->references('id')
                ->on('companies')
                ->cascadeOnDelete();
            $table->string('element_1')->nullable();
            $table->string('element_2')->nullable();
            $table->string('element_3')->nullable();
            $table->string('element_4')->nullable();
            $table->string('element_5')->nullable();
            $table->string('element_6')->nullable();
            $table->string('element_7')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('implementation_report_details', function (Blueprint $table) {

        });
    }
};
