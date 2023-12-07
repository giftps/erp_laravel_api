<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Api\V1\UserAccess\Role;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Role::insert([
            ['name' => 'Claims Admin', 'status' => 'active'],
            ['name' => 'Assessor', 'status' => 'active']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('roles')->where('name', '=', 'Claims Admin')->where('name', '=', 'Assessor')->delete();
    }
};
