<?php

namespace App\Http\Controllers\Api\V1\Sales;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Api\V1\Sales\BrokerHouse;

use App\Models\Api\V1\Lookups\BrokerType;

use App\Models\Api\V1\UserAccess\Role;

use Illuminate\Support\Facades\Hash;

use Illuminate\Validation\Rule;

use App\Models\User;

use Illuminate\Support\Str;

use App\Http\Resources\Api\V1\Sales\BrokerHousesResource;

use App\Http\Resources\Api\V1\Lookups\BrokerTypesResource;

use App\Notifications\BrokerHouseRegistration;

use App\Imports\BrokerHousesImport;

use Maatwebsite\Excel\Facades\Excel;

class BrokerHousesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $broker_houses = BrokerHouse::all();

        return response()->json(BrokerHousesResource::collection($broker_houses));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'broker_type_id' => 'required|integer',
            'name' => 'required|string',
            'address1' => 'required|string',
            'address2' => 'required|string',
            'city' => 'required|string',
            'contact_person_name' => 'required|string',
            'contact_person_email' => 'required|string|unique:broker_houses',
            'mobile_number' => 'required|string|unique:broker_houses',
            'website_address' => 'required|string',
            'status' => 'required|string'
        ]);

        if(User::where('email', '=', $request->contact_person_email)->first()){
            return response()->json(['error' => 'email already taken', 'status' => 422], 422);
        }

        if(User::where('phone_number', '=', $request->mobile_number)->first()){
            return response()->json(['error' => 'mobile number already taken', 'status' => 422], 422);
        }

        if(isPermissionGranted('Sales', 'can_add') === 1 || isPermissionGranted('Sales', 'can_add') === true){
            // Generating the code for the broker house
            $last_broker_house = BrokerHouse::all()->last();
            $nextId = ($last_broker_house === null ? 0 : $last_broker_house->broker_house_id) + 1;
            $suffix = str_pad($nextId, 3, '0', STR_PAD_LEFT);
            $code = substr(strtoupper($request->name), 0, 4) . $suffix;

            // Saving broker house data
            $broker_house = new BrokerHouse;
            $broker_house->broker_type_id = $request->broker_type_id;
            $broker_house->name = $request->name;
            $broker_house->address1 = $request->address1;
            $broker_house->address2 = $request->address2;
            $broker_house->city = $request->city;
            $broker_house->code = $code;
            $broker_house->contact_person_name = $request->contact_person_name;
            $broker_house->contact_person_email = $request->contact_person_email;
            $broker_house->office_number = $request->office_number;
            $broker_house->mobile_number = $request->mobile_number;
            $broker_house->website_address = $request->website_address;

            if($request->status === 'active'){
                $broker_house->active_date = date('Y-m-d H:i:s');
            }

            if($request->status === 'inactive'){
                $broker_house->inactive_date = date('Y-m-d H:i:s');
            }

            $broker_house->status = $request->status;
            $broker_house->save();

            // Adding data to the users take and getting the id
            $user_id = $this->createUser($request, $broker_house->broker_house_id);

            // Updating the user id on the broker house table.
            $broker_house->user_id = $user_id;
            $broker_house->save();

            return response()->json(['msg' => 'saved successfully!', 'status' => 200], 200);   
        }else{
            return response()->json(['msg' => 'You do not have permission to add to this resource!', 'status' => 403], 403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $broker_house = BrokerHouse::with(['brokers'])->find($id);

        return response()->json(new BrokerHousesResource($broker_house));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'broker_type_id' => 'required|integer',
            'name' => 'required|string',
            'address1' => 'required|string',
            'address2' => 'required|string',
            'city' => 'required|string',
            'contact_person_name' => 'required|string',
            'contact_person_email' => 'required|email|unique:broker_houses,contact_person_email,'.$id . ',broker_house_id',
            'mobile_number' => 'required|string|unique:broker_houses,mobile_number,'.$id . ',broker_house_id',
            'website_address' => 'required|string',
            'status' => 'required|string'
        ]);

        $user = User::find($id);

        if(isPermissionGranted('Sales', 'can_edit') === 1 || isPermissionGranted('Sales', 'can_edit') === true){
            // Generating the code for the broker house
            $suffix = str_pad(BrokerHouse::find($id)->broker_house_id, 3, '0', STR_PAD_LEFT);
            $code = substr(strtoupper($request->name), 0, 4) . $suffix;

            // Saving broker house data
            $broker_house = BrokerHouse::find($id);
            $broker_house->broker_type_id = $request->broker_type_id;
            $broker_house->name = $request->name;
            $broker_house->address1 = $request->address1;
            $broker_house->address2 = $request->address2;
            $broker_house->city = $request->city;
            $broker_house->code = $code;
            $broker_house->contact_person_name = $request->contact_person_name;
            $broker_house->contact_person_email = $request->contact_person_email;
            $broker_house->office_number = $request->office_number;
            $broker_house->mobile_number = $request->mobile_number;
            $broker_house->website_address = $request->website_address;

            if(!$broker_house->active_date && $request->status === 'active'){
                $broker_house->active_date = date('Y-m-d H:i:s');
                $broker_house->inactive_date = null;
            }

            if($request->status === 'inactive'){
                $broker_house->inactive_date = date('Y-m-d H:i:s');
                $broker_house->active_date = null;
            }

            $broker_house->status = $request->status;
            $broker_house->save();

            return response()->json(['msg' => 'updated successfully!']);
        }else{
            return response()->json(['msg' => 'You do not have permission to edit this resource!', 'status' => 403], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(isPermissionGranted('Sales', 'can_delete') === 1 || isPermissionGranted('Sales', 'can_delete') === true){
            BrokerHouse::find($id)->delete();

            return response()->json(['msg' => 'deleted successfully!']);
        }else{
            return response()->json(['msg' => 'You do not have permission to delete this resource!', 'status' => 403], 403);
        }
    }

    public function brokerTypes(){
        $broker_types = BrokerType::all();

        return response()->json(BrokerTypesResource::collection($broker_types));
    }

    private function createUser($request, $broker_house_id){
        // Generating the unique user id
        $user_id = User::all()->last();
        $nextId = ($user_id === null ? 0 : $user_id->user_id) + 1;

        $suffix = str_pad($nextId, 3, '0', STR_PAD_LEFT);

        $unique_id = $suffix;

        // Saving the user
        $name_array = explode(" ", $request->contact_person_name);

        $generated_password = Str::random(8);

        $user = User::create([
            'unique_id' => $unique_id,
            'first_name' => $name_array[0],
            'last_name' => count($name_array) > 1 ? $name_array[1] : $name_array[0],
            'email' => $request->contact_person_email,
            'role_id' => Role::where('name', '=', 'Broker House Admin')->first()->role_id,
            'phone_number' => $request->mobile_number,
            'password_expiry_date' => date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d')))),
            'password' => Hash::make($generated_password),
        ]);

        $user->notify(new BrokerHouseRegistration($user, $generated_password));

        return $user->user_id;
    }

    public function importBrokerHouses(Request $request){
        Excel::import(new BrokerHousesImport, $request->file('excel'));

        return response()->json(['msg' => 'imported successfully!', 'status' => 200], 200);
    }
}
