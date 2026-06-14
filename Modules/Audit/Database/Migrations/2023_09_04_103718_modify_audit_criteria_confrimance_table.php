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
        Schema::table('audit_criteria_confirmances', function(Blueprint $table) {
            $table->foreignUuid('audit_team_id')->after('status')->nullable()->constrained()->nullOnDelete();
            $table->date('auditor_date')->after('audit_team_id')->nullable();
            $table->string('auditee')->after('auditor_date')->nullable();
            $table->date('auditee_date')->after('auditee')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audit_criteria_confirmances', function(Blueprint $table) {
            $table->dropForeign(['audit_team_id']);
            $table->$table->dropColumn('audit_team_id');
            $table->dropColumn('auditor_date');
            $table->dropColumn('auditee');
            $table->dropColumn('auditee_date');
        });
       
    }
};
