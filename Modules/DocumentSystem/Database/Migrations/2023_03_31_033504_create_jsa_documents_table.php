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
        Schema::create('jsa_documents', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->foreignUuid('department_id')
                ->references('id')
                ->on('departments')
                ->cascadeOnUpdate();
            $table->foreignUuid('mapping_id')
                ->references('id')
                ->on('document_system_mappings')
                ->cascadeOnUpdate();
            $table->foreignUuid('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate();
            $table->smallInteger('status')
                ->comment('1 for active, 2 for draft, 3 for expired');
            $table->string('title');
            $table->longText('description');
            $table->string('document_number');
            $table->timestamp('doc_created');
            $table->string('detail_location')->nullable();
            $table->string('prefix_code')->nullable();
            $table->json('history_revision')->nullable();
            $table->uuid('parent_document')->nullable();
            $table->boolean('is_obsolate')->default(false);
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
        // Schema::table('jsa_documents', function (Blueprint $table) {
        //    $table->dropForeign(['department_id']);
        //    $table->dropForeign(['mapping_id']);
        //    $table->dropForeign(['user_id']);
        // });
        // Schema::dropIfExists('jsa_documents');

         Schema::disableForeignKeyConstraints();
    Schema::dropIfExists('jsa_documents');
    Schema::enableForeignKeyConstraints();
    }
};
