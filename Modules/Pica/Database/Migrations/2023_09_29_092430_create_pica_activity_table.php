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
        Schema::create('pica_activities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('pica_id')
                ->nullable()
                ->references('id')
                ->on('pica_documents')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('description');
            $table->string('user_id')->nullable();

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
        Schema::dropIfExists('pica_activities');
    }
};
