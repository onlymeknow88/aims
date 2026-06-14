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
        Schema::create('kplh_label', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('maker')
                ->nullable()
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignUuid('department_id')
                ->nullable()
                ->references('id')
                ->on('departments')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignUuid('ccow_id')
                ->nullable()
                ->references('id')
                ->on('companies')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignUuid('pja_id')
                ->nullable()
                ->references('id')
                ->on('employees')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignUuid('ktt_id')
                ->nullable()
                ->references('id')
                ->on('companies')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('inspect_id')->unique();
            $table->string('inspect_criteria');
            $table->date('date')->nullable();
            $table->string('location')->nullable();
            $table->string('location_detail')->nullable();
            $table->text('inspection_officer')->nullable();
            $table->string('status'); // draft | active
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
        Schema::dropIfExists('kplh_label');
    }
};
