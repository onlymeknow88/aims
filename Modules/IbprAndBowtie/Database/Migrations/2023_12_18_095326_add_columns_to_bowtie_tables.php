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
        Schema::table('bowtie_performance_standard', function (Blueprint $table) {
            $table->foreignUuid('cca_id')
                ->nullable()
                ->references('id')
                ->on('bowtie_cca')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('responsible_person')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
