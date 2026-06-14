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
        Schema::create('ko_commissioning_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ko_commissioning_header_id')
                ->nullable()
                ->references('id')
                ->on('ko_commissioning_headers')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('number')->nullable();
            $table->text('question')->nullable();
            $table->string('hazard_code')->nullable();
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
        Schema::dropIfExists('ko_commissioning_fields');
    }
};
