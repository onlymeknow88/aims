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
        Schema::create('audit_man_days_risk_severity', function (Blueprint $table) {
            $table->foreignId('audit_man_days_id')->constrained()->cascadeOnDelete();
            $table->foreignId('audit_risk_severity_id')->constrained()->cascadeOnDelete();
            $table->float('value');

            $table->unique(['audit_man_days_id','audit_risk_severity_id'],'man_day_severity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_man_days_risk_severity');
    }
};
