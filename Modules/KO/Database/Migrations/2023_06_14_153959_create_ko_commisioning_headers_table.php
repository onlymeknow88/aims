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
        Schema::create('ko_commissioning_headers', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('ko_spip_unit_id')
                ->nullable()
                ->references('id')
                ->on('ko_spip_units')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('number')->nullable();
            $table->string('header')->nullable();
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
        Schema::dropIfExists('ko_commisioning_headers');
    }
};
