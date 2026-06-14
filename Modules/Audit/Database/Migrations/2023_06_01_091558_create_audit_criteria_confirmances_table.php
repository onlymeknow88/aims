<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_criteria_confirmances', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('audit_sub_criteria_id')->constrained('audit_sub_criteria')->cascadeOnDelete();
            $table->text('fix_recommendation')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('audit_criteria_confirmances');
    }
};
