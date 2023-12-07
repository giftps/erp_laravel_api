<?php

namespace App\Http\Controllers\Api\V1\Lookups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\Api\V1\Lookups\ClaimAssessmentNotesResource;

use App\Models\Api\V1\Lookups\ClaimAssessmentNote;

class ClaimAssessmentNotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $claim_assessment_notes = ClaimAssessmentNote::all();

        return response()->json(ClaimAssessmentNotesResource::collection($claim_assessment_notes));
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

        $claim_assessment_note = new ClaimAssessmentNote;
        $claim_assessment_note->description = $request->description;
        $claim_assessment_note->save();

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
        $claim_assessment_note = ClaimAssessmentNote::find($id);

        return response()->json(new ClaimAssessmentNotesResource($claim_assessment_note));
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

        $claim_assessment_note = ClaimAssessmentNote::find($id);
        $claim_assessment_note->description = $request->description;
        $claim_assessment_note->save();

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
        ClaimAssessmentNote::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!']);
    }
}
