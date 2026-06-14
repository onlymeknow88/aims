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
        Schema::create('bowtie_event_imm', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('event_id')
                ->nullable()
                ->references('id')
                ->on('bowtie_events')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('mitigation_associated_with_cause')->nullable();
            $table->string('mitigation_critical')->nullable();
            $table->string('mitigation_person_in_control')->nullable();

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
        Schema::dropIfExists('bowtie_event_imm');
    }
};
