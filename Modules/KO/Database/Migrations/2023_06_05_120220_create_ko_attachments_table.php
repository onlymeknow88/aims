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
        Schema::create('ko_attachments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('ko_proposal_id')
                ->nullable()
                ->references('id')
                ->on('ko_proposals')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('stnk')->nullable();
            $table->string('nota_pajak')->nullable();
            $table->string('surat_pengantar')->nullable();
            $table->string('re_manufacture')->nullable();
            $table->string('oem')->nullable();
            $table->string('dokumen_sertifikat')->nullable();
            $table->string('inspeksi_p3k')->nullable();
            $table->string('kir')->nullable();
            $table->string('uji_pjit')->nullable();
            $table->string('pra_komisioning')->nullable();
            $table->string('setting_radio')->nullable();
            $table->string('slo')->nullable();
            $table->string('komisioning_internal')->nullable();
            $table->string('com')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ko_attachments');
    }
};
