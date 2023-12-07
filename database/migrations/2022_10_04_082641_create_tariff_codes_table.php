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
        Schema::create('tariff_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_provider_id')->constrained('service_providers')->references('service_provider_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('claim_code_id')->constrained('claim_codes')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('tariff_code');
            $table->string('amount');
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
        Schema::dropIfExists('tariff_codes');
    }
};
