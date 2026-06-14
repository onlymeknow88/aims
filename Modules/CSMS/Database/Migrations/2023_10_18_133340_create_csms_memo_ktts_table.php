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
        Schema::create('csms_memo_ktts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('memo_number')->nullable();
            $table->string('title')->nullable();
            $table->uuid('ccow_id')->nullable();
            $table->uuid('ktt_id')->nullable();
            $table->date('date')->nullable();
            $table->date('date_inactive')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->nullable();

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
        Schema::dropIfExists('csms_memo_ktts');
    }
};
