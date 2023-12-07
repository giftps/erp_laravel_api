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
        Schema::create('scheme_option_benefit_options', function (Blueprint $table) {
            $table->foreignId('scheme_option_id')->constrained('scheme_options')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('benefit_option_id')->constrained('benefit_options')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scheme_option_benefit_options');
    }
};
