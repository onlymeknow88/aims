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


        if (Schema::hasTable('sap_setup')) {
            Schema::table('sap_setup', function (Blueprint $table) {
                !Schema::hasColumn('sap_setup', 'available') ? $table->string('available')->nullable() : null;
                !Schema::hasColumn('sap_setup', 'year') ? $table->integer('year')->nullable() : null;
            });
        }

        if (Schema::hasTable('sap_monthly')) {
            Schema::table('sap_monthly', function (Blueprint $table) {
                !Schema::hasColumn('sap_monthly', 'total') ? $table->decimal('total', 11, 2)->default(0)->nullable() : null;
            });
        }

        if (Schema::hasTable('sap_monthly_employee')) {
            Schema::table('sap_monthly_employee', function (Blueprint $table) {
                !Schema::hasColumn('sap_monthly_employee', 'id_number') ? $table->string('id_number')->nullable() : null;
                !Schema::hasColumn('sap_monthly_employee', 'code') ? $table->string('code')->nullable() : null;
                !Schema::hasColumn('sap_monthly_employee', 'company_name') ? $table->string('company_name')->nullable() : null;
                !Schema::hasColumn('sap_monthly_employee', 'department_id') ? $table->uuid('department_id')->nullable() : null;
                !Schema::hasColumn('sap_monthly_employee', 'grade_code') ? $table->string('grade_code')->nullable() : null;
            });
        }

        if (Schema::hasTable('sap_monthly_category')) {
            Schema::table('sap_monthly_category', function (Blueprint $table) {
                !Schema::hasColumn('sap_monthly_category', 'department_id') ? $table->uuid('department_id')->nullable() : null;
                !Schema::hasColumn('sap_monthly_category', 'code') ? $table->string('code')->nullable() : null;
            });
        }

        if (Schema::hasTable('sap_monthly_actual')) {
            Schema::table('sap_monthly_actual', function (Blueprint $table) {
                !Schema::hasColumn('sap_monthly_actual', 'module_slug') ? $table->string('module_slug')->nullable() : null;
                !Schema::hasColumn('sap_monthly_actual', 'grade') ? $table->string('grade')->nullable() : null;
                !Schema::hasColumn('sap_monthly_actual', 'grade_code') ? $table->string('grade_code')->nullable() : null;
                !Schema::hasColumn('sap_monthly_actual', 'id_number') ? $table->string('id_number')->nullable() : null;
                !Schema::hasColumn('sap_monthly_actual', 'employee_name') ? $table->string('employee')->nullable() : null;
            });
        }

        if (Schema::hasTable('employees')) {
            Schema::table('employees', function (Blueprint $table) {
                !Schema::hasColumn('employees', 'grade') ? $table->string('grade')->nullable() : null;
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
