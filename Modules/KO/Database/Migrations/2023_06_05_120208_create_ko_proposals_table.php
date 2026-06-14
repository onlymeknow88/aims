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
        Schema::create('ko_proposals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('number');
            $table->foreignUuid('ccow_id')
                ->nullable()
                ->references('id')
                ->on('companies')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('area');
            $table->foreignUuid('ko_unit_id')
                ->nullable()
                ->references('id')
                ->on('ko_units')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            //$table->year('submission_year');
            //$table->text('usage_purpose');
            $table->foreignUuid('company_id')
                ->nullable()
                ->references('id')
                ->on('companies')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            // $table->string('company_address');
            $table->foreignUuid('department_id')
                ->nullable()
                ->references('id')
                ->on('departments')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('other_department')->nullable();
            $table->string('applicant_email');
            $table->foreignUuid('pjo_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->date('internal_komisioning_schedule')->nullable();
            $table->date('next_commissioning')->nullable();
            $table->date('temporary_validity_period')->nullable();
            $table->integer('commissioning_period')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('ko_proposals');
    }
};
