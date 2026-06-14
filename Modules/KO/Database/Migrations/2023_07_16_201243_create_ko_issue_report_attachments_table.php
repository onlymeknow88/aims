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
        Schema::create('ko_issue_report_attachments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('ko_issue_report_id')
                ->nullable()
                ->references('id')
                ->on('ko_issue_reports')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('attachment')->nullable();
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
        Schema::dropIfExists('ko_issue_report_attachments');
    }
};
