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

        if (Schema::hasColumn('kplh_label', 'maker_id')) {
        } else {
        if (Schema::hasColumn('kplh_label', 'maker')) {
            Schema::table('kplh_label', function (Blueprint $table) {
                $table->renameColumn('maker', 'maker_id');

                // $table->after('id', function ($table) {
                //     $table->foreignUuid('maker_id')
                //         ->nullable()
                //         ->references('id')
                //         ->on('users')
                //         ->cascadeOnUpdate()
                //         ->nullOnDelete();
                // });
            });
        }
    }

        if (Schema::hasColumn('kplh_label', 'location')) {

            Schema::table('kplh_label', function (Blueprint $table) {
                $table->renameColumn('location', 'area_location_id');
            });
        } else {
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('kplh_label', 'xxx')) {
            Schema::table('kplh_label', function (Blueprint $table) {
                $table->drop('xxx');
            });
        }
    }
};
