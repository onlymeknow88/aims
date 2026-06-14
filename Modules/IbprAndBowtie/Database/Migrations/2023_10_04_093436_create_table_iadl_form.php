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
        Schema::create('iadl_forms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('iadl_id')
                ->nullable()
                ->references('id')
                ->on('iadl')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('activity')->nullable();
            $table->string('sub_activity')->nullable();
            $table->string('kondition')->nullable();
            $table->string('safety')->nullable();
            $table->string('incident_risk')->nullable();
            $table->string('safety_opportunity')->nullable();
            $table->string('relevant_legislation')->nullable();
            $table->integer('preliminary_consequence_lh')->nullable();
            $table->string('preliminary_frequence')->nullable();
            $table->string('preliminary_level_of_risk')->nullable();
            $table->string('preliminary_main_risk')->nullable();
            $table->string('modal_of_current')->nullable();
            $table->string('effective_control')->nullable();
            $table->integer('residual_consequence_lh')->nullable();
            $table->string('residual_level_of_risk')->nullable();
            $table->string('residual_main_risk')->nullable();
            $table->string('follow_risk')->nullable();
            $table->string('residual_frequence')->nullabel();
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
        Schema::dropIfExists('iadl_forms');
    }
};
