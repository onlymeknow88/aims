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
        Schema::create('picas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('source_id')->nullable();
            $table->string('source')->nullable();
            $table->uuid('picaable_id')->nullable();
            $table->string('picaable_type')->nullable();

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
        Schema::dropIfExists('picas');
    }
};
