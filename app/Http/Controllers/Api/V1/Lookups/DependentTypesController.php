<?php

namespace App\Http\Controllers\Api\V1\Lookups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\Api\V1\Lookups\DependentTypesResource;

use App\Models\Api\V1\Lookups\DependentType;

class DependentTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dependent_types = DependentType::all();

        return response()->json(DependentTypesResource::collection($dependent_types));
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
            'type' => 'required|string|max:3',
            'description' => 'required|string'
        ]);

        $dependent_type = new DependentType;
        $dependent_type->type = $request->type;
        $dependent_type->description = $request->description;
        $dependent_type->save();

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
        $dependent_type = DependentType::find($id);

        return response()->json(new DependentTypesResource($dependent_type));
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
            'type' => 'required|string|max:3',
            'description' => 'required|string'
        ]);

        $dependent_type = DependentType::find($id);
        $dependent_type->type = $request->type;
        $dependent_type->description = $request->description;
        $dependent_type->save();

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
        DependentType::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!']);
    }
}
