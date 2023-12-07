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
        Schema::create('service_providers', function (Blueprint $table) {
            $table->bigIncrements('service_provider_id');
            $table->foreignId('discipline_id')->nullable()->constrained('disciplines')->references('discipline_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('pay_currency_id')->nullable()->constrained('currencies')->references('id')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('receive_currency_id')->nullable()->constrained('currencies')->references('id')->onDelete('set null')->cascadeOnUpdate();
            $table->string('name');
            $table->string('mobile_number');
            $table->string('email')->unique();
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->string('address3')->nullable();
            $table->string('country');
            $table->string('practice_number');
            $table->boolean('is_group_practice')->default(false);
            $table->string('provider_category');
            $table->string('provider_type');
            $table->boolean('is_ses_network_provider')->default(false);
            $table->boolean('sla')->default(false);
            $table->integer('payment_term_days');
            $table->double('discount');
            $table->integer('tier_level');
            $table->date('activation_date');
            $table->date('end_date')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('service_providers');
    }
};
