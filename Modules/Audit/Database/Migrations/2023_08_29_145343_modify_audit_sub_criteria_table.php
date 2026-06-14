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
        Schema::table('audit_sub_criteria', function(Blueprint $table) {
            $table->text('system_references')->after('description');
            $table->text('current_system_verification')->after('system_references');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audit_sub_criteria', function(Blueprint $table) {
            $table->dropColumn('system_references');
            $table->dropColumn('current_system_verification');
        });
       
    }
};
