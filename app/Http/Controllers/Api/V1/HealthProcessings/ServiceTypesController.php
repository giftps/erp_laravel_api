<?php

namespace App\Http\Controllers\Api\V1\HealthProcessings;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Api\V1\HealthProcessings\ServiceType;

use App\Http\Resources\Api\V1\HealthProcessings\ServiceTypesResource;

class ServiceTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $service_types = ServiceType::all();

        return response()->json(ServiceTypesResource::collection($service_types));
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
            'name' => 'required|string',
            'status' => 'required|string'
        ]);

        $service_type = new ServiceType;
        $service_type->name = $request->name;
        $service_type->status = $request->status;
        $service_type->save();

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
        $service_type = ServiceType::find($id);

        return response()->json(new ServiceTypesResource($service_type));
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
            'name' => 'required|string',
            'status' => 'required|string'
        ]);

        $service_type = ServiceType::find($id);
        $service_type->name = $request->name;
        $service_type->status = $request->status;
        $service_type->save();

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
        ServiceType::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!']);
    }
}
