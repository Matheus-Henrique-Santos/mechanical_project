<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('main_user_id')->constrained('users');
            $table->string('subdomain')->unique();

            $table->string('name')->nullable();
            $table->string('cellphone')->nullable();
            $table->string('cnpj', 20)->nullable();
            $table->string('logo_path')->nullable();
            $table->string('zip_code', 12)->nullable();
            $table->string('street')->nullable();
            $table->string('number', 20)->nullable();
            $table->string('city')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('complement')->nullable();
            $table->string('uf', 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
}
