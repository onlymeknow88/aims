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
        Schema::table('bowtie_event_cmf', function (Blueprint $table) {
            $table->string('control_measures')->nullable();
        });

        Schema::table('bowtie_event_repair_imm', function (Blueprint $table) {
            $table->string('mitigation_measures')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bowtie', function (Blueprint $table) {

        });
    }
};
