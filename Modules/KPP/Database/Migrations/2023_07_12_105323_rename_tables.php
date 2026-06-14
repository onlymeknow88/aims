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
        Schema::rename('agency_authorities', 'kpp_agency_authorities');
        Schema::rename('extractions', 'kpp_extractions');
        Schema::rename('extraction_files', 'kpp_extraction_files');
        Schema::rename('extraction_transactions', 'kpp_extraction_transactions');
        Schema::rename('obediences', 'kpp_obediences');
        Schema::rename('obedience_emails', 'kpp_obedience_emails');
        Schema::rename('obedience_requests', 'kpp_obedience_requests');
        Schema::rename('rules', 'kpp_rules');
        Schema::rename('rule_files', 'kpp_rule_files');
        Schema::rename('rule_types', 'kpp_rule_types');
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
