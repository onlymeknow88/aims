<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_plan_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('audit_plan_id')->constrained()->cascadeOnDelete();
            $table->longText('audit_scope')->nullable();
            $table->text('audit_criteria_reference')->nullable();
            $table->text('purpose')->nullable();
            $table->text('address')->nullable();
            $table->text('site_address')->nullable();
            $table->longText('relevant_document')->nullable();
            $table->longText('facility')->nullable();
            $table->longText('reporting_distribution')->nullable();
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
        Schema::dropIfExists('audit_plan_details');
    }
};
