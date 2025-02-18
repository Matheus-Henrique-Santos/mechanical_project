<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            if (Schema::hasColumn('tenants', 'type')) {
                $table->dropColumn('type');
            }
            if (Schema::hasColumn('tenants', 'document')) {
                $table->dropColumn('document');
            }
            if (Schema::hasColumn('tenants', 'data')) {
                $table->dropColumn('data');
            }
            if (Schema::hasColumn('tenants', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('tenants', 'user_principal')) {
                $table->dropForeign(['user_principal']);
                $table->dropColumn('user_principal');
            }
        });

        Schema::table('tenants', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->string('cnpj', 20)->nullable()->after('name');
            $table->string('logo_path')->nullable();

            $table->string('zip_code', 12)->nullable();
            $table->string('street')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city')->nullable();
            $table->string('number', 20)->nullable();
            $table->string('complement')->nullable();

            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            //
        });
    }
};
