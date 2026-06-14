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
        Schema::table('pica_documents', function (Blueprint $table) {
            $table->string('requested')->after('remarks')->nullable();
            $table->string('published')->after('requested')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pica_documents', function (Blueprint $table) {
            $table->dropColumn('requested');
            $table->dropColumn('published');
        });
    }
};
