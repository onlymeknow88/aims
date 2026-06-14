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
        Schema::create('biddings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('maker_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('criteria');
            $table->foreignUuid('ccow_id')
                ->nullable()
                ->references('id')
                ->on('companies')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->uuid('company_id')->nullable();
            $table->uuid('parent_id')->nullable();
            $table->uuid('business_entity_id');
            $table->string('company_name');
            $table->string('address');
            $table->string('company_site');
            $table->string('license_number');
            $table->string('service_criteria');
            $table->string('person_in_charge')->nullable();
            // $table->json('checklist')->nullable();
            // $table->json('questionnaire')->nullable();
            $table->string('status');
            $table->date('date')->nullable();
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
        Schema::dropIfExists('biddings');
    }
};
