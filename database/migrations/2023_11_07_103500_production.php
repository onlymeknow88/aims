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
        Schema::create('dashboard_production', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->nullable();
            $table->string('visible')->nullable();
            $table->timestamp('month')->nullable();
            $table->decimal('coal_shiping', 11, 2)->nullable();
            $table->decimal('waste_removal', 11, 2)->nullable();
            $table->decimal('coal_mining', 11, 2)->nullable();
            $table->decimal('coal_hauling', 11, 2)->nullable();
            $table->decimal('coal_barged', 11, 2)->nullable();
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
