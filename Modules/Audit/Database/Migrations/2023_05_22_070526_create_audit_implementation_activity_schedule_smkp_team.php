<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_implementation_activity_schedule_smkp_team', function (Blueprint $table) {

            $table->uuid('audit_smkp_team_id');
            $table->foreign('audit_smkp_team_id', 'smkp_team_id_idx')
                ->references('id')
                ->on('audit_smkp_teams')
                ->cascadeOnDelete();

            $table->uuid('audit_implementation_activity_detail_schedule_id');
            $table->foreign('audit_implementation_activity_detail_schedule_id', 'implementation_detail_schedule_id_idx')
                ->references('id')
                ->on('audit_implementation_activity_detail_schedules')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_implementation_activity_schedule_smkp_team');
    }
};
