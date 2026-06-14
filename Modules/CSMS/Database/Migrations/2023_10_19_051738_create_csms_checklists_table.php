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
        Schema::create('csms_checklists', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('bidding_id')
                ->nullable()
                ->references('id')
                ->on('biddings')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->text('question_id')->nullable();
            $table->string('point')->nullable();
            $table->string('sub_point')->nullable();
            $table->text('crtiteria')->nullable();
            $table->text('legal_base')->nullable();
            $table->text('note')->nullable();

            $table->string('value')->nullable();
            $table->text('comment')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('csms_checklists');
    }
};
