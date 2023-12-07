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
        Schema::create('scheme_benefit_amounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('year_id')->constrained('years')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('scheme_option_id')->constrained('scheme_options')->references('id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('benefit_option_id')->nullable()->constrained('benefit_options')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('currency_id')->nullable()->constrained('currencies')->references('id')->onDelete('set null')->cascadeOnUpdate();
            $table->double('limit_amount')->nullable();
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
        Schema::dropIfExists('scheme_benefit_amounts');
    }
};
