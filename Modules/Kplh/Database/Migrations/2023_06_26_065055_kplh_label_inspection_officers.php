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
        Schema::create('kplh_label_io', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignUuid('label_id')
                ->nullable()
                ->references('id')
                ->on('kplh_label')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignUuid('employee_id')
                ->nullable()
                ->references('id')
                ->on('employees')
                ->cascadeOnUpdate()
                ->nullOnDelete();
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
        Schema::dropIfExists('kplh_label_io');
    }
};
