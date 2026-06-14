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
        Schema::create('ptw_document_attachments', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->foreignUuid('document_id')
                ->references('id')
                ->on('ptw_documents')
                ->cascadeOnDelete();
            $table->string('file_name');
            $table->string('file_type');
            $table->double('file_size');
            $table->string('path');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ptw_document_attachments');
    }
};
