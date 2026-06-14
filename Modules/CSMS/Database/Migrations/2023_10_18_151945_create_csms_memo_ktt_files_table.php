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
        Schema::create('csms_memo_ktt_files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('csms_memo_ktt_id')
                ->nullable()
                ->references('id')
                ->on('csms_memo_ktts')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('file');

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
        Schema::dropIfExists('csms_memo_ktt_files');
    }
};
