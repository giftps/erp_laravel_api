<?php

namespace App\Http\Controllers\Api\V1\Lookups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\Api\V1\Lookups\DoctorFlagTypesResource;

use App\Models\Api\V1\Lookups\DoctorFlagType;

class DoctorFlagTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doctor_flag_types = DoctorFlagType::all();

        return response()->json(DoctorFlagTypesResource::collection($doctor_flag_types));
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

        $doctor_flag_type = new DoctorFlagType;
        $doctor_flag_type->description = $request->description;
        $doctor_flag_type->save();

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
        $doctor_flag_type = DoctorFlagType::find($id);

        return response()->json(new DoctorFlagTypesResource($doctor_flag_type));
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

        $doctor_flag_type = DoctorFlagType::find($id);
        $doctor_flag_type->description = $request->description;
        $doctor_flag_type->save();

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
        DoctorFlagType::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!']);
    }
}
