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
        Schema::create('ptw_documents', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->foreignUuid('department_id')
                ->references('id')
                ->on('departments')
                ->cascadeOnUpdate();
            $table->foreignUuid('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate();
            $table->smallInteger('status')
                ->comment('1 for active, 2 for inactive');
            $table->string('title');
            $table->longText('description');
            $table->string('document_number');
            $table->timestamp('doc_created');
            $table->string('detail_location')->nullable();
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
        Schema::table('ptw_documents', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('ptw_documents');
    }
};
