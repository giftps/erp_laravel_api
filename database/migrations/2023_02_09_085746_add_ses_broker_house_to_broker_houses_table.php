<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Api\V1\Sales\BrokerHouse;

use Illuminate\Support\Facades\Hash;

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

        $user = new \App\Models\User;
        $user->unique_id = 'SESBH737';
        $user->first_name = 'SES';
        $user->last_name = 'Broker House';
        $user->role_id = Role::where('name', '=', 'Broker House Admin')->first()->role_id;
        $user->email = 'brokerhouse@ses-unisure.com';
        $user->phone_number = 'N/A';
        $user->is_active = true;
        $user->password = Hash::make('12345678');
        $user->save();

        $broker_house = new BrokerHouse;
        $broker_house->broker_type_id = 1;
        $broker_house->name = 'SES Broker House';
        $broker_house->code = 'SESBH737';
        $broker_house->user_id = $user->user_id;
        $broker_house->address1 = 'Address';
        $broker_house->city = 'Lusaka';
        $broker_house->contact_person_name = 'SES Broker House';
        $broker_house->contact_person_email = 'brokerhouse@ses-unisure.com';
        $broker_house->mobile_number = 'N/A';
        $broker_house->website_address = 'none';
        $broker_house->status = 'active';
        $broker_house->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\Models\User::where('unique_id', '=', 'SESBH737')->first()->delete();
        BrokerHouse::where('code', '=', 'SESBH737')->first()->delete();
    }
};
