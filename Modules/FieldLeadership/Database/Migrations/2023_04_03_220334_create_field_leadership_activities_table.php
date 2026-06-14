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
        Schema::create('field_leadership_activities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('fl_id')
                ->nullable()
                ->references('id')
                ->on('field_leaderships')
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
        Schema::dropIfExists('field_leadership_activities');
    }
};
