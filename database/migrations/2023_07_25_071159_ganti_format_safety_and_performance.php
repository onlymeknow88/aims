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
        if (Schema::hasTable('dashboard_performance')) {
            Schema::table('dashboard_performance', function (Blueprint $table) {
                $table->decimal('rkk', 11, 2)->nullable()->change();
                $table->decimal('cmr', 11, 2)->nullable()->change();
                $table->decimal('mmr', 11, 2)->nullable()->change();
                $table->decimal('ssr', 11, 2)->nullable()->change();
                $table->decimal('asr', 11, 2)->nullable()->change();
            });
        }

        if (Schema::hasTable('dashboard_safety_performance')) {
            Schema::table('dashboard_safety_performance', function (Blueprint $table) {
                $table->decimal('aifr', 11, 2)->nullable()->change();
                $table->decimal('ainfr', 11, 2)->nullable()->change();
                $table->decimal('lti_fr', 11, 2)->nullable()->change();
                $table->decimal('lti_sr', 11, 2)->nullable()->change();
            });
        }
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
