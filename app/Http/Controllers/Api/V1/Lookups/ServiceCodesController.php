<?php

namespace App\Http\Controllers\Api\V1\Lookups;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Api\V1\Lookups\ServiceCode;

use App\Http\Resources\Api\V1\Lookups\ServiceCodesResource;

class ServiceCodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $service_codes = ServiceCode::all();

        return response()->json(ServiceCodesResource::collection($service_codes));
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
            'description' => 'required|string',
            'is_hospital' => 'required|boolean',
            'age' => 'required|string',
            'gender' => 'required|string',
            'prescribed_amount' => 'required|numeric',
            'status' => 'required|string'
        ]);

        $service_code = new ServiceCode;
        $service_code->code = $request->code;
        $service_code->description = $request->description;
        $service_code->is_hospital = $request->is_hospital;
        $service_code->age = $request->age;
        $service_code->gender = $request->gender;
        $service_code->prescribed_amount = $request->prescribed_amount;
        $service_code->status = $request->status;
        $service_code->save();

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
        $service_code = ServiceCode::with(['disciplines'])->find($id);

        return response()->json(new ServiceCodesResource($service_code));
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
            'description' => 'required|string',
            'is_hospital' => 'required|boolean',
            'age' => 'required|string',
            'gender' => 'required|string',
            'prescribed_amount' => 'required|numeric',
            'status' => 'required|string'
        ]);

        $service_code = ServiceCode::find($id);
        $service_code->code = $request->code;
        $service_code->description = $request->description;
        $service_code->is_hospital = $request->is_hospital;
        $service_code->age = $request->age;
        $service_code->gender = $request->gender;
        $service_code->prescribed_amount = $request->prescribed_amount;
        $service_code->status = $request->status;
        $service_code->save();

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
        ServiceCode::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!']);
    }
}
