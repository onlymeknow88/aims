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
        Schema::table('ibpr_forms', function (Blueprint $table) {
            $table->string('residual_frequence')->nullable()->change();
        });

        Schema::table('iadl_forms', function (Blueprint $table) {
            $table->string('residual_frequence')->nullable()->change();
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
