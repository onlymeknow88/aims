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
        Schema::create('sap_monthly_employee', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->nullable();
            $table->uuid('category_id')->nullable();
            $table->string('slug')->nullable();
            $table->string('jde')->nullable();
            $table->string('name')->nullable();
            $table->string('position')->nullable();
            $table->string('dept')->nullable();
            $table->string('grade')->nullable();
            // $table->string('january')->nullable();
            // $table->string('february')->nullable();
            // $table->string('march')->nullable();
            // $table->string('april')->nullable();
            // $table->string('may')->nullable();
            // $table->string('june')->nullable();
            // $table->string('july')->nullable();
            // $table->string('august')->nullable();
            // $table->string('september')->nullable();
            // $table->string('october')->nullable();
            // $table->string('november')->nullable();
            // $table->string('december')->nullable();
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
