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
        Schema::table('kpp_extraction_files', function (Blueprint $table) {
            $table->string('type')->after('file')->nullable();
            $table->string('name')->after('file')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kpp_extraction_files', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('name');
        });
    }
};
