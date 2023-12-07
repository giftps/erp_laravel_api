<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Api\V1\UserAccess\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('role_id');
            $table->string('name');
            $table->string('status');
            $table->timestamps();
        });

        Role::insert([
            ['name' => 'Super Admin', 'status' => 'active'],
            ['name' => 'Membership Admin', 'status' => 'active'],
            ['name' => 'Call Center Admin', 'status' => 'active'],
            ['name' => 'Sales Admin', 'status' => 'active'],
            ['name' => 'Finance Admin', 'status' => 'active'],
            ['name' => 'Broker House Admin', 'status' => 'active'],
            ['name' => 'Employee', 'status' => 'active'],
            ['name' => 'Member', 'status' => 'active'],
            ['name' => 'Broker', 'status' => 'active'],
            ['name' => 'Health Care Provider', 'status' => 'active'],
            ['name' => 'Underwriter', 'status' => 'active'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
