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
        Schema::create('extraction_files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('extraction_id')
                ->nullable()
                ->references('id')
                ->on('extractions')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('file');
            $table->string('size')->nullable();
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
        Schema::dropIfExists('extraction_files');
    }
};
