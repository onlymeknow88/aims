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
        Schema::create('ptw_document_activities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('document_id')
                ->references('id')
                ->on('ptw_documents')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignUuid('user_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->string('status_document')->nullable();
            $table->longText('description')->nullable();
            $table->longText('attachments')->nullable();
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
        Schema::table('ptw_document_activities', function (Blueprint $table) {
            $table->dropForeign(['document_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('ptw_document_activities');
    }
};
