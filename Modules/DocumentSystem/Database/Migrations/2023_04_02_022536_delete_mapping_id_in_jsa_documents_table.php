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
        Schema::table('jsa_documents', function (Blueprint $table) {
            $table->dropForeign(['mapping_id']);
            $table->dropColumn('mapping_id');

            $table->dropColumn('prefix_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jsa_documents', function (Blueprint $table) {
            $table->foreignUuid('mapping_id')
                ->references('id')
                ->on('document_system_mappings')
                ->cascadeOnUpdate();

            $table->string('prefix_code')->nullable();
        });
    }
};
