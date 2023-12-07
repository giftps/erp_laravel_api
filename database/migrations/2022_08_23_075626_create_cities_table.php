<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Api\V1\Lookups\City;
use App\Models\Api\V1\Lookups\Country;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained('countries')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->timestamps();
        });

        City::insert([
            ['country_id' => Country::where('name', '=', 'Zambia')->first()->id, 'name' => 'Lusaka'],
            ['country_id' => Country::where('name', '=', 'Zambia')->first()->id, 'name' => 'Kitwe'],
            ['country_id' => Country::where('name', '=', 'Zambia')->first()->id, 'name' => 'Ndola'],
            ['country_id' => Country::where('name', '=', 'Zambia')->first()->id, 'name' => 'Livingstone'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
};
