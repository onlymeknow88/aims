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
        if (Schema::hasTable('sap_monthly')) {
            Schema::table('sap_monthly', function (Blueprint $table) {
                Schema::hasColumn('sap_monthly', 'year') ? $table->integer('year')->change() : null;
                Schema::hasColumn('sap_monthly', 'january') ? $table->decimal('january', 11, 2)->default(0)->nullable()->change() : null;
                Schema::hasColumn('sap_monthly', 'february') ? $table->decimal('february', 11, 2)->default(0)->nullable()->change() : null;
                Schema::hasColumn('sap_monthly', 'march') ? $table->decimal('march', 11, 2)->default(0)->nullable()->change() : null;
                Schema::hasColumn('sap_monthly', 'april') ? $table->decimal('april', 11, 2)->default(0)->nullable()->change() : null;
                Schema::hasColumn('sap_monthly', 'may') ? $table->decimal('may', 11, 2)->default(0)->nullable()->change() : null;
                Schema::hasColumn('sap_monthly', 'june') ? $table->decimal('june', 11, 2)->default(0)->nullable()->change() : null;
                Schema::hasColumn('sap_monthly', 'july') ? $table->decimal('july', 11, 2)->default(0)->nullable()->change() : null;
                Schema::hasColumn('sap_monthly', 'august') ? $table->decimal('august', 11, 2)->default(0)->nullable()->change() : null;
                Schema::hasColumn('sap_monthly', 'september') ? $table->decimal('september', 11, 2)->default(0)->nullable()->change() : null;
                Schema::hasColumn('sap_monthly', 'october') ? $table->decimal('october', 11, 2)->default(0)->nullable()->change() : null;
                Schema::hasColumn('sap_monthly', 'november') ? $table->decimal('november', 11, 2)->default(0)->nullable()->change() : null;
                Schema::hasColumn('sap_monthly', 'december') ? $table->decimal('december', 11, 2)->default(0)->nullable()->change() : null;
            });
        }


        if (Schema::hasTable('sap_setup_category')) {
            Schema::table('sap_setup_category', function (Blueprint $table) {
                Schema::hasColumn('sap_setup_category', 'name') ? $table->integer('name')->change() : null;
            });
        }


        if (Schema::hasTable('sap_setup')) {
            Schema::table('sap_setup', function (Blueprint $table) {
                Schema::hasColumn('sap_setup', 'safety_accountability_progam') ? $table->string('safety_accountability_progam')->nullable()->change() : null;
                Schema::hasColumn('sap_setup', 'dept_head') ?  $table->decimal('dept_head', 11, 2)->nullable()->change() : null;
                Schema::hasColumn('sap_setup', 'foreman_supervisor_sechead') ?  $table->decimal('foreman_supervisor_sechead', 11, 2)->nullable()->change() : null;
                Schema::hasColumn('sap_setup', 'employee') ?  $table->decimal('employee', 11, 2)->nullable()->change() : null;
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
    }
};
