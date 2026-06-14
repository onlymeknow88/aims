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
        if (Schema::hasTable('dashboard_banner')) {
            Schema::table('dashboard_banner', function (Blueprint $table) {
                !Schema::hasColumn('dashboard_banner', 'visible') ? $table->string('visible')->nullable() : null;
            });
        }

        if (Schema::hasTable('dashboard_slideshow')) {
            Schema::table('dashboard_slideshow', function (Blueprint $table) {
                !Schema::hasColumn('dashboard_slideshow', 'visible') ?  $table->string('visible')->nullable() : null;
            });
        }

        if (Schema::hasTable('dashboard_news_and_update')) {
            Schema::table('dashboard_news_and_update', function (Blueprint $table) {
                !Schema::hasColumn('dashboard_news_and_update', 'visible') ?  $table->string('visible')->nullable() : null;
            });
        }

        if (Schema::hasTable('dashboard_k3lh_activities')) {
            Schema::table('dashboard_k3lh_activities', function (Blueprint $table) {
                !Schema::hasColumn('dashboard_k3lh_activities', 'visible') ? $table->string('visible')->nullable() : null;
            });
        }

        if (Schema::hasTable('dashboard_k3lh_award')) {
            Schema::table('dashboard_k3lh_award', function (Blueprint $table) {
                !Schema::hasColumn('dashboard_k3lh_award', 'visible') ? $table->string('visible')->nullable() : null;
                !Schema::hasColumn('dashboard_k3lh_award', 'month') ? $table->timestamp('month')->nullable() : null;

            });
        }


        if (Schema::hasTable('dashboard_incident_notification')) {
            Schema::table('dashboard_incident_notification', function (Blueprint $table) {
                !Schema::hasColumn('dashboard_incident_notification', 'visible') ? $table->string('visible')->nullable() : null;
                !Schema::hasColumn('dashboard_incident_notification', 'description') ? $table->text('description')->nullable() : null;
                !Schema::hasColumn('dashboard_incident_notification', 'slug') ? $table->string('slug')->nullable() : null;
                !Schema::hasColumn('dashboard_incident_notification', 'attc') ? $table->string('attc')->nullable() : null;
                !Schema::hasColumn('dashboard_incident_notification', 'url') ? $table->string('url')->nullable() : null;
            });
        }

        if (Schema::hasTable('dashboard_general')) {
            Schema::table('dashboard_general', function (Blueprint $table) {
                !Schema::hasColumn('dashboard_general', 'month') ? $table->timestamp('month')->nullable() : null;
            });
        }

        if (Schema::hasTable('dashboard_safety_performance')) {
            Schema::table('dashboard_safety_performance', function (Blueprint $table) {
                !Schema::hasColumn('dashboard_safety_performance', 'month') ? $table->timestamp('month')->nullable() : null;
                !Schema::hasColumn('dashboard_safety_performance', 'visible') ? $table->string('visible')->nullable() : null;
            });
        }

        if (Schema::hasTable('dashboard_performance')) {
            Schema::table('dashboard_performance', function (Blueprint $table) {
                !Schema::hasColumn('dashboard_performance', 'month') ? $table->timestamp('month')->nullable() : null;
                !Schema::hasColumn('dashboard_performance', 'visible') ? $table->string('visible')->nullable() : null;
            });
        }

        if (Schema::hasTable('dashboard_strategic_project')) {
            Schema::table('dashboard_strategic_project', function (Blueprint $table) {
                !Schema::hasColumn('dashboard_strategic_project', 'visible') ? $table->string('visible')->nullable() : null;
            });
        }

        if (Schema::hasTable('dashboard_general')) {
            Schema::table('dashboard_general', function (Blueprint $table) {
                !Schema::hasColumn('dashboard_general', 'visible') ? $table->string('visible')->nullable() : null;
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
        //
    }
};
