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
        Schema::create('field_leadership_risks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('fl_id')
                ->nullable()
                ->references('id')
                ->on('field_leaderships')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('risk_condition');
            $table->foreignUuid('category_id')
                ->nullable()
                ->references('id')
                ->on('field_leadership_categories')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignUuid('type_id')
                ->nullable()
                ->references('id')
                ->on('field_leadership_kta_and_ttas')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignUuid('potency_id')
                ->nullable()
                ->references('id')
                ->on('field_leadership_potency_and_consequnces')
                ->cascadeOnUpdate()
                ->nullOnDelete();
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
        Schema::dropIfExists('field_leadership_risks');
    }
};
