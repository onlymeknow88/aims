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
        Schema::create('kplh_inspection_risks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('kplh_data_id')
                    ->nullable()
                    ->references('id')
                    ->on('kplh_inspection_data')
                    ->cascadeOnUpdate()
                    ->nullOnDelete();
            $table->uuid('pica_id');
            $table->string('risk_condition');
            $table->string('repair_action');
            $table->date('due_date');
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
        //
    }
};
