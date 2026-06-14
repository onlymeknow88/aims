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
        Schema::create('iadl_teams', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('iadl_id')
                ->nullable()
                ->references('id')
                ->on('iadl')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('user_id')->nullable();
            $table->string('name')->nullable();
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
        Schema::dropIfExists('iadl_teams');
    }
};
