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
        Schema::create('audit_implementation_activity_detail_schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('audit_implementation_activity_detail_id');
            $table->foreign('audit_implementation_activity_detail_id','implementation_detail_id_idx')->references('id')->on('audit_implementation_activity_details')->cascadeOnDelete();
            $table->time('start_time');
            $table->time('end_time');
            $table->string('title')->nullable();
            $table->text('location')->nullable();
            $table->string('auditee')->nullable();
            $table->string('method')->nullable();
            $table->text('description')->nullable();
            $table->string('auditor')->nullable();
            $table->string('schedule_activity_type')->nullable();
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
        Schema::dropIfExists('audit_implementation_activity_detail_schedules');
    }
};
