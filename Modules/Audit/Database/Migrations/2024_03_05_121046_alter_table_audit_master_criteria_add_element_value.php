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
        Schema::table('audit_master_criteria', function (Blueprint $table) {
            $table->integer('element_value')->nullable()->after('audit_category');
        });

        Schema::table('audit_criteria', function (Blueprint $table) {
            $table->integer('element_value')->nullable()->after('excluded');
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
