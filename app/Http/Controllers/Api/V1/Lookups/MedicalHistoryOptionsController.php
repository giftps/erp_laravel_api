<?php

namespace App\Http\Controllers\Api\V1\Lookups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Api\V1\Lookups\MedicalHistoryOption;

use App\Http\Resources\Api\V1\Lookups\MedicalHistoryOptionsResource;

use App\Http\Requests\Api\V1\Lookups\MedicalHistoryOptionsRequest;

class MedicalHistoryOptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medical_options = MedicalHistoryOption::all();
        return response()->json(MedicalHistoryOptionsResource::collection($medical_options));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MedicalHistoryOptionsRequest $request)
    {
        $medical_option = new MedicalHistoryOption;
        $medical_option->description = $request->description;
        $medical_option->save();

        return response()->json(['msg' => 'saved successfully!']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MedicalHistoryOptionsRequest $request, $id)
    {
        if(MedicalHistoryOption::find($id)){
            $medical_option = MedicalHistoryOption::find($id);
            $medical_option->description = $request->description;
            $medical_option->save();

            return response()->json(['msg' => 'updated successfully!']);
        }else{
            return response()->json(['error' => 'record not found', 'status' => 404], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(MedicalHistoryOption::find($id)){
            MedicalHistoryOption::find($id)->delete();
            return response()->json(['msg' => 'deleted successfully!', 'status' => 200], 200);
        }else{
            return response()->json(['error' => 'record not found', 'status' => 404], 404);
        }
    }

    public function tokenizedMemberMedicalHistoryOptions($token){
        
    }
}
