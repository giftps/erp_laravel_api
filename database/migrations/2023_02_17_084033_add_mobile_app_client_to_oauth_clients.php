<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
        DB::table('oauth_clients')->insert([
            [
                'name' => 'Mobile App Client', 
                'secret' => 'PxAccw0XTaE5U7DO1g54C635xn2tsnp0zPBDlkkV', 
                'provider' => 'members', 
                'redirect' => 'http://localhost', 
                'personal_access_client' => 0, 
                'password_client' => 1, 
                'revoked' => 0
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
};
