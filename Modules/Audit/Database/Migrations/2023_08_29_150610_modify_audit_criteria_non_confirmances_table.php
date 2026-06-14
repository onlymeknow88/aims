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
        Schema::table('audit_criteria_non_confirmances', function(Blueprint $table) {
            $table->dropForeign(['audit_smkp_team_id']);
            $table->dropColumn('audit_smkp_team_id');
            $table->foreignUuid('audit_team_id')->after('category')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audit_criteria_non_confirmances', function(Blueprint $table) {
            $table->dropForeign(['audit_team_id']);
            $table->$table->dropColumn('audit_team_id');
            $table->foreignUuid('audit_smkp_team_id')->after('category')->constrained()->cascadeOnDelete();
        });
       
    }
};
