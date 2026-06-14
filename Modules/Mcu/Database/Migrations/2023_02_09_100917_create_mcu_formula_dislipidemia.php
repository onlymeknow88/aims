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
        Schema::create('mcu_formula_dislipidemia', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('status');

            $table->integer('col_total')->nullable();
            $table->integer('tga')->nullable();
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
        Schema::dropIfExists('mcu_formula_dislipidemia');
    }
};
