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
        Schema::create('bowtie_event_repair_imm', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('event_id')
                ->nullable()
                ->references('id')
                ->on('bowtie_events')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('repair_task')->nullable();
            $table->date('due_date')->nullable();
            $table->string('person_responsible')->nullable();
            $table->date('completion_date')->nullable();
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
        Schema::dropIfExists('bowtie_event_repair_imm');
    }
};
