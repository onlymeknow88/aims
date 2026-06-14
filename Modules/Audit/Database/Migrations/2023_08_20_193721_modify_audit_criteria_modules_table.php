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
        Schema::table('audit_criteria_modules', function(Blueprint $table) {
            $table->dropForeign(['audit_smkp_id']);
            $table->dropColumn('audit_smkp_id');
            $table->foreignUuid('audit_id')->after('id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropForeign(['audit_id']);
        $table->renameColumn('audit_id', 'audit_smkp_id');
        $table->foreignUuid('audit_smkp_id')->constrained()->cascadeOnDelete();
    }
};
