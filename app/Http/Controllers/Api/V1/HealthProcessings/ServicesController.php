<?php

namespace App\Http\Controllers\Api\V1\HealthProcessings;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Service;

use App\Http\Resources\ServicesResource;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::all();

        return response()->json(ServicesResource::collection($services));
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
            'name' => 'required|string'
        ]);

        $service = new Service;
        $service->name = $request->name;
        $service->age = $request->age;
        $service->gender = $request->gender;
        $service->prescribed_amount = $request->prescribed_amount;
        $service->save();

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
        $services = Service::with(['serviceProviders'])->find($id);

        return response()->json(new ServicesResource($services));
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
            'name' => 'required|string'
        ]);

        $service = Service::find($id);
        $service->name = $request->name;
        $service->age = $request->age;
        $service->gender = $request->gender;
        $service->prescribed_amount = $request->prescribed_amount;
        $service->save();

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
        Service::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!']);
    }
}
