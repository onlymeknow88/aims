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
        Schema::create('extractions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('obedience_id')
                ->nullable()
                ->references('id')
                ->on('obediences')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('bidang')->nullable();
            $table->string('sub_bidang')->nullable();
            $table->foreignUuid('responsible_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignUuid('section_id')
                ->nullable()
                ->references('id')
                ->on('sections')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('compliance_level')->nullable();
            $table->string('article')->nullable();
            $table->string('sub_section')->nullable();
            $table->longText('lampiran')->nullable();
            $table->longText('content')->nullable();
            $table->longText('disobedience')->nullable();
            $table->longText('consequence')->nullable();
            $table->date('date')->nullable();
            $table->string('status')->nullable();
            $table->string('file_path')->nullable();
            $table->string('comment')->nullable();
            $table->tinyInteger('is_draft')->default(0);
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
        Schema::dropIfExists('extractions');
    }
};
