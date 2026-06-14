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
        Schema::table('field_leadership_risks', function (Blueprint $table) {
            $table->text('risk_condition')->nullable()->change();
            $table->text('repair_action')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('field_leadership_risks', function (Blueprint $table) {
            $table->dropColumn('risk_condition');
            $table->dropColumn('repair_action');
        });
    }
};
