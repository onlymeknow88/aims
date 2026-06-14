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
        Schema::create('iadl', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('ccow_id')
                ->nullable()
                ->references('id')
                ->on('companies')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('iup');
            $table->foreignUuid('department_id')
                ->nullable()
                ->references('id')
                ->on('departments')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignUuid('contractor_id')
                ->nullable()
                ->references('id')
                ->on('companies')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignUuid('sub_contractor_id')
                ->nullable()
                ->references('id')
                ->on('companies')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignUuid('pjs_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignUuid('pja_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignUuid('pjo_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignUuid('section_id')
                ->nullable()
                ->references('id')
                ->on('sections')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('kriteria')->nullable();
            $table->string('tim_manajement_risiko')->nullable();
            $table->date('request_date')->nullable();
            $table->date('approve_at')->nullable();
            $table->date('next_date')->nullable();
            $table->string('document_no')->nullable();
            $table->string('reject_reason')->nullable();
            $table->integer('revisi_number')->nullable();
            $table->string('status')->default('DRAFT');
            $table->foreignUuid('created_by')
                ->nullable()
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iadl');
    }
};
