<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom blob_url dan blob_response ke semua tabel attachment
     * dalam module DocumentSystem untuk mendukung penyimpanan ke Azure Blob Storage.
     *
     * @return void
     */
    public function up()
    {
        // document_system_attachments (SOP, TS, MN, WIN, Form)
        Schema::table('document_system_attachments', function (Blueprint $table) {
            $table->text('blob_url')->nullable()->after('path');
            $table->longText('blob_response')->nullable()->after('blob_url');
        });

        // jsa_document_attachments (Job Safety Analysis)
        Schema::table('jsa_document_attachments', function (Blueprint $table) {
            $table->text('blob_url')->nullable()->after('path');
            $table->longText('blob_response')->nullable()->after('blob_url');
        });

        // ptw_document_attachments (Permit to Work)
        Schema::table('ptw_document_attachments', function (Blueprint $table) {
            $table->text('blob_url')->nullable()->after('path');
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
        Schema::table('document_system_attachments', function (Blueprint $table) {
            $table->dropColumn(['blob_url', 'blob_response']);
        });

        Schema::table('jsa_document_attachments', function (Blueprint $table) {
            $table->dropColumn(['blob_url', 'blob_response']);
        });

        Schema::table('ptw_document_attachments', function (Blueprint $table) {
            $table->dropColumn(['blob_url', 'blob_response']);
        });
    }
};
