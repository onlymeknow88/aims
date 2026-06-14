<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_criteria_non_confirmances', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('audit_sub_criteria_id')->constrained('audit_sub_criteria')->cascadeOnDelete();
            $table->string('non_confirmance_number')->nullable();
            $table->text('problem_description')->nullable();
            $table->text('area_location_department')->nullable();
            $table->text('proof')->nullable();
            $table->text('non_confirmance_description')->nullable();
            $table->string('category')->nullable();
            $table->date('due_date')->nullable();
            $table->foreignUuid('audit_smkp_team_id')->nullable()->constrained()->nullOnDelete();
            $table->date('auditor_date')->nullable();
            $table->string('auditee')->nullable();
            $table->date('auditee_date')->nullable();
            $table->text('root_cause_investigation')->nullable();
            $table->text('fix_action')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('audit_criteria_non_confirmances');
    }
};
