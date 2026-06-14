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
        Schema::create('bowtie_performance_standard', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('bowtie_id')
                ->nullable()
                ->references('id')
                ->on('bowtie')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignUuid('department_id')
                ->nullable()
                ->references('id')
                ->on('departments')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignUuid('section_id')
                ->nullable()
                ->references('id')
                ->on('sections')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('purpose')->nullable();
            $table->string('design_standard')->nullable();
            $table->string('operation_standard')->nullable();
            $table->string('ospek')->nullable();
            $table->string('observation_file')->nullable();
            $table->string('observation')->nullable();
            $table->string('test_efectivity_file')->nullable();
            $table->string('implementation_test_efectivity')->nullable();
            $table->string('obesrvation_file_name')->nullable();
            $table->string('test_efectivity_file_name')->nullable();
            $table->string('number')->nullable();
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
        Schema::dropIfExists('bowtie_performance_standard');
    }
};
