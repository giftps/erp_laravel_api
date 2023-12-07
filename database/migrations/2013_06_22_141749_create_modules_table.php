<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Api\V1\UserAccess\Module;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->bigIncrements('module_id');
            $table->string('name');
            $table->timestamps();
        });

        Module::insert([
            ['name' => 'All'],
            ['name' => 'Sales'],
            ['name' => 'Membership'],
            ['name' => 'Pre-Authorizations'],
            ['name' => 'HealthCare Processing'],
            ['name' => 'Claims'],
            ['name' => 'Financial Reports'],
            ['name' => 'Administrations'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules');
    }
};
