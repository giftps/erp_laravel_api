<?php

namespace App\Http\Controllers\Api\V1\UsersAndAdministrations;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Api\V1\UserAccess\RoleUser;

use App\Http\Resources\UsersResource;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'DESC')->get();

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
            'role_id' => 'required|integer'
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
        $user->phone_number = $request->phone_number;
        $user->password = Hash::make($request->password);
        $user->save();

        $role_user = new RoleUser;
        $role_user->user_id = $user->id;
        $role_user->role_id = $request->role_id;
        $role_user->save();

        return response()->json(['msg' => 'saved successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('roles')->find($id);

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
            // 'role_id' => 'required|integer'
        ]);

        // Updating the user
        $user = User::find($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        if (isset($request->password) && $request->password !== ''){
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // $role_user = new RoleUser;
        // $role_user->user_id = $user->id;
        // $role_user->role_id = $request->role_id;
        // $role_user->save();

        return response()->json(['msg' => 'updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();

        return response()->json(['msg' => 'Deleted Successfully!']);
    }
}
