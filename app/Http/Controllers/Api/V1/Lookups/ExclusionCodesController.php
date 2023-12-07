<?php

namespace App\Http\Controllers\Api\V1\Lookups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\Api\V1\Lookups\ExclusionCodesResource;

use App\Models\Api\V1\Lookups\ExclusionCode;

class ExclusionCodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exclusion_codes = ExclusionCode::all();

        return response()->json(ExclusionCodesResource::collection($exclusion_codes));
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
            'description' => 'required|string'
        ]);

        $exclusion_code = new ExclusionCode;
        $exclusion_code->description = $request->description;
        $exclusion_code->save();

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
        $exclusion_code = ExclusionCode::find($id);

        return response()->json(new ExclusionCodesResource($exclusion_code));
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
            'description' => 'required|string'
        ]);

        $exclusion_code = ExclusionCode::find($id);
        $exclusion_code->description = $request->description;
        $exclusion_code->save();

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
        ExclusionCode::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!']);
    }
}
