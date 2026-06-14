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
        if (Schema::hasColumn('kplh_label', 'xxx')) {
            Schema::table('kplh_label', function (Blueprint $table) {
                $table->renameColumn('xxx', 'tool_type');
            });
        }

        if (Schema::hasColumn('kplh_label', 'tool_type')) {
            Schema::table('kplh_label', function (Blueprint $table) {
                if (Schema::hasColumn('kplh_label', 'tool_id')) {
                } else {
                    $table->after('tool_type', function ($table) {
                        $table->string('tool_id')->nullable();
                    });
                }
            });
        }

        if (Schema::hasColumn('kplh_label', 'tool_id')) {
            Schema::table('kplh_label', function (Blueprint $table) {
                if (Schema::hasColumn('kplh_label', 'tool_date')) {
                } else {
                    $table->after('tool_id', function ($table) {
                        $table->date('tool_date')->nullable();
                    });
                }
            });
        }

        if (Schema::hasColumn('kplh_label', 'tool_date')) {
            Schema::table('kplh_label', function (Blueprint $table) {
                if (Schema::hasColumn('kplh_label', 'tool_type_detail')) {
                } else {
                    $table->after('tool_date', function ($table) {
                        $table->string('tool_type_detail')->nullable();
                    });
                }
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
