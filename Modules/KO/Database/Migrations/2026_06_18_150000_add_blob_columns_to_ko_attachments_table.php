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
        Schema::table('ko_attachments', function (Blueprint $table) {
            $table->longText('blob_response')->nullable()->after('com');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ko_attachments', function (Blueprint $table) {
            $table->dropColumn(['blob_response']);
        });
    }
};
