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
        Schema::table('ptw_documents', function (Blueprint $table) {
            $table->timestamp('inactive_at')->nullable()->after('doc_created');
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
            $table->dropColumn('inactive_at');
        });
    }
};
