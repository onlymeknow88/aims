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
        Schema::create('audit_sub_criteria_locations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('audit_location_id')->constrained()->cascadeOnDelete();
            $table->uuid('audit_sub_criteria_id');
            $table->foreign('audit_sub_criteria_id','audit_sub_criteria_locations_idx')
                ->references('id')
                ->on('audit_sub_criteria')
                ->cascadeOnDelete();
            $table->integer('point')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->nullable();

            //confirmance
            $table->text('fix_recommendation')->nullable();
            
            //non-confirmance
            $table->string('non_confirmance_number')->nullable();
            $table->text('problem_description')->nullable();
            $table->text('area_location_department')->nullable();
            $table->text('proof')->nullable();
            $table->text('non_confirmance_description')->nullable();
            $table->string('category')->nullable();
            $table->date('due_date')->nullable();
            $table->foreignUuid('audit_team_id')->constrained()->cascadeOnDelete();
            $table->date('auditor_date')->nullable();
            $table->string('auditee')->nullable();
            $table->date('auditee_date')->nullable();
            $table->text('root_cause_investigation')->nullable();
            $table->text('fix_action')->nullable();
            
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
        Schema::dropIfExists('audit_sub_criteria_locations');
    }
};
