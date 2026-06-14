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
        Schema::create('csms_master_data_checklist', function (Blueprint $table) {
            $table->id();
            $table->string('point');
            $table->string('sub_point')->nullable();
            $table->text('crtiteria');
            $table->text('legal_base')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('csms_master_data_checklist');
    }
};
