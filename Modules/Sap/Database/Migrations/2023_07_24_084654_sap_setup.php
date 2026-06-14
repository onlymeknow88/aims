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
        Schema::create('sap_setup', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->nullable();
            $table->uuid('category_id')->nullable();
            $table->string('available')->nullable();
            $table->string('slug')->nullable();
            $table->string('safety_accountability_progam')->nullable();
            $table->decimal('dept_head',11,2)->nullable();
            $table->decimal('foreman_supervisor_sechead',11,2)->nullable();
            $table->decimal('employee',11,2)->nullable();
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
        //
    }
};
