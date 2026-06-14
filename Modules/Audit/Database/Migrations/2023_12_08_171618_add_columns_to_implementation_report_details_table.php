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
            $table->string('sampling_plan_number')->nullable();

            $table->string('audit_conformity_number')->nullable();
            $table->string('audit_non_conformity_number')->nullable();
            $table->string('non_conformity_recapitulation_number')->nullable();
            $table->string('follow_up_plan_number')->nullable();
            $table->string('recommendation_number')->nullable();

            $table->string('meeting_recording_number')->nullable();

            $table->date('initial_implementation_date')->nullable();
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
