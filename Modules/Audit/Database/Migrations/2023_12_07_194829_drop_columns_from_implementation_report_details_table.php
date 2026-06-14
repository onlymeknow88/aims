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
            $table->dropForeign('audit_implementation_report_details_adequacy_company_id_foreign');
            $table->dropForeign('audit_implementation_report_details_audited_company_id_2_foreign');
            $table->dropForeign('audit_implementation_report_details_audited_company_id_foreign');
            $table->dropForeign('audit_implementation_report_details_head_2_company_id_foreign');
            $table->dropForeign('audit_implementation_report_details_head_company_id_foreign');
            $table->dropForeign('audit_implementation_report_details_responsible_id_foreign');
            $table->dropColumn('head_company_id');
            $table->dropColumn('appointment_letter_number');
            $table->dropColumn('letter_date');
            $table->dropColumn('audited_company_id');
            $table->dropColumn('team_name');
            $table->dropColumn('position');
            $table->dropColumn('registration_number');
            $table->dropColumn('proven_by');
            $table->dropColumn('responsible_id');
            $table->dropColumn('responsible_appointment_letter_number');
            $table->dropColumn('responsible_letter_date');

            $table->dropColumn('initial_contact_date');
            $table->dropColumn('media');
            $table->dropColumn('auditi_delegation');
            $table->dropColumn('auditi_delegation_position');

            $table->dropColumn('determination_of_eligibility_date');
            $table->dropColumn('organizational_profile');
            $table->dropColumn('risk_profile');
            $table->dropColumn('safety_performance_data');
            $table->dropColumn('auditi_collaboration');
            $table->dropColumn('time_availability');
            $table->dropColumn('other_resources_availability');
            $table->dropColumn('fulfillment_of_safety');

            $table->dropColumn('adequacy_company_id');
            $table->dropColumn('element_1');
            $table->dropColumn('element_2');
            $table->dropColumn('element_3');
            $table->dropColumn('element_4');
            $table->dropColumn('element_5');
            $table->dropColumn('element_6');
            $table->dropColumn('element_7');

            $table->dropColumn('head_2_company_id');
            $table->dropColumn('appointment_letter_number_2');
            $table->dropColumn('letter_date_2');
            $table->dropColumn('audited_company_id_2');
            $table->dropColumn('team_name_2');
            $table->dropColumn('position_2');
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
            $table->string('team_name')->nullable();
            $table->string('position')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('proven_by')->nullable();
            $table->foreignUuid('responsible_id')
                ->nullable()
                ->references('id')
                ->on('companies')
                ->cascadeOnDelete();
            $table->string('responsible_appointment_letter_number')->nullable();
            $table->date('responsible_letter_date')->nullable();

            $table->date('initial_contact_date')->nullable();
            $table->string('media')->nullable();
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

            $table->foreignUuid('head_2_company_id')
                ->nullable()
                ->references('id')
                ->on('companies')
                ->cascadeOnDelete();
            $table->string('appointment_letter_number_2')->nullable();
            $table->date('letter_date_2')->nullable();
            $table->foreignUuid('audited_company_id_2')
                ->nullable()
                ->references('id')
                ->on('companies')
                ->cascadeOnDelete();
            $table->string('team_name_2')->nullable();
            $table->string('position_2')->nullable();
        });
    }
};
