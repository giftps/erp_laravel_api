<?php

namespace App\Http\Controllers\Api\V1\Claims;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\V1\UserAccess\Role;
use App\Http\Resources\UsersResource;
use App\Models\User;

class AssessorsController extends Controller
{
    public function index(){
        $role = Role::where('name', '=', 'Assessor')->first();
        $users = $role->users;
        return response()->json(UsersResource::collection($users));
    }

    public function show($id){
        
    }

    public function store(Request $request){
        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|string',
        ]);
        
        User::create([
            'role_id' => Role::where('name', '=', 'Assessor')->first()?->role_id,
            'unique_id' => time(),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make('12345678')
        ]);

        return response()->json(['msg' => 'saved successfully'], 200);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|string',
        ]);
        
        User::find($id)->update([
            'unique_id' => time(),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
        ]);

        return response()->json(['msg' => 'updated successfully'], 200);
    }
}
