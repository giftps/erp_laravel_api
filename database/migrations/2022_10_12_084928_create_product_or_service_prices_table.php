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
        Schema::create('product_or_service_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_provider_id')->constrained('service_providers')->references('service_provider_id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('service_type_id')->constrained('service_types')->references('service_type_id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('claim_code_id')->constrained('claim_codes')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('tariff_code');
            $table->string('name');
            $table->double('amount');
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
        Schema::dropIfExists('product_or_service_prices');
    }
};
