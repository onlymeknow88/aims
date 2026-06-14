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
        Schema::create('dashboard_performance', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->nullable();
            $table->string('visible')->nullable();
            $table->timestamp('month')->nullable();
            $table->decimal('rkk', 11, 2)->nullable();
            $table->decimal('cmr', 11, 2)->nullable();
            $table->decimal('mmr', 11, 2)->nullable();
            $table->decimal('ssr', 11, 2)->nullable();
            $table->decimal('asr', 11, 2)->nullable();
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
        //
    }
};
