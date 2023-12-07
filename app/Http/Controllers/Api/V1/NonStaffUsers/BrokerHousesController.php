<?php

namespace App\Http\Controllers\Api\V1\NonStaffUsers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Api\V1\UserAccess\Role;

use Illuminate\Support\Facades\Hash;

use App\Models\Api\V1\Sales\Broker;

use App\Models\Api\V1\Sales\BrokerHouse;

use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Api\V1\Membership\Family;
use App\Models\Api\V1\Membership\Member;
use App\Http\Resources\Api\V1\Sales\BrokerHousesResource;
use App\Http\Resources\Api\V1\Sales\BrokersResource;
use App\Notifications\BrokerRegistration;
use App\Http\Resources\Api\V1\Membership\MembersResource;

class BrokerHousesController extends Controller
{
    // Getting the logged in broker house information
    public function brokerHouseDetails(){
        return response()->json(new BrokerHousesResource(auth('api')->user()->brokerHouse));
    }

    public function editBrokerHouse(Request $request){
        $this->validate($request, [
            'name' => 'required|string',
            'address1' => 'required|string',
            'city' => 'required|string',
            'contact_person_name' => 'required|string',
            'mobile_number' => 'required|string',
            'website_address' => 'required|string',
        ]);

        $user = auth()->user();

        $suffix = str_pad($user->brokerHouse->broker_house_id, 3, '0', STR_PAD_LEFT);
        $code = substr(strtoupper($request->name), 0, 4) . $suffix;

        $broker_house = BrokerHouse::find($user->brokerHouse->broker_house_id);
        $broker_house->name = $request->name;
        $broker_house->code = $code;
        $broker_house->address1 = $request->address1;
        $broker_house->address2 = $request->address2;
        $broker_house->city = $request->city;
        $broker_house->contact_person_name = $request->contact_person_name;
        $broker_house->office_number = $request->office_number;
        $broker_house->mobile_number = $request->mobile_number;
        $broker_house->website_address = $request->website_address;
        $broker_house->save();

        return response()->json(['msg' => 'saved successfully!', 'status' => 200], 200);
    }

    // Getting all brokers under this broker house
    public function brokers(){
        return response()->json(BrokersResource::collection(auth('api')->user()->brokerHouse->brokers));
    }

    // Getting a single broker under this broker house
    public function brokerDetails($id){
        $brokers_details = auth('api')->user()->brokerHouse->brokers()->find($id);

        if($brokers_details){
            return response()->json(new BrokersResource($brokers_details));
        }else{
            return response()->json(['msg' => 'broker not found', 'status' => 404], 404);
        }
    }

    // Getting main members under a broker with the passed id.
    public function brokerMembers($id){
        $family_ids = Family::where('broker_id', '=', $id)->pluck('id');
        if(!$family_ids){
            return response()->json(['msg' => 'not found', 'status' => 404], 404);
        }

        $members = Member::whereIn('family_id', $family_ids)->get();

        return response()->json(MembersResource::collection($members));
    }

    // Getting all main members the logged in broker house
    public function brokerHouseMembers(){
        // Getting the ids of all the brokers under this broker house
        $broker_ids = auth()->user()->brokerHouse->brokers()->pluck('broker_id');

        // Checking if no ids where found
        if(!$broker_ids){
            return response()->json(['msg' => 'no members found', 'status' => 404], 404);
        }

        // Getting the family ids that belong to the selected broker houses
        $family_ids = Family::whereIn('broker_id', $broker_ids)->pluck('id');

        // Getting the members
        $broker_members = Member::whereIn('family_id', $family_ids)->get();
        return response()->json(MembersResource::collection($broker_members));
    }

    // Adding a broker to the broker house
    public function addBroker(Request $request){
        $this->validate($request, [
            'title' => 'required|string',
            'first_name' => 'required|string',
            'surname' => 'required|string',
            'id_number' => 'required|string',
            'address1' => 'required|string',
            'city' => 'required|string',
            'office_number' => 'required|string',
            'mobile_number' => 'required|string',
            'email' => 'required|string|unique:brokers',
            'status' => 'required|string',
            'nrc' => 'nullable|sometimes'
        ]);

        // Generating the code for the broker house
        $broker_id = Broker::all()->last();
        $nextId = ($broker_id === null ? 0 : $broker_id->broker_id) + 1;
        $suffix = str_pad($nextId, 3, '0', STR_PAD_LEFT);
        $code = substr(strtoupper($request->first_name), 0, 4) . $suffix;

        $broker = new Broker;
        $broker->broker_house_id = auth('api')->user()->brokerHouse->broker_house_id;
        $broker->code = $code;
        $broker->title = $request->title;
        $broker->first_name = $request->first_name;
        $broker->surname = $request->surname;
        $broker->id_number = $request->id_number;
        $broker->address1 = $request->address1;
        $broker->address2 = $request->address2;
        $broker->city = $request->city;
        $broker->office_number = $request->office_number;
        $broker->phone_number = $request->mobile_number;
        $broker->email = $request->email;
        $broker->status = $request->status;

        if($request->nrc){
            $broker->nrc = storeFile($request->nrc, str_replace(" ", "_", 'broker_nrc'));
        }

        if($request->status === 'active'){
            $broker->active_date = date('Y-m-d H:i:s');
        }

        $broker->save();

        // Creating the user and getting the user id of the created user.
        $user_id = $this->createUser($request, '', 'post');

        // Updating the user id on the brokers table
        $broker->user_id = $user_id;
        $broker->save();

        return response()->json(['msg' => 'saved successfully!', 'status' => 200], 200);
    }

    // Updating the broker
    public function updateBroker(Request $request, $id){
        $this->validate($request, [
            'title' => 'required|string',
            'first_name' => 'required|string',
            'surname' => 'required|string',
            'id_number' => 'required|string',
            'address1' => 'required|string',
            'city' => 'required|string',
            'office_number' => 'required|string',
            'mobile_number' => 'required|string',
            'email' => 'required|string|unique:brokers,email,'.$id.',broker_id',
            'status' => 'required|string',
            'nrc' => 'nullable|sometimes'
        ]);

        // Generating the code for the broker house
        $broker_id = Broker::all()->last();
        $nextId = ($broker_id === null ? 0 : $broker_id->broker_id) + 1;
        $suffix = str_pad($nextId, 3, '0', STR_PAD_LEFT);
        $code = substr(strtoupper($request->first_name), 0, 4) . $suffix;
        
        $broker = auth('api')->user()->brokerHouse->brokers()->where('broker_id', '=', $id)->first();

        if ($broker){
            $broker->broker_house_id = auth('api')->user()->brokerHouse->broker_house_id;
            $broker->code = $code;
            $broker->title = $request->title;
            $broker->first_name = $request->first_name;
            $broker->surname = $request->surname;
            $broker->id_number = $request->id_number;
            $broker->address1 = $request->address1;
            $broker->address2 = $request->address2;
            $broker->city = $request->city;
            $broker->office_number = $request->office_number;
            $broker->phone_number = $request->mobile_number;
            $broker->email = $request->email;
            $broker->status = $request->status;

            if($request->nrc){
                $broker->nrc = storeFile($request->nrc, str_replace(" ", "_", 'broker_nrc'));
            }

            if($request->status === 'active'){
                $broker->active_date = date('Y-m-d H:i:s');
            }

            $broker->save();

            // Creating the user and getting the user id of the created user.
            $user_id = $this->createUser($request, $broker->user_id, 'put');

            // Updating the user id on the brokers table
            $broker->user_id = $user_id;
            $broker->save();

            return response()->json(['msg' => 'updated successfully!', 'status' => 200], 200);
        }else{
            return response()->json(['msg' => 'broker not found', 'status' => 404], 404);
        }
    }

    private function createUser($request, $user_id, $method){

        $u_id = $user_id;

        // Generating the unique user id
        $user_id = User::all()->last();
        $nextId = ($user_id === null ? 0 : $user_id->user_id) + 1;

        $suffix = str_pad($nextId, 3, '0', STR_PAD_LEFT);

        $unique_id = $suffix;
        
        $user = null;

        if ($method === 'put'){
            $user = User::find($u_id);
        }else{
            $user = new User;
        }

        $generated_password = Str::random(8);

        $user->unique_id = $unique_id;
        $user->first_name = $request->first_name;
        $user->last_name = $request->surname;
        $user->email = $request->email;
        $user->role_id = Role::where('name', '=', 'Broker')->first()->role_id;
        $user->phone_number = $request->mobile_number;
        $user->password_expiry_date = date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))));
        $user->password = Hash::make($generated_password);
        $user->save();

        // Notifying the broker that they are now registered.
        $broker_house = auth('api')->user()->brokerHouse->name;
        $user->notify(new BrokerRegistration($user, $generated_password, $broker_house));

        return $user->user_id;
    }
}
