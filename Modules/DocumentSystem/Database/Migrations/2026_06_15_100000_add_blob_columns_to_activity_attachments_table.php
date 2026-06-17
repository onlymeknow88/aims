<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom blob_url dan blob_response ke tabel activity attachments
     * untuk mendukung penyimpanan file revision/comment ke Azure Blob Storage.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('document_system_activities_attachments', function (Blueprint $table) {
            $table->text('blob_url')->nullable()->after('name');
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
        Schema::table('document_system_activities_attachments', function (Blueprint $table) {
            $table->dropColumn(['blob_url', 'blob_response']);
        });
    }
};
