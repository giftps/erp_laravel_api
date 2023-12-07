<?php

namespace App\Http\Controllers\Api\V1\Lookups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Api\V1\Lookups\Department;
use App\Http\Resources\Api\V1\Lookups\DepartmentsResource;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::all();

        return response()->json(DepartmentsResource::collection($departments));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate([
            'name' => 'required|string'
        ]);

        $department = new Department;
        $department->name = $request->name;
        $department->save();

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
        $department = Department::find($id);

        return response()->json(new DepartmentsResource($department));
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
        $this->validate([
            'name' => 'required|string'
        ]);

        $department = Department::find($id);
        $department->name = $request->name;
        $department->save();

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
        Department::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!', 'status' => 200], 200);
    }
}
