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
        Schema::table('document_system_documents', function (Blueprint $table) {
            $table->smallInteger('status')
                ->tinyInteger('status')
                ->comment('1 for submit review, 2 for draft, 3 on rooting review, 4 for on revision, 5 for active')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('document_system_documents', function (Blueprint $table) {
            $table->string('status')->change();
        });
    }
};
