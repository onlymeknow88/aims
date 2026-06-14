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

        // Schema::table('kplh_label', function (Blueprint $table) {

        // $table->dropForeign('kplh_label_pja_id_foreign');
        // $table->dropForeign('kplh_label_ktt_id_foreign');

        //     $table->foreign('pja_id');
        //     $table->foreign('ktt_id');
        // });

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
