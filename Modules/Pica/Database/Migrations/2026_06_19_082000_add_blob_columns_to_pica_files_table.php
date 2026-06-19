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
        Schema::table('pica_files', function (Blueprint $table) {
            $table->text('blob_url')->nullable()->after('file');
            $table->longText('blob_response')->nullable()->after('blob_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pica_files', function (Blueprint $table) {
            $table->dropColumn(['blob_url', 'blob_response']);
        });
    }
};
