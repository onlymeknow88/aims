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
        Schema::table('field_leadership_risks', function (Blueprint $table) {
            $table->string('type_action')->after('due_date')->nullable();
            $table->string('supervisor')->after('type_action')->nullable();
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
            $table->dropColumn('type_action');
            $table->dropColumn('supervisor');
        });
    }
};
