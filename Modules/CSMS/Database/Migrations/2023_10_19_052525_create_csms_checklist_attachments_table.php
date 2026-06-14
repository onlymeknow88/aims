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
        Schema::create('csms_checklist_attachments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('csms_checklist_id')
                ->nullable()
                ->references('id')
                ->on('csms_checklists')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('file');
            $table->string('size')->nullable();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('csms_checklist_attachments');
    }
};
