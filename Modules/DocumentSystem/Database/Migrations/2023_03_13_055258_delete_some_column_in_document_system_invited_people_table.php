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
        Schema::table('document_system_invited_people', function (Blueprint $table) {
            $table->dropColumn('path');
            $table->dropColumn('name');
            $table->dropColumn('size');

            // append new column
            $table->boolean('is_notify_email')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('document_system_invited_people', function (Blueprint $table) {
            $table->string('path')->nullable();
            $table->string('name')->nullable();
            $table->string('size', 10)->nullable();

            $table->dropColumn('is_notify_email');
        });
    }
};
