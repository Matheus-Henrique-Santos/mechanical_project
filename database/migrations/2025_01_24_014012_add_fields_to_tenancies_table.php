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
        Schema::table('tenancies', function (Blueprint $table) {
            $table->foreign('user_principal')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('user_principal')->nullable()->after('id');
            $table->string('address')->nullable()->after('user_principal');
            $table->string('subdomain')->unique()->after('user_principal');
            $table->enum('type', ['pf', 'pj'])->nullable(false)->after('user_principal');
            $table->string('document')->unique()->nullable(false)->after('user_principal');
            $table->string('phone')->nullable()->after('user_principal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenancies', function (Blueprint $table) {
            //
        });
    }
};
