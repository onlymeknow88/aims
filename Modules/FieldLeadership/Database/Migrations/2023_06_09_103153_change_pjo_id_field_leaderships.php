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
        Schema::table('field_leaderships', function (Blueprint $table) {
            $table->foreignUuid('pjo_id')->nullable()->change();
            $table->string('number')->after('id')->nullable()->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('field_leaderships', function (Blueprint $table) {
            $table->foreignUuid('pjo_id')->change();
            $table->dropColumn('number');
        });
    }
};
