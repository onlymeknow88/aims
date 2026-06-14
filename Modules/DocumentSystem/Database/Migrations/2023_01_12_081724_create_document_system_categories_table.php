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
        Schema::create('document_system_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('module_id')
                ->references('id')
                ->on('document_system_modules')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
                $table->string('index');
                $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_system_categories');
    }
};
