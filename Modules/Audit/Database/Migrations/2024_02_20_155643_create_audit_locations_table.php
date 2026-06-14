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
        Schema::create('audit_locations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('audit_id')->constrained()->cascadeOnDelete();
            $table->string('location')->nullable();
            $table->string('status')->nullable();
            $table->tinyInteger('is_critical')->default(0);
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
        Schema::dropIfExists('audit_locations');
    }
};
