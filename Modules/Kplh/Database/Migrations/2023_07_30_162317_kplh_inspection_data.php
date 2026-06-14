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
        Schema::create('kplh_inspection_data', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('label_id')
                ->nullable()
                ->references('id')
                ->on('kplh_label')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->text('criteria')->nullable();
            $table->integer('value')->nullable();
            $table->text('file')->nullable();
            $table->text('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
