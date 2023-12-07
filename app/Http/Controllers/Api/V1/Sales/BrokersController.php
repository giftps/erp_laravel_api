<?php

namespace App\Http\Controllers\Api\V1\Sales;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Resources\Api\V1\Sales\BrokersResource;

use App\Models\Api\V1\UserAccess\Role;

use Illuminate\Support\Facades\Hash;

use App\Models\Api\V1\Sales\Broker;

use App\Models\Api\V1\Sales\BrokerHouse;

use App\Models\User;

use App\Notifications\BrokerRegistration;

use Illuminate\Support\Str;

use App\Imports\BrokersImport;

use Maatwebsite\Excel\Facades\Excel;

class BrokersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $brokers = Broker::get();

        return response()->json(BrokersResource::collection($brokers));
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
            'broker_house_id' => 'required|integer',
            'title' => 'required|string',
            'first_name' => 'required|string',
            'surname' => 'required|string',
            'id_number' => 'required|string',
            'address1' => 'required|string',
            'address2' => 'required|string',
            'city' => 'required|string',
            'office_number' => 'required|string',
            'mobile_number' => 'required|string|unique:brokers,phone_number',
            'email' => 'required|string|unique:brokers',
            'status' => 'required|string'
        ]);

        if(User::where('phone_number', '=', $request->mobile_number)->first()){
            return response()->json(['error' => 'phone number already taken', 'status' => 422], 422);
        }

        if(isPermissionGranted('Sales', 'can_add') === 1 || isPermissionGranted('Sales', 'can_add') === true){
            // Generating the code for the broker house
            $broker_id = Broker::all()->last();
            $nextId = ($broker_id === null ? 0 : $broker_id->broker_id) + 1;
            $suffix = str_pad($nextId, 3, '0', STR_PAD_LEFT);
            $code = substr(strtoupper($request->first_name), 0, 4) . $suffix;

            $broker_house = BrokerHouse::find($request->broker_house_id)->name;

            $broker = new Broker;
            $broker->broker_house_id = $request->broker_house_id;
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

            $broker->active_date = date('Y-m-d H:i:s');

            $broker->inactive_date = date('Y-m-d H:i:s');

            $broker->save();

            // Creating the user and getting the user id of the created user.
            $user_id = $this->createUser($request, $broker_house);

            // Updating the user id on the brokers table
            $broker->user_id = $user_id;
            $broker->save();

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
        $broker = Broker::find($id);

        return response()->json(new BrokersResource($broker));
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
            'broker_house_id' => 'required|integer',
            'title' => 'required|string',
            'first_name' => 'required|string',
            'surname' => 'required|string',
            'id_number' => 'required|string',
            'address1' => 'required|string',
            'address2' => 'required|string',
            'city' => 'required|string',
            'office_number' => 'required|string',
            'mobile_number' => 'required|string|unique:brokers,phone_number,'.$id . ',broker_id',
            'email' => 'required|email|unique:brokers,email,'.$id . ',broker_id',
            'status' => 'required|string'
        ]);

        if(isPermissionGranted('Sales', 'can_edit') === 1 || isPermissionGranted('Sales', 'can_edit') === true){
            // Generating the code for the broker
            $suffix = str_pad(Broker::find($id)->broker_id, 3, '0', STR_PAD_LEFT);
            $code = substr(strtoupper($request->first_name), 0, 4) . $suffix;

            $broker = Broker::find($id);
            $broker->broker_house_id = $request->broker_house_id;
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
            $broker->save();

            return response()->json(['msg' => 'updated successfully!', 'status' => 200], 200);
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
            Broker::find($id)->delete();

            return response()->json(['msg' => 'deleted successfully!', 'status' => 200], 200);
        }else{
            return response()->json(['msg' => 'You do not have permission to delete this resource!', 'status' => 403], 403);
        }
    }

    private function createUser($request, $broker_house){
        // Generating the unique user id
        $user_id = User::all()->last();
        $nextId = ($user_id === null ? 0 : $user_id->user_id) + 1;

        $suffix = str_pad($nextId, 3, '0', STR_PAD_LEFT);

        $unique_id = $suffix;

        $generated_password = Str::random(8);

        $user = User::create([
            'unique_id' => $unique_id,
            'first_name' => $request->first_name,
            'last_name' => $request->surname,
            'email' => $request->email,
            'role_id' => Role::where('name', '=', 'Broker')->first()->role_id,
            'phone_number' => $request->mobile_number,
            'password_expiry_date' => date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d')))),
            'password' => Hash::make($generated_password),
        ]);

        $user->notify(new BrokerRegistration($user, $generated_password, $broker_house));

        return $user->user_id;
    }

    public function importBrokers(Request $request){
        Excel::import(new BrokersImport, $request->file('excel'));

        return response()->json(['msg' => 'imported successfully!', 'status' => 200], 200);
    }
}
