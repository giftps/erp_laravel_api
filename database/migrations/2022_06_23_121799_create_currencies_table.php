<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Api\V1\Lookups\Currency;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('symbol');
            $table->string('code');
            $table->string('description');
            $table->timestamps();
        });

        Currency::insert([
            ['symbol' => '$', 'code' => 'USD', 'description' => 'United States Dollar'],
            ['symbol' => 'K', 'code' => 'ZMW', 'description' => 'Zambian Kwacha'],
            ['symbol' => 'R', 'code' => 'ZAR', 'description' => 'South African Rand'],
            ['symbol' => '₹', 'code' => 'INR', 'description' => 'Indian Rupees']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
};
