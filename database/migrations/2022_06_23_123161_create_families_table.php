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
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->nullable()->constrained('groups')->references('id')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('subscription_period_id')->nullable()->constrained('subscription_periods')->references('id')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('broker_id')->nullable()->constrained('brokers')->references('broker_id')->onDelete('set null')->cascadeOnUpdate();
            $table->foreignId('group_type_id')->constrained('group_types')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('family_code');
            $table->string('unique_linker')->nullable();
            $table->string('physical_address')->nullable();
            $table->string('postal_address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('nearest_city')->nullable();
            $table->string('status');
            $table->string('nationality')->nullable();
            $table->date('application_date');
            $table->date('suspension_date')->nullable();
            $table->string('suspension_lifted_date')->nullable();
            $table->string('next_renewal_date')->nullable();
            $table->boolean('in_holding_tank')->default(false);
            $table->date('benefit_start_date')->nullable();
            $table->date('benefit_end_date')->nullable();
            $table->string('resign_code')->nullable();
            $table->boolean('has_funeral_cash_benefit')->default(false);
            $table->boolean('is_underwritten')->default(false);
            $table->string('digital_signature')->nullable();
            $table->date('funeral_benefit_start_date')->nullable();
            $table->date('funeral_benefit_end_date')->nullable();
            $table->string('beneficiary_name')->nullable();
            $table->string('beneficiary_mobile_number')->nullable();
            $table->string('registration_token')->nullable();
            $table->timestamp('token_expires_at')->nullable();
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
        Schema::dropIfExists('families');
    }
};
