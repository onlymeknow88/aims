<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tables = [
        'dashboard_slideshow',
        'dashboard_banner',
        'dashboard_attachment',
        'dashboard_news_and_update',
        'dashboard_incident_notification',
        'dashboard_strategic_project',
        'dashboard_k3lh_activities',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                if (!Schema::hasColumn($table->getTable(), 'blob_url')) {
                    $table->string('blob_url')->nullable()->after('url');
                }
                if (!Schema::hasColumn($table->getTable(), 'blob_response')) {
                    $table->longText('blob_response')->nullable()->after('blob_url');
                }
            });
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
};

