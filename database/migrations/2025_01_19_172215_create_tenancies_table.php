<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenanciesTable extends Migration
{
    public function up()
    {
        Schema::create('tenancies', function (Blueprint $table) {
            $table->id();
            $table->string('subdomain')->unique();
            $table->string('logo')->nullable(); // Logo do tenant
            $table->string('name')->nullable(); // Nome do tenant, usado caso não tenha logo
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tenancies');
    }
}

