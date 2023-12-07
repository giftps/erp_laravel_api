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
        Schema::create('service_provider_payment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_provider_id')->constrained('service_providers')->references('service_provider_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('bank');
            $table->string('account_name');
            $table->string('account_number');
            $table->string('branch_code')->nullable();
            $table->string('swift_code')->nullable();
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
        Schema::dropIfExists('service_provider_payment_details');
    }
};
