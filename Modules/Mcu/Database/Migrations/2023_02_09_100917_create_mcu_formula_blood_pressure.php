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
        Schema::create('mcu_formula_blood_pressure', function (Blueprint $table) {
            $table->id()->autoIncrement();

            $table->string('status');

            $table->integer('normal_a')->nullable();
            $table->integer('normal_b')->nullable();
            $table->integer('pre_a_1')->nullable();
            $table->integer('pre_b_1')->nullable();
            $table->integer('pre_a_2')->nullable();
            $table->integer('pre_b_2')->nullable();
            $table->integer('ht1_a_1')->nullable();
            $table->integer('ht1_b_1')->nullable();
            $table->integer('ht1_a_2')->nullable();
            $table->integer('ht1_b_2')->nullable();
            $table->integer('ht2_a')->nullable();
            $table->integer('ht2_b')->nullable();
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
        Schema::dropIfExists('mcu_formula_blood_pressure');
    }
};
