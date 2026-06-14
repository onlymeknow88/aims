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
        Schema::table('kplh_inspection_risks', function (Blueprint $table) {
            $table->after('due_date', function ($table) {
                $table->char('status')->nullable();
            });
        });
        Schema::table('kplh_label', function (Blueprint $table) {
            $table->after('status', function ($table) {
                $table->char('pica_status')->nullable();
            });
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
