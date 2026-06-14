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
        Schema::create('field_leaderships', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('date');
            $table->foreignUuid('ccow_id')
                ->nullable()
                ->references('id')
                ->on('companies')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignUuid('company_id')
                ->nullable()
                ->references('id')
                ->on('companies')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('detail_company');
            $table->foreignUuid('department_id')
                ->nullable()
                ->references('id')
                ->on('departments')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignUuid('section_id')
                ->nullable()
                ->references('id')
                ->on('sections')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignUuid('area_location_id')
                ->nullable()
                ->references('id')
                ->on('area_locations')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->text('detail_location')->nullable();
            $table->foreignUuid('pja_id');
            $table->foreignUuid('pjo_id');
            $table->string('type')->nullable();
            $table->string('job')->nullable();
            $table->bigInteger('visit_time')->nullable();
            $table->string('status'); // draft | active
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
        Schema::dropIfExists('field_leaderships');
    }
};
