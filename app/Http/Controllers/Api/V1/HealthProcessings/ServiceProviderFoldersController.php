<?php

namespace App\Http\Controllers\Api\V1\HealthProcessings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\V1\HealthProcessings\ServiceProviderFolder;
use App\Http\Resources\Api\V1\HealthProcessings\ServiceProviderFoldersResource;

class ServiceProviderFoldersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $folders = ServiceProviderFolder::all();

        return response()->json(ServiceProviderFoldersResource::collection($folders));
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

        $folders = new ServiceProviderFolder;
        $folders->name = $request->name;
        $folders->save();

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
        $folder = ServiceProviderFolder::find($id);

        if($folder){
            return response()->json(new ServiceProviderFoldersResource($folder));
        }else{
            return response()->json(['error' => 'supplied id not found'], 404);
        }
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

        $folders = ServiceProviderFolder::find($id);
        $folders->name = $request->name;
        $folders->save();

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
        $folder = ServiceProviderFolder::find($id);

        if($folder){
            $folder->delete();
        }

        return response()->json(['error' => 'supplied id not found'], 404);
    }
}
