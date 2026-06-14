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
        Schema::create('ptw_document_people', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->foreignUuid('document_id')
                ->references('id')
                ->on('ptw_documents')
                ->cascadeOnDelete();
            $table->string('email');
            $table->uuid('user_id')->nullable();
            $table->smallInteger('type')
                ->comment('1 for internal, 2 for external');
            $table->boolean('is_notify_email')->nullable();
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
        Schema::table('ptw_document_people', function (Blueprint $table) {
            $table->dropForeign(['document_id']);
        });
        Schema::dropIfExists('ptw_document_people');
    }
};
