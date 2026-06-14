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
        Schema::create('kpp_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('rule_id')
                ->nullable()
                ->references('id')
                ->on('kpp_rules')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('name')->nullable();
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
        Schema::dropIfExists('kpp_articles');
    }
};
