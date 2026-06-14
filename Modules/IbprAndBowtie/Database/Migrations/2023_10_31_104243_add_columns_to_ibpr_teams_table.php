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
        Schema::table('ibpr_teams', function (Blueprint $table) {
            $table->integer('user_name')->nullable();
        });

        Schema::table('iadl_teams', function (Blueprint $table) {
            $table->integer('user_name')->nullable();
        });

        Schema::table('ibprs', function (Blueprint $table) {
            $table->integer('reject_reason')->nullable();
        });

        Schema::table('bowtie', function (Blueprint $table) {
            $table->integer('reject_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ibpr_teams', function (Blueprint $table) {
            $table->dropColumn('user_name');
        });

        Schema::table('iadl_teams', function (Blueprint $table) {
            $table->dropColumn('user_name');
        });

        Schema::table('ibprs', function (Blueprint $table) {
            $table->dropColumn('reject_reason');
        });

        Schema::table('bowtie', function (Blueprint $table) {
            $table->dropColumn('reject_reason');
        });
    }
};
