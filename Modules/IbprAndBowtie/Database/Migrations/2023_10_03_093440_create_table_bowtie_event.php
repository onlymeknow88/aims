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
        Schema::create('bowtie_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('bowtie_id')
                ->nullable()
                ->references('id')
                ->on('bowtie')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->string('risk_title')->nullable();
            $table->string('description')->nullable();
            $table->string('reason')->nullable();
            $table->string('impact_k3')->nullable();
            $table->string('impact_lh')->nullable();
            $table->string('impact_ksl')->nullable();
            $table->string('impact_kp')->nullable();
            $table->string('impact_kk')->nullable();
            $table->string('k3_severity')->nullable();
            $table->string('k3_max_loss')->nullable();
            $table->string('lh_severity')->nullable();
            $table->string('lh_max_loss')->nullable();
            $table->string('ksl_severity')->nullable();
            $table->string('ksl_max_loss')->nullable();
            $table->string('kp_severity')->nullable();
            $table->string('kp_max_loss')->nullable();
            $table->string('kk_severity')->nullable();
            $table->string('kk_max_loss')->nullable();
            $table->string('severity_factor')->nullable();
            $table->string('severity_explain')->nullable();
            $table->string('likelihood_factor')->nullable();
            $table->string('likelihood_explain')->nullable();
            $table->string('trr_factor')->nullable();
            $table->string('trr_explanation')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bowtie_events');
    }
};
