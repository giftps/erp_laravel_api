<?php

namespace App\Http\Controllers\Api\V1\Lookups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Api\V1\Lookups\AgeGroup;

use App\Http\Resources\Api\V1\Lookups\AgeGroupsResource;

class AgeGroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $age_group = AgeGroup::all();

        return response()->json(AgeGroupsResource::collection($age_group));
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
            'min_age' => 'required|integer',
            'max_age' => 'nullable|sometimes|integer'
        ]);

        $age_group = new AgeGroup;
        $age_group->min_age = $request->min_age;
        $age_group->max_age = $request->max_age;
        $max_age->save();

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
        $age_group = AgeGroup::find($id);

        return response()->json(new AgeGroupsResource($age_group));
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
            'min_age' => 'required|integer',
            'max_age' => 'nullable|sometimes|integer'
        ]);

        $age_group = AgeGroup::find($id);
        $age_group->min_age = $request->min_age;
        $age_group->max_age = $request->max_age;
        $max_age->save();

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
        AgeGroup::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!', 'status' => 200], 200);
    }
}
