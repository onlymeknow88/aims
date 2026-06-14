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
        Schema::create('audit_master_sub_criteria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('audit_master_criteria_id')->constrained('audit_master_criteria')->cascadeOnDelete();
            $table->string('title');
            $table->boolean('has_point')->default(false);
            $table->integer('target_point')->nullable();
            $table->integer('max_point')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('audit_master_sub_criteria', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->constrained('audit_master_sub_criteria')->cascadeOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_master_sub_criteria');
    }
};
