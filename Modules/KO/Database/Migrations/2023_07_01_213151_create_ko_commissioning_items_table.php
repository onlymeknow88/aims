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
        Schema::create('ko_commissioning_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('ko_commissioning_id')
                ->nullable()
                ->references('id')
                ->on('ko_commissionings')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('ko_commissioning_field_id')
                ->nullable()
                ->references('id')
                ->on('ko_commissioning_fields')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('condition')->nullable();
            $table->string('note')->nullable();
            //$table->string('attachment')->nullable();
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
        Schema::dropIfExists('ko_commissioning_items');
    }
};
