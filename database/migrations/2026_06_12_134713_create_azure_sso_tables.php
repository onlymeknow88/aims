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
        if (!Schema::hasTable('azure_tenants')) {
            Schema::create('azure_tenants', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('tenant_id');
                $table->string('client_id');
                $table->text('client_secret');
                $table->string('redirect_uri');
                $table->json('allowed_domains')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'microsoft_id')) {
                $table->string('microsoft_id')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'microsoft_token')) {
                $table->string('microsoft_token')->nullable()->after('microsoft_id');
            }
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('microsoft_token');
            }
            if (!Schema::hasColumn('users', 'azure_tenant_id')) {
                $table->foreignId('azure_tenant_id')->nullable()->after('avatar')
                      ->constrained('azure_tenants')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['azure_tenant_id']);
            $table->dropColumn(['microsoft_id', 'microsoft_token', 'avatar', 'azure_tenant_id']);
        });

        Schema::dropIfExists('azure_tenants');
    }
};
