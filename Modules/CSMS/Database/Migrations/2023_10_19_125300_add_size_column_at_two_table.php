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
        Schema::table('csms_memo_ktt_files', function (Blueprint $table) {
            $table->string('size')->after('file');
        });

        Schema::table('csms_letter_files', function (Blueprint $table) {
            $table->string('size')->after('file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('csms_memo_ktt_files', function (Blueprint $table) {
            $table->dropColumn('file');
        });

        Schema::table('csms_letter_files', function (Blueprint $table) {
            $table->dropColumn('file');
        });
    }
};
