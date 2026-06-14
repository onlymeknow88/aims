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
        Schema::create('bowtie_loss_calculation', function (Blueprint $table) {
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
        Schema::dropIfExists('bowtie_loss_calculation');
    }
};
