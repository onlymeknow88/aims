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
        Schema::create('csms_pjo_files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pjo_id')->nullable();
            $table->string('type')->nullable();
            $table->string('file')->nullable();
            $table->string('name')->nullable();
            $table->string('size')->nullable();
            $table->string('extension')->nullable();

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
        Schema::dropIfExists('csms_pjo_files');
    }
};
