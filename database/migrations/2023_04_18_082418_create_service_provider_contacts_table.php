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
        Schema::create('service_provider_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_provider_id')->constrained('service_providers')->references('service_provider_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('designation');
            $table->string('contact_number')->nullable();
            $table->string('mobile_number');
            $table->string('email');
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
        Schema::dropIfExists('service_provider_contacts');
    }
};
