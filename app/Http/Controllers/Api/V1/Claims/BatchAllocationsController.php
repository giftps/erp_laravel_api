<?php

namespace App\Http\Controllers\Api\V1\Claims;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\V1\Claims\BatchAllocation;
use App\Http\Resources\Api\V1\Claims\BatchAllocationsResource;
use App\Models\Api\V1\Claims\ClaimsLog;

class BatchAllocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $batch_allocations = BatchAllocation::limit(25)->orderBy('created_at', 'DESC')->get();

        return response()->json(BatchAllocationsResource::collection($batch_allocations));
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
            'claims_log_id' => 'required|integer',
            'assessor_id' => 'required|integer',
            'assigned_on' => 'required|date',
            'status' => 'required|string'
        ]);

        $batch_allocation = new BatchAllocation;
        $batch_allocation->claims_log_id = $request->claims_log_id;
        $batch_allocation->assessor_id = $request->assessor_id;
        $batch_allocation->assigned_on = $request->assigned_on;
        $batch_allocation->status = $request->status;
        $batch_allocation->save();

        if($batch_allocation){
            $claims_log = ClaimsLog::find($request->claims_log_id);
            $claims_log->status = 'Allocated';
            $claims_log->save();
        }

        return response()->json(['msg' => 'saved successfully!'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $batch_allocation = BatchAllocation::find($id);

        return response()->json(new BatchAllocationsResource($batch_allocation));
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
            'claims_log_id' => 'required|integer',
            'assessor_id' => 'required|integer',
            'assigned_on' => 'required|date',
            'status' => 'required|string'
        ]);

        $batch_allocation = BatchAllocation::find($id);
        $batch_allocation->claims_log_id = $request->claims_log_id;
        $batch_allocation->assessor_id = $request->assessor_id;
        $batch_allocation->assigned_on = $request->assigned_on;
        $batch_allocation->status = $request->status;
        $batch_allocation->save();

        if($batch_allocation){
            $claims_log = ClaimsLog::find($request->claims_log_id);
            $claims_log->status = 'Allocated';
            $claims_log->save();
        }

        return response()->json(['msg' => 'updated successfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $batch_allocation = BatchAllocation::find($id);

        if($batch_allocation){
            $batch_allocation->delete();

            return response()->json(['msg' => 'deleted successfully'], 200);
        }

        return response()->json(['error' => 'failed to delete'], 422);
    }
}
