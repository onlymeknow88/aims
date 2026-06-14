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
        Schema::create('audit_implementation_activity_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('audit_implementation_activity_id');
            $table->foreign('audit_implementation_activity_id','implementation_id_idx')->references('id')->on('audit_implementation_activities')->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->dateTime('date')->nullable();
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
        Schema::dropIfExists('audit_implementation_activity_details');
    }
};
