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
        Schema::table('biddings', function (Blueprint $table) {
            $table->string('requested')->after('status')->nullable();
            $table->string('published')->after('requested')->nullable();
        });

        Schema::table('csms_pjos', function (Blueprint $table) {
            $table->string('requested')->after('published')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('biddings', function (Blueprint $table) {
            $table->dropColumn('requested');
            $table->dropColumn('published');
        });

        Schema::table('csms_pjos', function (Blueprint $table) {
            $table->dropColumn('requested');
        });
    }
};
