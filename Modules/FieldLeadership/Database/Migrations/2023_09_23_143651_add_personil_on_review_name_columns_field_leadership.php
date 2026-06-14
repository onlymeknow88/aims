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
            $table->string('personil_on_review_name')->after('personil_on_review')->nullable();
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
            $table->dropColumn('personil_on_review_name');
        });
    }
};
