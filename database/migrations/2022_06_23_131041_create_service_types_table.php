<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Api\V1\ServiceProviders\ServiceType;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_types', function (Blueprint $table) {
            $table->bigIncrements('service_type_id');
            $table->string('name');
            $table->string('status');
            $table->timestamps();
        });

        ServiceType::insert([
            ['name' => 'Audiologists', 'status' => 'active'],
            ['name' => 'Clinics', 'status' => 'active'],
            ['name' => 'Dental Clinics', 'status' => 'active'],
            ['name' => 'Hospitals', 'status' => 'active'],
            ['name' => 'Laboratories', 'status' => 'active'],
            ['name' => 'Medical Centre', 'status' => 'active'],
            ['name' => 'Ophthalmology', 'status' => 'active'],
            ['name' => 'Optometrists', 'status' => 'active'],
            ['name' => 'Pathologists', 'status' => 'active'],
            ['name' => 'Pharmacies', 'status' => 'active'],
            ['name' => 'Radiologists', 'status' => 'active'],
            ['name' => 'Specialists - Other', 'status' => 'active'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_types');
    }
};
