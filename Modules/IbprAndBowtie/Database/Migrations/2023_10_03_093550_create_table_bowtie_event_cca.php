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
        Schema::create('bowtie_cca', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('bowtie_id')
                ->nullable()
                ->references('id')
                ->on('bowtie')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignUuid('event_id')
                ->nullable()
                ->references('id')
                ->on('bowtie_events')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('control_objectives')->nullable();
            $table->string('step_one')->nullable();
            $table->string('step_two')->nullable();
            $table->string('step_three')->nullable();
            $table->string('step_four')->nullable();
            $table->string('step_five')->nullable();
            $table->string('step_six')->nullable();
            $table->string('step_seven')->nullable();
            $table->string('control_regulation')->nullable();
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
        Schema::dropIfExists('bowtie_cca');
    }
};
