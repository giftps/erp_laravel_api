<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Api\V1\Lookups\AuthType;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_types', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->timestamps();
        });

        AuthType::insert([
            ['id' => 1, 'description' => 'Out Patient Visit'],
            ['id' => 2, 'description' => 'Elective Admission'],
            ['id' => 3, 'description' => 'Emergency Admission'],
            ['id' => 4, 'description' => 'Dental'],
            ['id' => 5, 'description' => 'Optical'],
            ['id' => 6, 'description' => 'Wellness'],
            ['id' => 7, 'description' => 'Pregnancy'],
            ['id' => 8, 'description' => 'Emergency Ambulance'],
            ['id' => 9, 'description' => 'Aeromedical Evacuation'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_types');
    }
};
