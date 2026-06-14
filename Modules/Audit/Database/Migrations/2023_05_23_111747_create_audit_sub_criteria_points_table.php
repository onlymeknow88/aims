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
        Schema::create('audit_sub_criteria_points', function (Blueprint $table) {
            $table->foreignUuid('id')->primary();
            $table->uuid('audit_sub_criteria_id');
            $table->foreign('audit_sub_criteria_id','audit_point_sub_criteria_id_idx')
                ->references('id')
                ->on('audit_sub_criteria')
                ->cascadeOnDelete();
            $table->unsignedBigInteger('audit_master_sub_criteria_point_id')->nullable();
            $table->foreign('audit_master_sub_criteria_point_id','audit_point_sub_criteria_id_master_idx')
                ->references('id')
                ->on('audit_master_sub_criteria_points')
                ->nullOnDelete();
            $table->integer('point')->nullable();
            $table->text('tooltip')->nullable();
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
        Schema::dropIfExists('audit_sub_criteria_points');
    }
};
