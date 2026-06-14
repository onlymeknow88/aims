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
        Schema::create('ibpr_teams', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('ibpr_id')
                ->nullable()
                ->references('id')
                ->on('ibprs')
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
        Schema::dropIfExists('ibpr_teams');
    }
};
