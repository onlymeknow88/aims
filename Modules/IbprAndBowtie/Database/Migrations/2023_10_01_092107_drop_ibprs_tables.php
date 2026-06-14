<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('bowtie_teams');
        Schema::dropIfExists('bowtie_activity');
        Schema::dropIfExists('bowtie_event_cmf');
        Schema::dropIfExists('bowtie_event_repair_cmf');
        Schema::dropIfExists('bowtie_event_repair_imm');
        Schema::dropIfExists('bowtie_event_imm');
        Schema::dropIfExists('bowtie_cca');
        Schema::dropIfExists('bowtie_performance_standard');
        Schema::dropIfExists('bowtie_loss_calculation_detail');
        Schema::dropIfExists('bowtie_loss_calculation');
        Schema::dropIfExists('bowtie_events');
        Schema::dropIfExists('bowtie');
        Schema::dropIfExists('pica_ibpr');
        Schema::dropIfExists('ibpr_form_risk');
        Schema::dropIfExists('ibpr_teams');
        Schema::dropIfExists('ibpr_forms');
        Schema::dropIfExists('ibpr_master_bahaya');
        Schema::dropIfExists('ibpr_master_hirarki');
        Schema::dropIfExists('ibprs');
        Schema::dropIfExists('iadl_teams');
        Schema::dropIfExists('iadl_form_risk');
        Schema::dropIfExists('iadl_forms');
        Schema::dropIfExists('iadl');
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
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
