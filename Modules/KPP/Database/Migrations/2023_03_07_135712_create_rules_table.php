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
        Schema::create('rules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('number');
            $table->string('title');
            $table->foreignUuid('rule_type_id')
                ->nullable()
                ->references('id')
                ->on('rule_types')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignUuid('agency_authority_id')
                ->nullable()
                ->references('id')
                ->on('agency_authorities')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->longText('description')->nullable();
            $table->foreignUuid('created_by')
                ->nullable()
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->date('approved_date')->nullable();
            $table->date('effective_date')->nullable();
            $table->date('expired_date')->nullable();
            $table->string('status');
            $table->tinyInteger('is_draft')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rules');
    }
};
