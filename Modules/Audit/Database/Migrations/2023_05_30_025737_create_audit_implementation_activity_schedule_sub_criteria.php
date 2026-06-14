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
        Schema::create('audit_implementation_activity_schedule_sub_criteria', function (Blueprint $table) {
            $table->uuid('audit_implementation_activity_detail_schedule_id');
            $table->foreign('audit_implementation_activity_detail_schedule_id','aias_idx')
                ->references('id')
                ->on('audit_implementation_activity_detail_schedules')
                ->cascadeOnDelete();

            $table->uuid('audit_sub_criteria_id');
            $table->foreign('audit_sub_criteria_id','asci_idx')
                ->references('id')
                ->on('audit_sub_criteria')
                ->cascadeOnDelete();

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
        Schema::dropIfExists('audit_implementation_activity_schedule_sub_criteria');
    }
};
