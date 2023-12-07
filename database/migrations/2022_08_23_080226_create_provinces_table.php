<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Api\V1\Lookups\Province;
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
        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained('countries')->references('id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->timestamps();
        });

        Province::insert([
            ['country_id' => Country::where('name', '=', 'Zambia')->first()->id, 'name' => 'Central Province'],
            ['country_id' => Country::where('name', '=', 'Zambia')->first()->id, 'name' => 'Copperbelt Province'],
            ['country_id' => Country::where('name', '=', 'Zambia')->first()->id, 'name' => 'Eastern Province'],
            ['country_id' => Country::where('name', '=', 'Zambia')->first()->id, 'name' => 'Luapula Province'],
            ['country_id' => Country::where('name', '=', 'Zambia')->first()->id, 'name' => 'Lusaka Province'],
            ['country_id' => Country::where('name', '=', 'Zambia')->first()->id, 'name' => 'Muchinga Province'],
            ['country_id' => Country::where('name', '=', 'Zambia')->first()->id, 'name' => 'Northern Province'],
            ['country_id' => Country::where('name', '=', 'Zambia')->first()->id, 'name' => 'North-Western Province'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provinces');
    }
};
