<?php

namespace App\Http\Controllers\Api\V1\Lookups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\Api\V1\Lookups\ModusOperandisResource;

use App\Models\Api\V1\Lookups\ModusOperandi;

class ModusOperandisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modus_operandis = ModusOperandi::all();

        return response()->json(ModusOperandisResource::collection($modus_operandis));
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

        $modus_operandi = new ModusOperandi;
        $modus_operandi->description = $request->description;
        $modus_operandi->save();

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
        $modus_operandi = ModusOperandi::find($id);

        return response()->json(new ModusOperandisResource($modus_operandi));
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

        $modus_operandi = ModusOperandi::find($id);
        $modus_operandi->description = $request->description;
        $modus_operandi->save();

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
        ModusOperandi::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!']);
    }
}
