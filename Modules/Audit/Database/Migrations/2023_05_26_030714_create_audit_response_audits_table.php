<?php

use Modules\Audit\Enums\SubBundleStatusEnum;
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
        Schema::create('audit_response_audits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('audit_smkp_id')->constrained()->cascadeOnDelete();
            $table->string('url')->nullable();
            $table->string('status')->default(SubBundleStatusEnum::DRAFT);
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
        Schema::dropIfExists('audit_response_audits');
    }
};
