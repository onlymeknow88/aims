<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected array $tables = [
        'audit_notice_letters',
        'audit_opening_attendances',
        'audit_closing_attendances',
        'audit_response_audits',
        'audit_report_results',
        'audit_another_attachments',
        'audit_glossaries'
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) {
                    if (!Schema::hasColumn($table->getTable(), 'blob_url')) {
                        $table->string('blob_url')->nullable()->after('url');
                    }
                    if (!Schema::hasColumn($table->getTable(), 'blob_response')) {
                        $table->text('blob_response')->nullable()->after('blob_url');
                    }
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) {
                    if (Schema::hasColumn($table->getTable(), 'blob_url')) {
                        $table->dropColumn('blob_url');
                    }
                    if (Schema::hasColumn($table->getTable(), 'blob_response')) {
                        $table->dropColumn('blob_response');
                    }
                });
            }
        }
    }
};
