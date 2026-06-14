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
        Schema::table('ko_units', function (Blueprint $table) {
            $table->foreignUuid('ko_brand_id')
                ->after('serial_number')
                ->nullable()
                ->references('id')
                ->on('ko_brands')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ko_units', function (Blueprint $table) {
            $table->dropColumn('brand_id');
        });
    }
};
