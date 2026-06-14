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
            $table->string('user_name')->nullable()->change();
        });

        Schema::table('iadl_teams', function (Blueprint $table) {
            $table->string('user_name')->nullable()->change();
        });

        Schema::table('ibprs', function (Blueprint $table) {
            $table->string('reject_reason')->nullable()->change();
        });

        Schema::table('bowtie', function (Blueprint $table) {
            $table->string('reject_reason')->nullable()->change();
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
