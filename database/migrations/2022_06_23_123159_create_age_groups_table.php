<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Api\V1\Lookups\AgeGroup;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('age_groups', function (Blueprint $table) {
            $table->id();
            $table->integer('min_age');
            $table->integer('max_age')->nullable();
            $table->timestamps();
        });

        AgeGroup::insert([
            ['min_age' => 0, 'max_age' => 20],
            ['min_age' => 21, 'max_age' => 25],
            ['min_age' => 26, 'max_age' => 30],
            ['min_age' => 31, 'max_age' => 35],
            ['min_age' => 36, 'max_age' => 40],
            ['min_age' => 41, 'max_age' => 45],
            ['min_age' => 46, 'max_age' => 50],
            ['min_age' => 51, 'max_age' => 55],
            ['min_age' => 56, 'max_age' => 60],
            ['min_age' => 61, 'max_age' => 65],
            ['min_age' => 66, 'max_age' => 70],
            ['min_age' => 71, 'max_age' => 75],
            ['min_age' => 76, 'max_age' => 80],
            ['min_age' => 80, 'max_age' => null]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('age_groups');
    }
};
