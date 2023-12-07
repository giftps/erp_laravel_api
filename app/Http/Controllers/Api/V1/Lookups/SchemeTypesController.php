<?php

namespace App\Http\Controllers\Api\V1\Lookups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\Api\V1\Lookups\SchemeTypesResource;

use App\Models\Api\V1\Lookups\SchemeType;

class SchemeTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $scheme_types = SchemeType::all();

        return response()->json(SchemeTypesResource::collection($scheme_types));
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
            'code' => 'required|string',
            'identifier' => 'required|string',
            'description' => 'required|string'
        ]);

        $scheme_type = new SchemeType;
        $scheme_type->code = $request->code;
        $scheme_type->identifier = $request->identifier;
        $scheme_type->description = $request->description;
        $scheme_type->save();

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
        $scheme_type = SchemeType::find($id);

        return response()->json(new SchemeTypesResource($scheme_type));
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
            'code' => 'required|string',
            'identifier' => 'required|string',
            'description' => 'required|string'
        ]);

        $scheme_type = SchemeType::find($id);
        $scheme_type->code = $request->code;
        $scheme_type->identifier = $request->identifier;
        $scheme_type->description = $request->description;
        $scheme_type->save();

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
        SchemeType::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!']);
    }
}
