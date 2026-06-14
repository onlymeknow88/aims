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
        Schema::create('document_system_documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('department_id')
                ->nullable()
                ->references('id')
                ->on('departments')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignUuid('mapping_id')
                ->nullable()
                ->references('id')
                ->on('document_system_mappings')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignUuid('area_manager_id')
                ->nullable()
                ->references('id')
                ->on('area_managers')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignUuid('user_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->text('related_people')->nullable();
            $table->string('upload_type');
            $table->string('document_level');
            $table->string('status');
            $table->string('revision')->nullable();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->string('sop_number')->nullable();
            $table->string('sop_add_win')->nullable();
            $table->string('sop_add_form')->nullable();
            $table->string('document_number')->nullable();
            $table->string('file_path')->nullable();
            $table->string('uncontrolled_file_path')->nullable();
            $table->date('doc_created')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('document_system_documents', function (Blueprint $table) {
            $table->foreignUuid('related_document_id')
                ->nullable()
                ->references('id')
                ->on('document_system_documents')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_system_documents');
    }
};
