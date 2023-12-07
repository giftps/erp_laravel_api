<?php

namespace App\Http\Controllers\Api\V1\UsersAndAdministrations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Api\V1\UserAccess\Role;

use App\Http\Resources\UsersResource;

use Carbon\Carbon;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role_ids = Role::where('name', 'LIKE', '%admin%')->orWhere('name', '=', 'Underwriter')->pluck('role_id');
        $users = User::whereIn('role_id', $role_ids)->orderBy('created_at', 'DESC')->get();

        return response()->json(UsersResource::collection($users));
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email'=>'required|email|unique:users',
            'phone_number' => 'required|string',
            'password' => 'required|string|min:8',
            'role_id' => 'required|integer',
            'department_id' => 'required|integer',
            'designation' => 'required|string',
            'profile_picture' => 'nullable|sometimes|image'
        ]);

        // Generating the Unique id
        $last_user_id = User::all()->last();
        $nextId = ($last_user_id === null ? 0 : $last_user_id->id) + 1;

        $suffix = str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $unique_id = $suffix;

        // Adding the user
        $user = new User;
        $user->unique_id = $unique_id;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->phone_number = $request->phone_number;
        $user->password_expiry_date = Carbon::now()->addDays(30);
        $user->password = Hash::make($request->password);
        $user->designation = $request->designation;
        $user->department_id = $request->department_id;
        $user->password_expiry_date = date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))));
        $user->is_active = true;
        if($request->hasFile('profile_picture')){
            $user->profile_picture = storeFile($request->profile_picture, 'Profile_Pictures');
        }
        $user->save();

        return response()->json(['msg' => 'saved successfully!', 'status' => 200], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return response()->json(new UsersResource($user));
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email'=>'required|email|unique:users,email,' . $id . ',user_id',
            'phone_number' => 'required|string',
            'role_id' => 'required|integer',
            'department_id' => 'required|integer',
            'designation' => 'required|string',
            'profile_picture' => 'nullable|sometimes|image'
        ]);

        // Generating the Unique id
        $last_user_id = User::all()->last();
        $nextId = ($last_user_id === null ? 0 : $last_user_id->id) + 1;

        $suffix = str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $unique_id = $suffix;

        // Adding the user
        $user = User::find($id);
        $user->unique_id = $unique_id;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->role_id = $request->role_id;
        $user->designation = $request->designation;
        $user->department_id = $request->department_id;
        if($request->hasFile('profile_picture')){
            $user->profile_picture = storeFile($request->profile_picture, 'Profile_Pictures');
        }
        if($request->password){
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return response()->json(['msg' => 'updated successfully!']);
    }

    public function activateDeactivate(Request $request){
        $this->validate($request, [
            'user_id' => 'required|integer'
        ]);

        $user = User::find($request->user_id);

        if($user->is_active == 0){
            $user->is_active = true;
            $user->save();

            return response()->json(['msg' => 'activated successfully!']);
        }else{
            $user->is_active = false;
            $user->save();

            return response()->json(['msg' => 'deactivated successfully!']);
        }
    }

    public function expiredPasswordReset(Request $request){
        $this->validate($request, [
            'user_id' => 'required|integer',
            'password' => 'required|string'
        ]);

        $user = User::find($request->user_id);

        if (Hash::check($request->password, $user->password)) { 
            return response()->json(['error' => 'You cannot use the previous password!', 'status' => 401], 401);
        }

        $user->password = Hash::make($request->password);
        $user->password_expiry_date = Carbon::now()->addDays(30);
        $user->save();

        return response()->json(['msg' => 'saved successfully!', 'status' => 200], 200);
    }
}
