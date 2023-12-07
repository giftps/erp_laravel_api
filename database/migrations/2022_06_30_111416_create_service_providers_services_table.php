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
        Schema::create('service_providers_services', function (Blueprint $table) {
            $table->foreignId('service_provider_id')->constrained('service_providers')->references('service_provider_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('service_id')->constrained('services')->references('service_id')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_providers_services');
    }
};
