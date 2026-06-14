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
        Schema::create('audit_sub_criteria', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('audit_criteria_id')->constrained('audit_criteria')->cascadeOnDelete();
            $table->foreignId('audit_master_sub_criteria_id')->nullable()->constrained('audit_master_sub_criteria')->nullOnDelete();
            $table->string('title');
            $table->boolean('has_point')->default(false);
            $table->integer('target_point')->nullable();
            $table->integer('max_point')->nullable();
            $table->integer('point')->nullable();
            $table->boolean('excluded')->default(false);
            $table->text('description')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
        Schema::table('audit_sub_criteria', function (Blueprint $table) {
            $table->foreignUuid('parent_id')->nullable()->constrained('audit_sub_criteria')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_sub_criteria');
    }
};
