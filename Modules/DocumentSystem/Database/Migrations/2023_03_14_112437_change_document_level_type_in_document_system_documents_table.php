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
        Schema::table('document_system_documents', function (Blueprint $table) {
            $table->smallInteger('document_level')
                ->tinyInteger('document_level')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('document_system_documents', function (Blueprint $table) {
            $table->string('document_level')->change();
        });
    }
};
