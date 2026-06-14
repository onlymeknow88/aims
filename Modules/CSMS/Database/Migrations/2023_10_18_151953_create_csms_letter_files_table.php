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
        Schema::create('csms_letter_files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('csms_letter_id')
                ->nullable()
                ->references('id')
                ->on('csms_letters')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('file');

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
        Schema::dropIfExists('csms_letter_files');
    }
};
