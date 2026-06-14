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
        Schema::create('ko_commissionings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('ko_proposal_id')
                ->nullable()
                ->references('id')
                ->on('ko_proposals')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->date('date')->nullable();
            $table->date('commissioning_completion_date')->nullable();
            $table->string('smu_odo_meter')->nullable();
            $table->string('engine_status')->nullable();
            $table->date('expired_date')->nullable();
            $table->string('status')->nullable();
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('ko_commissionings');
    }
};
