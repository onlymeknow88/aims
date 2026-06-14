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
        Schema::create('dashboard_general', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->nullable();;
            $table->integer('project_to_date')->nullable();
            $table->string('project_to_date_mark')->nullable();
            $table->integer('manhours')->nullable();
            $table->string('manhours_mark')->nullable();
            $table->integer('day_after_last_lti')->nullable();
            $table->string('day_after_last_lti_mark')->nullable();
            $table->integer('manpower')->nullable();
            $table->string('manpower_mark')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
