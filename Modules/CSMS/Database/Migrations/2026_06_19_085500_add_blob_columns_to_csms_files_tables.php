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
        Schema::table('csms_checklist_attachments', function (Blueprint $table) {
            $table->text('blob_url')->nullable()->after('file');
            $table->longText('blob_response')->nullable()->after('blob_url');
        });

        Schema::table('csms_pjo_files', function (Blueprint $table) {
            $table->text('blob_url')->nullable()->after('file');
            $table->longText('blob_response')->nullable()->after('blob_url');
        });

        Schema::table('csms_memo_ktt_files', function (Blueprint $table) {
            $table->text('blob_url')->nullable()->after('file');
            $table->longText('blob_response')->nullable()->after('blob_url');
        });

        Schema::table('csms_letter_files', function (Blueprint $table) {
            $table->text('blob_url')->nullable()->after('file');
            $table->longText('blob_response')->nullable()->after('blob_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('csms_checklist_attachments', function (Blueprint $table) {
            $table->dropColumn(['blob_url', 'blob_response']);
        });

        Schema::table('csms_pjo_files', function (Blueprint $table) {
            $table->dropColumn(['blob_url', 'blob_response']);
        });

        Schema::table('csms_memo_ktt_files', function (Blueprint $table) {
            $table->dropColumn(['blob_url', 'blob_response']);
        });

        Schema::table('csms_letter_files', function (Blueprint $table) {
            $table->dropColumn(['blob_url', 'blob_response']);
        });
    }
};
