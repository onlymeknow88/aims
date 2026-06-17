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

    Schema::disableForeignKeyConstraints();

    Schema::table('jsa_documents', function (Blueprint $table) {
        // Hanya add kalau kolom belum ada
        if (!Schema::hasColumn('jsa_documents', 'mapping_id')) {
            $table->foreignUuid('mapping_id')
                ->nullable()
                ->references('id')
                ->on('document_system_mappings')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        }

        if (!Schema::hasColumn('jsa_documents', 'prefix_code')) {
            $table->string('prefix_code')->nullable();
        }
    });

    Schema::enableForeignKeyConstraints();
    }
};
