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
        Schema::create('audit_sub_criteria_sample_methods', function (Blueprint $table) {
            $table->uuid('audit_sub_criteria_id');
            $table->foreign('audit_sub_criteria_id','sub_criteria_sample_method_sub_criteria_id_foreign')
                ->references('id')
                ->on('audit_sub_criteria')
                ->cascadeOnDelete();
            $table->foreignId('audit_method_id')->constrained()->cascadeOnDelete();
            $table->text('sample')->nullable();
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
        Schema::dropIfExists('audit_sub_criteria_sample_methods');
    }
};
