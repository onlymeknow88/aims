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
        Schema::create('ko_brands', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('ko_spip_category_id')
                ->nullable()
                ->references('id')
                ->on('ko_spip_categories')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('name')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('ko_brands');
    }
};
