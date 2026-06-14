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
        Schema::table('kpp_rules', function (Blueprint $table) {
            $table->string('note')->after('status')->nullable();
            $table->foreignUuid('parent_rule_id')
                ->nullable()
                ->references('id')
                ->on('kpp_rules')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kpp_rules', function (Blueprint $table) {
            $table->dropColumn('note');
            $table->dropColumn('parent_rule_id');
        });
    }
};
