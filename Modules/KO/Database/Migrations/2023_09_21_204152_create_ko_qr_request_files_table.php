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
        Schema::create('ko_qr_request_files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('ko_proposal_id')
                ->nullable()
                ->references('id')
                ->on('ko_proposals')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('attachment')->nullable();
            $table->string('type')->nullable();
            $table->string('name')->nullable();
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
        Schema::dropIfExists('ko_qr_request_files');
    }
};
