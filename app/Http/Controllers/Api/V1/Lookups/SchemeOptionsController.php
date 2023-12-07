<?php

namespace App\Http\Controllers\Api\V1\Lookups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\Api\V1\Lookups\SchemeOptionsResource;

use App\Models\Api\V1\Lookups\SchemeOption;

class SchemeOptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $scheme_options = SchemeOption::orderBy('id', 'DESC')->get();

        return response()->json(SchemeOptionsResource::collection($scheme_options));
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
            'tier_level' => 'required|integer',
            'is_active' => 'required|boolean',
            'member_types' => 'required|string',
        ]);

        $scheme_option = new SchemeOption;
        $scheme_option->name = $request->name;
        $scheme_option->tier_level = $request->tier_level;
        $scheme_option->is_active = $request->is_active;
        $scheme_option->member_types = $request->member_types;
        $scheme_option->save();

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
        $scheme_option = SchemeOption::with(['benefitOptions'])->find($id);

        return response()->json(new SchemeOptionsResource($scheme_option));
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
            'tier_level' => 'required|integer',
            'is_active' => 'required|boolean',
            'member_types' => 'required|string',
        ]);

        $scheme_option = SchemeOption::find($id);
        $scheme_option->name = $request->name;
        $scheme_option->tier_level = $request->tier_level;
        $scheme_option->member_types = $request->member_types;
        $scheme_option->is_active = $request->is_active;
        $scheme_option->save();

        return response()->json(['msg' => 'updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $scheme = SchemeOption::find($id);

    //     return response()->json(['msg' => 'deleted successfully!']);
    // }
}
