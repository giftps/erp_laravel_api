<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Api\V1\Lookups\DoctorFlagType;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_flag_types', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->timestamps();
        });

        DoctorFlagType::insert([
            ['description' => 'Zambian Providers'],
            ['description' => 'South African Providers'],
            ['description' => 'Other International Providers'],
            ['description' => 'Zambian Providers (Tier 1)'],
            ['description' => 'Zambian Providers (Tier 2)'],
            ['description' => 'Indian Providers'],
            ['description' => 'Europe Providers'],
            ['description' => 'UK Providers'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctor_flag_types');
    }
};
