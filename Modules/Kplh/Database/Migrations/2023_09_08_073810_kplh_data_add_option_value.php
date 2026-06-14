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
        if (Schema::hasColumn('kplh_inspection_data', 'k3_value_2')) {
            Schema::table('kplh_inspection_data', function (Blueprint $table) {
                $table->after('k3_value_2', function ($table) {
                    $table->char('k3_value_3', 50)->nullable();
                });
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
