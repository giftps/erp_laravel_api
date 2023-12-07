<?php

namespace App\Http\Controllers\Api\V1\Lookups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\Api\V1\Lookups\CountriesResource;

use App\Models\Api\V1\Lookups\Country;

class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::all();

        return response()->json(CountriesResource::collection($countries));
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
            'country_code' => 'required|string|max:4',
            'currency_code' => 'required|string|max:4',
            'population' => 'required|integer',
            'capital' => 'required|string',
            'continent' => 'required|string',
        ]);

        $country = new Country;
        $country->name = $request->name;
        $country->country_code = $request->country_code;
        $country->currency_code = $request->currency_code;
        $country->population = $request->population;
        $country->capital = $request->capital;
        $country->continent = $request->continent;
        $country->save();

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
        $country = Country::find($id);

        return response()->json(new CountriesResource($country));
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
            'country_code' => 'required|string|max:4',
            'currency_code' => 'required|string|max:4',
            'population' => 'required|integer',
            'capital' => 'required|string',
            'continent' => 'required|string',
        ]);

        $country = Country::find($id);
        $country->name = $request->name;
        $country->country_code = $request->country_code;
        $country->currency_code = $request->currency_code;
        $country->population = $request->population;
        $country->capital = $request->capital;
        $country->continent = $request->continent;
        $country->save();

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
        Country::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!']);
    }
}
