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
        Schema::create('preauthorisation_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('preauthorisation_id')->constrained('preauthorisations')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('service_price_id')->constrained('product_or_service_prices')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('preauthorisation_services');
    }
};
