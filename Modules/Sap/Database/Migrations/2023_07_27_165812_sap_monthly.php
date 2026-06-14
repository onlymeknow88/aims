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
        if (!Schema::hasTable('sap_monthly')) {
            Schema::create('sap_monthly', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('user_id')->nullable();
                $table->uuid('employee_id')->nullable();
                $table->integer('year')->nullable();
                $table->decimal('january', 11, 2)->default(0)->nullable();
                $table->decimal('february', 11, 2)->default(0)->nullable();
                $table->decimal('march', 11, 2)->default(0)->nullable();
                $table->decimal('april', 11, 2)->default(0)->nullable();
                $table->decimal('may', 11, 2)->default(0)->nullable();
                $table->decimal('june', 11, 2)->default(0)->nullable();
                $table->decimal('july', 11, 2)->default(0)->nullable();
                $table->decimal('august', 11, 2)->default(0)->nullable();
                $table->decimal('september', 11, 2)->default(0)->nullable();
                $table->decimal('october', 11, 2)->default(0)->nullable();
                $table->decimal('november', 11, 2)->default(0)->nullable();
                $table->decimal('december', 11, 2)->default(0)->nullable();
                $table->decimal('total', 11, 2)->default(0)->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
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
