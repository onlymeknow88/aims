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
        Schema::create('field_leadership_risk_files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('fl_risk_id')
                ->nullable()
                ->references('id')
                ->on('field_leadership_risks')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('file');
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
        Schema::dropIfExists('field_leadership_risk_files');
    }
};
