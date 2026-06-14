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
        Schema::table('bowtie_cca', function (Blueprint $table) {
            $table->integer('control_explanation');
        });

        Schema::table('bowtie_performance_standard', function (Blueprint $table) {
            $table->integer('obesrvation_file');
            $table->integer('obesrvation');
        });

        Schema::table('bowtie_teams', function (Blueprint $table) {
            $table->integer('user_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bowtie_cca', function (Blueprint $table) {
            $table->dropColumn('control_explanation');
        });

        Schema::table('bowtie_performance_standard', function (Blueprint $table) {
            $table->dropColumn('obesrvation_file');
            $table->dropColumn('obesrvation');
        });

        Schema::table('bowtie_teams', function (Blueprint $table) {
            $table->dropColumn('user_name');
        });
    }
};
