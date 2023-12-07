<?php

namespace App\Http\Controllers\Api\V1\HealthProcessings;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Api\V1\HealthProcessings\Discipline;

use App\Http\Resources\Api\V1\HealthProcessings\DisciplinesResource;

class DisciplinesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $disciplines = Discipline::all();

        return response()->json(DisciplinesResource::collection($disciplines));
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
            'description' => 'required|string',
            'used_for' => 'required|string',
            'is_hospital' => 'required|boolean',
            'status' => 'required|string'
        ]);
        
        $discipline = new Discipline;
        $discipline->code = $request->code;
        $discipline->description = $request->description;
        $discipline->used_for = $request->used_for;
        $discipline->is_hospital = $request->is_hospital;
        $discipline->status = $request->status;
        $discipline->save();

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
        $discipline = Discipline::with(['serviceProviders', 'serviceCodes'])->find($id);

        return response()->json(new DisciplinesResource($discipline));
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
            'description' => 'required|string',
            'used_for' => 'required|string',
            'is_hospital' => 'required|boolean',
            'status' => 'required|string'
        ]);
        
        $discipline = Discipline::find($id);
        $discipline->code = $request->code;
        $discipline->description = $request->description;
        $discipline->used_for = $request->used_for;
        $discipline->is_hospital = $request->is_hospital;
        $discipline->status = $request->status;
        $discipline->save();

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
        Discipline::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!']);
    }
}
