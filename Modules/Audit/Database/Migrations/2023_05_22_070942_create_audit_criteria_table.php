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
        Schema::create('audit_criteria', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('audit_criteria_module_id')->constrained()->cascadeOnDelete();
            $table->foreignId('audit_master_criteria_id')->nullable()->constrained('audit_master_criteria')->nullOnDelete();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->boolean('excluded')->default(false);
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
        Schema::dropIfExists('audit_criteria');
    }
};
