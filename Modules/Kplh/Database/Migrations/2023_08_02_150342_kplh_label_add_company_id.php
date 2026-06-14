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
        Schema::table('kplh_label', function (Blueprint $table) {
            $table->after('maker', function ($table) {
                $table->foreignUuid('company_id')
                    ->nullable()
                    ->references('id')
                    ->on('companies')
                    ->cascadeOnUpdate()
                    ->nullOnDelete();
            });

            $table->after('department_id', function ($table) {
                $table->foreignUuid('section_id')
                    ->nullable()
                    ->references('id')
                    ->on('sections')
                    ->cascadeOnUpdate()
                    ->nullOnDelete();
            });
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
