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
        Schema::create('bowtie_cca_bowtie_event', function (Blueprint $table) {
            $table->id();

            $table->char('cca_id');
            $table->char('event_id');


            // $table->foreign('category_id')->references('id')
            //      ->on('categories')->onDelete('cascade');
            // $table->foreign('post_id')->references('id')
            //     ->on('posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('');
    }
};
