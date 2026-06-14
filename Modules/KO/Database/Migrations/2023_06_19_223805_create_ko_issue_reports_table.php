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
        Schema::create('ko_issue_reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('ko_proposal_id')
                ->nullable()
                ->references('id')
                ->on('ko_proposals')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignUuid('ko_unit_id')
                ->nullable()
                ->references('id')
                ->on('ko_units')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('ko_commissioning_field_id')
                ->nullable()
                ->references('id')
                ->on('ko_commissioning_fields')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('note')->nullable();
            $table->string('attachment')->nullable();
            $table->string('hazard_code')->nullable();
            $table->string('status')->nullable();
            $table->string('returned_message')->nullable();
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
        Schema::dropIfExists('ko_issue_reports');
    }
};
