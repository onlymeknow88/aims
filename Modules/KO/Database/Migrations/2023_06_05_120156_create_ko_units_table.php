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
        Schema::create('ko_units', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('ko_spip_unit_id')
                ->nullable()
                ->references('id')
                ->on('ko_spip_units')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('call_sign');
            $table->string('identity_number')->nullable();
            $table->string('brand');
            $table->string('serial_number');
            $table->string('model_unit')->nullable();
            $table->year('production_year');
            $table->integer('commissioning_count')->default(0);
            $table->tinyInteger('is_revoked')->default(0);
            $table->date('revoked_date')->nullable();
            $table->date('revoke_requested_date')->nullable();
            $table->string('revoke_request_note')->nullable();
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
        Schema::dropIfExists('ko_units');
    }
};
