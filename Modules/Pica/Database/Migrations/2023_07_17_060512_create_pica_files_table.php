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
        Schema::create('pica_files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pica_id');
            $table->string('file')->nullable();
            $table->string('type')->nullable();
            $table->string('size')->nullable();


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
        Schema::dropIfExists('pica_files');
    }
};
