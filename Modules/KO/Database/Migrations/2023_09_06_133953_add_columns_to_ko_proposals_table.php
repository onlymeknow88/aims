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
        Schema::table('ko_proposals', function (Blueprint $table) {
            $table->text('temporary_qr_reject_note')->after('status')->nullable();
            $table->string('temporary_qr_status')->after('status')->nullable();
            $table->text('commissioning_reject_note')->after('status')->nullable();
            $table->text('proposal_reject_note')->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ko_proposals', function (Blueprint $table) {
            $table->dropColumn('temporary_qr_reject_note');
            $table->dropColumn('temporary_qr_status');
            $table->dropColumn('commissioning_reject_note');
            $table->dropColumn('proposal_reject_note');
        });
    }
};
