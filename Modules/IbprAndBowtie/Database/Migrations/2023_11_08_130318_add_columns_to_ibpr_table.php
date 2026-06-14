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
        Schema::table('ibpr_form_risk', function (Blueprint $table) {
            $table->integer('note')->nullable();
            $table->foreignUuid('bowtie_id')
                ->nullable()
                ->references('id')
                ->on('bowtie')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignUuid('ibpr_master_hirarki_id')
                ->nullable()
                ->references('id')
                ->on('ibpr_master_hirarki')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });

        Schema::table('iadl_form_risk', function (Blueprint $table) {
            $table->integer('note')->nullable();
            $table->foreignUuid('ibpr_master_hirarki_id')
                ->nullable()
                ->references('id')
                ->on('ibpr_master_hirarki')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });

        Schema::table('pica_ibpr', function (Blueprint $table) {
            $table->foreignUuid('ibpr_form_risk_id')
                ->nullable()
                ->references('id')
                ->on('ibpr_form_risk')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignUuid('iadl_form_risk_id')
                ->nullable()
                ->references('id')
                ->on('iadl_form_risk')
                ->cascadeOnUpdate()
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
        //
    }
};
