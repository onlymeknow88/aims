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
        Schema::table('document_system_attachments', function (Blueprint $table) {
            $table->string('file_type', 15)->change();
            $table->float('file_size')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('document_system_attachments', function (Blueprint $table) {
            $table->string('file_type')->change();
            $table->string('file_size')->change();
        });
    }
};
