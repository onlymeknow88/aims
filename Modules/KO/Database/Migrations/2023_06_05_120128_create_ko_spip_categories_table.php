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
        Schema::create('ko_spip_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->integer('internal_interval_year');
            $table->integer('contractor_interval_year');
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
        Schema::dropIfExists('ko_spip_categories');
    }
};
