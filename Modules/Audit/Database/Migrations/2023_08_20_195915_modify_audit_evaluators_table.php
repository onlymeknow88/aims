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
        Schema::table('audit_evaluators', function(Blueprint $table) {
            $table->dropForeign(['audit_smkp_id']);
            $table->dropColumn('audit_smkp_id');
            $table->foreignUuid('audit_id')->after('user_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audit_evaluators', function(Blueprint $table) {
            $table->dropForeign(['audit_id']);
            $table->$table->dropColumn('audit_id');
            $table->foreignUuid('audit_smkp_id')->after('user_id')->constrained()->cascadeOnDelete();
        });
       
    }
};
