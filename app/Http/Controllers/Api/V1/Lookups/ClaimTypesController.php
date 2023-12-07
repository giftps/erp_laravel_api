<?php

namespace App\Http\Controllers\Api\V1\Lookups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\Api\V1\Lookups\ClaimStatusesResource;

use App\Models\Api\V1\Lookups\ClaimStatus;

class ClaimTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $claim_types = ClaimStatus::all();

        return response()->json(ClaimStatusesResource::collection($claim_types));
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

        $claim_type = new ClaimStatus;
        $claim_type->name = $request->name;
        $claim_type->save();

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
        $claim_type = ClaimStatus::find($id);

        return response()->json(new ClaimStatusesResource($claim_type));
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

        $claim_type = ClaimStatus::find($id);
        $claim_type->name = $request->name;
        $claim_type->save();

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
        ClaimStatus::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!']);
    }
}
