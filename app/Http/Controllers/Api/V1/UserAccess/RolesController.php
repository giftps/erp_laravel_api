<?php

namespace App\Http\Controllers\Api\V1\UserAccess;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\Api\V1\UserAccess\RolesResource;

use App\Models\Api\V1\UserAccess\Role;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();

        return response()->json(RolesResource::collection($roles));
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
            'name' => 'required|string',
            'status' => 'required|string'
        ]);

        $role = new Role;
        $role->name = $request->name;
        $role->status = $request->status;
        $role->save();

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
        $role = Role::find($id);

        return response()->json(new RolesResource($role));
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
            'name' => 'required|string',
            'status' => 'required|string'
        ]);

        $role = Role::find($id);
        $role->name = $request->name;
        $role->status = $request->status;
        $role->save();

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
        Role::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!']);
    }
}
