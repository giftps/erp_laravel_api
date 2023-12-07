<?php

namespace App\Http\Controllers\Api\V1\Lookups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\Api\V1\Lookups\ResignCodesResource;

use App\Models\Api\V1\Lookups\ResignCode;

class ResignCodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resign_codes = ResignCode::all();

        return response()->json(ResignCodesResource::collection($resign_codes));
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
            'code' => 'required|string|max:4',
            'description' => 'required|string'
        ]);

        $resign_code = new ResignCode;
        $resign_code->code = $request->code;
        $resign_code->description = $request->description;
        $resign_code->save();

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
        $resign_code = ResignCode::find($id);

        return response()->json(new ResignCodesResource($resign_code));
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
            'code' => 'required|string|max:4',
            'description' => 'required|string'
        ]);

        $resign_code = ResignCode::find($id);
        $resign_code->code = $request->code;
        $resign_code->description = $request->description;
        $resign_code->save();

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
        ResignCode::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!']);
    }
}
