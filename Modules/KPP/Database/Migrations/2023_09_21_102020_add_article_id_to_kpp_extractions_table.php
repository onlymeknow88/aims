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
        Schema::table('kpp_extractions', function (Blueprint $table) {
            $table->foreignId('article_id')
                ->nullable()
                ->references('id')
                ->on('kpp_articles')
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
        Schema::table('kpp_extractions', function (Blueprint $table) {
            $table->dropColumn('article_id');
        });
    }
};
