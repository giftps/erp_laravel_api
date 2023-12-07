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
        Schema::create('family_scheme_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_id')->constrained('families')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('benefit_start_date')->nullable();
            $table->string('benefit_end_date')->nullable();
            $table->boolean('has_funeral_cash_benefit');
            $table->string('funeral_benefit_start_date')->nullable();
            $table->string('funeral_benefit_end_date')->nullable();
            $table->string('beneficiary_name')->nullable();
            $table->string('beneficiary_mobile_number')->nullable();
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
        Schema::dropIfExists('family_scheme_details');
    }
};
