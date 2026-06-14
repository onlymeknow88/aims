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
        Schema::create('rule_files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('rule_id')
                ->nullable()
                ->references('id')
                ->on('rules')
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
        Schema::dropIfExists('rule_files');
    }
};
