<?php

namespace App\Http\Controllers\Api\V1\UserAccess;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\Api\V1\UserAccess\ModulesResource;

use App\Models\Api\V1\UserAccess\Module;

class ModulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modules = Module::all();

        return response()->json(ModulesResource::collection($modules));
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

        $module = new Module;
        $module->name = $request->name;
        $module->save();

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
        $module = Module::find($id);

        return response()->json(new ModulesResource($module));
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

        $module = Module::find($id);
        $module->name = $request->name;
        $module->save();

        return response()->json(['msg' => 'saved successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Module::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!']);
    }
}
