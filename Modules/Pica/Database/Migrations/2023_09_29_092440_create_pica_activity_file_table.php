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
        Schema::create('pica_activity_files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pica_activity_id')
                ->nullable()
                ->references('id')
                ->on('pica_activities')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('file');
            $table->string('type_file')->nullable();
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
        Schema::dropIfExists('pica_activity_files');
    }
};
