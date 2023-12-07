<?php

namespace App\Http\Controllers\Api\V1\UserAccess;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\Api\V1\UserAccess\PermissionsResource;

use App\Models\Api\V1\UserAccess\Permission;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();

        return response()->json(PermissionsResource::collection($permissions));
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
            'module_id' => 'required|integer',
            'role_id' => 'required|integer',
            'can_add' => 'required|boolean',
            'can_edit' => 'required|boolean',
            'can_delete' => 'required|boolean'
        ]);

        $permission = new Permission;
        $permission->module_id = $request->module_id;
        $permission->role_id = $request->role_id;
        $permission->can_add = $request->can_add;
        $permission->can_edit = $request->can_edit;
        $permission->can_delete = $request->can_delete;
        $permission->save();

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
        $permission = Permission::find($id);

        return response()->json(new PermissionsResource($permission));
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
            'module_id' => 'required|integer',
            'role_id' => 'required|integer',
            'can_add' => 'required|boolean',
            'can_edit' => 'required|boolean',
            'can_delete' => 'required|boolean'
        ]);

        $permission = Permission::find($id);
        $permission->module_id = $request->module_id;
        $permission->role_id = $request->role_id;
        $permission->can_add = $request->can_add;
        $permission->can_edit = $request->can_edit;
        $permission->can_delete = $request->can_delete;
        $permission->save();

        return response()->json(['msg' => 'updated successfully!', 'status' => 200], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Permission::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!', 'status' => 200], 200);
    }
}
