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
        Schema::table('audit_notice_letters', function(Blueprint $table) {
            $table->string('original_name')->after('audit_id')->nullable();
        });

        Schema::table('audit_opening_attendances', function(Blueprint $table) {
            $table->string('original_name')->after('audit_id')->nullable();
        });

        Schema::table('audit_closing_attendances', function(Blueprint $table) {
            $table->string('original_name')->after('audit_id')->nullable();
        });

        Schema::table('audit_report_results', function(Blueprint $table) {
            $table->string('original_name')->after('audit_id')->nullable();
        });

        Schema::table('audit_response_audits', function(Blueprint $table) {
            $table->string('original_name')->after('audit_id')->nullable();
        });

        Schema::table('audit_another_attachments', function(Blueprint $table) {
            $table->string('original_name')->after('audit_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audit_notice_letters', function(Blueprint $table) {
            $table->dropColumn('original_name');
        });

        Schema::table('audit_opening_attendances', function(Blueprint $table) {
            $table->dropColumn('original_name');
        });

        Schema::table('audit_closing_attendances', function(Blueprint $table) {
            $table->dropColumn('original_name');
        });

        Schema::table('audit_report_results', function(Blueprint $table) {
            $table->dropColumn('original_name');
        });

        Schema::table('audit_response_audits', function(Blueprint $table) {
            $table->string('original_name')->after('audit_id')->nullable();
        });
       
        Schema::table('audit_another_attachments', function(Blueprint $table) {
            $table->string('original_name')->after('audit_id')->nullable();
        });
       
    }
};
