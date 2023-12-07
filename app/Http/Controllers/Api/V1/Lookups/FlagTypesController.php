<?php

namespace App\Http\Controllers\Api\V1\Lookups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\Api\V1\Lookups\FlagTypesResource;

use App\Models\Api\V1\Lookups\FlagType;

class FlagTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $flag_types = FlagType::all();

        return response()->json(FlagTypesResource::collection($flag_types));
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
            'code' => 'required|string|max:3',
            'description' => 'required|string'
        ]);

        $flag_type = new FlagType;
        $flag_type->code = $request->code;
        $flag_type->description = $request->description;
        $flag_type->save();

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
        $flag_types = FlagType::find($id);

        return response()->json(new FlagTypesResource($flag_types));
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
            'code' => 'required|string|max:3',
            'description' => 'required|string'
        ]);

        $flag_type = FlagType::find($id);
        $flag_type->code = $request->code;
        $flag_type->description = $request->description;
        $flag_type->save();

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
        FlagType::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!']);
    }
}
