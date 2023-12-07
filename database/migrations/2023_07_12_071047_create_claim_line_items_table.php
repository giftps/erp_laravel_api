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
        Schema::create('claim_line_items', function (Blueprint $table) {
            $table->id();
            $table->string('tariff_code');
            $table->string('claim_code');
            $table->string('diagnosis');
            $table->string('icd10');
            $table->string('currency');
            $table->double('amount');
            $table->date('date_of_service');
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
        Schema::dropIfExists('claim_line_items');
    }
};
