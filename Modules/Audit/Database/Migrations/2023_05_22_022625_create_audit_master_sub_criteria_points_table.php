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
        Schema::create('audit_master_sub_criteria_points', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audit_master_sub_criteria_id');
            $table->foreign('audit_master_sub_criteria_id','audit_point_master_sub_criteria_id_idx')
                ->references('id')
                ->on('audit_master_sub_criteria')
                ->cascadeOnDelete();
            $table->integer('point')->nullable();
            $table->text('tooltip')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('audit_master_sub_criteria_points');
    }
};
