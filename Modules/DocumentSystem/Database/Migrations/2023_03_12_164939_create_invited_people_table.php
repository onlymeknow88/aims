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
        Schema::create('document_system_invited_people', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->foreignUuid('user_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate();
            $table->foreignUuid('document_id')
                ->references('id')
                ->on('document_system_documents')
                ->cascadeOnDelete();
            $table->tinyInteger('user_type')->nullable()
                ->comment('1 for user that has been registered, 2 for users who are outside the system');
            $table->string('path');
            $table->string('name')->nullable();
            $table->float('size')->nullable();
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
        Schema::table('document_system_invited_people', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['document_id']);
        });
        Schema::dropIfExists('document_system_invited_people');
    }
};
