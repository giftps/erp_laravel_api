<?php

namespace App\Http\Controllers\Api\V1\Lookups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\Api\V1\Lookups\GendersResource;

use App\Models\Api\V1\Lookups\Gender;

class GendersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $genders = Gender::all();

        return response()->json(GendersResource::collection($genders));
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
            'code' => 'required|string|max:3',
            'description' => 'required|string'
        ]);

        $gender = new Gender;
        $gender->code = $request->code;
        $gender->description = $request->description;
        $gender->save();

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
        $gender = Gender::find($id);

        return response()->json(new GendersResource($gender));
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
            'code' => 'required|string|max:3',
            'description' => 'required|string'
        ]);

        $gender = Gender::find($id);
        $gender->code = $request->code;
        $gender->description = $request->description;
        $gender->save();

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
        Gender::find($id)->delete();

        response()->json(['msg' => 'deleted successfully!']);
    }
}
