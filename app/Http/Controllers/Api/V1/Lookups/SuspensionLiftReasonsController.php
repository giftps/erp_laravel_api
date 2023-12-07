<?php

namespace App\Http\Controllers\Api\V1\Lookups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\Api\V1\Lookups\SuspensionLiftReasonsResource;

use App\Models\Api\V1\Lookups\SuspensionLiftReason;

class SuspensionLiftReasonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suspension_lift_reasons = SuspensionLiftReason::all();

        return response()->json(SuspensionLiftReasonsResource::collection($suspension_lift_reasons));
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

        $suspension_lift_reason = new SuspensionLiftReason;
        $suspension_lift_reason->code = $request->code;
        $suspension_lift_reason->description = $request->description;
        $suspension_lift_reason->save();

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
        $suspension_lift_reason = SuspensionLiftReason::find($id);

        return response()->json(new SuspensionLiftReasonsResource($suspension_lift_reason));
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

        $suspension_lift_reason = SuspensionLiftReason::find($id);
        $suspension_lift_reason->code = $request->code;
        $suspension_lift_reason->description = $request->description;
        $suspension_lift_reason->save();

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
        SuspensionLiftReason::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!']);
    }
}
