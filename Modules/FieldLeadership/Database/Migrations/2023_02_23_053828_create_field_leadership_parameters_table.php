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
        Schema::create('field_leadership_parameters', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('max_item_member')->default(0);
            $table->integer('max_item_positive_condition')->default(0);
            $table->integer('max_item_risk_condition')->default(0);
            $table->integer('max_item_corrective_action')->default(0);
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
        Schema::dropIfExists('field_leadership_parameters');
    }
};
