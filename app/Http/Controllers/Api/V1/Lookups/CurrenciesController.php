<?php

namespace App\Http\Controllers\Api\V1\Lookups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\Api\V1\Lookups\CurrenciesResource;

use App\Models\Api\V1\Lookups\Currency;

class CurrenciesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currencies = Currency::all();

        return response()->json(CurrenciesResource::collection($currencies));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate([
            'code' => 'required|string|max:3',
            'description' => 'required|string'
        ]);

        $currency = new Currency;
        $currency->code = $request->code;
        $currency->description = $request->description;
        $currency->save();

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
        $currency = Currency::find($id);

        return response()->json(new CurrenciesResource($currency));
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
        $this->validate([
            'code' => 'required|string|max:3',
            'description' => 'required|string'
        ]);

        $currency = Currency::find($id);
        $currency->code = $request->code;
        $currency->description = $request->description;
        $currency->save();

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
        Currency::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!']);
    }
}
