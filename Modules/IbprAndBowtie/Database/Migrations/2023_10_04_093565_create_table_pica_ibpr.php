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
        Schema::create('pica_ibpr', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('iadl_form_id')
                ->nullable()
                ->references('id')
                ->on('iadl_forms')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignUuid('ibpr_form_id')
                ->nullable()
                ->references('id')
                ->on('ibpr_forms')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('plan')->nullable();
            $table->date('review_date')->nullable();
            $table->date('target_date')->nullable();
            $table->string('attachment')->nullable();
            $table->string('status')->nullable();
            $table->string('attachment_name')->nullable();
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
        Schema::dropIfExists('pica_ibpr');
    }
};
