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
        Schema::create('audit_implementation_report_detail_auditors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('audit_implementation_report_detail_id');
            $table->foreign('audit_implementation_report_detail_id','audit_implementation_report_detailx')
                ->references('id')
                ->on('audit_implementation_report_details')->cascadeOnDelete();
            $table->foreignId('audit_team_role_id');
            $table->foreign('audit_team_role_id','audit_team_role_idx')
                ->references('id')
                ->on('audit_team_roles')->cascadeOnDelete();
            $table->foreignUuid('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name')->nullable();
            $table->string('registration_number')->nullable();
            $table->tinyInteger('phase')->nullable();
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
        Schema::dropIfExists('audit_implementation_report_detail_auditors');
    }
};
