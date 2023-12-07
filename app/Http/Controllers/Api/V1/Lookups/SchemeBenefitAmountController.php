<?php

namespace App\Http\Controllers\Api\V1\Lookups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Api\V1\Lookups\Year;
use App\Models\Api\V1\Lookups\SchemeBenefitAmount;
use App\Http\Resources\Api\V1\Lookups\SchemeBenefitAmountsResource;

class SchemeBenefitAmountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        if (isset($_GET['scheme_option_id']) && isset($_GET['year'])){
            $scheme_id = $_GET['scheme_option_id'];

            $requested_year = $_GET['year'];

            $year_ids = Year::where('year', '=', $requested_year)->pluck('id');

            $scheme_benefit_amounts = SchemeBenefitAmount::where('scheme_option_id', '=', $scheme_id)->whereIn('year_id', $year_ids)->get();
            return response()->json(SchemeBenefitAmountsResource::collection($scheme_benefit_amounts));
        }else{
            return response()->json(['msg' => 'scheme option id not specified in url', 'status' => 422], 422);
        }
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
            'year' => 'required:integer',
            'scheme_option_id' => 'required|integer',
            'benefit_option_id' => 'required|integer',
            'limit_amount' => 'required|numeric',
        ]);
        
        $scheme_benefit_amount = SchemeBenefitAmount::where('scheme_option_id', '=', $request->scheme_option_id)->where('benefit_option_id', '=', $request->benefit_option_id)->first();
        
        if(!$scheme_benefit_amount){
            $scheme_benefit_amount = new SchemeBenefitAmount;
        }

        $year = Year::where('year', '=', $request->year)->first();

        if(!$year){
            return response()->json(['msg' => 'selected year not found', 'status' => 404], 404);
        }

        $scheme_benefit_amount->year_id = $year->id;
        $scheme_benefit_amount->scheme_option_id = $request->scheme_option_id;
        $scheme_benefit_amount->benefit_option_id = $request->benefit_option_id;
        $scheme_benefit_amount->currency_id = 1;
        $scheme_benefit_amount->limit_amount = $request->limit_amount;

        $scheme_benefit_amount->save();

        return response()->json(['msg' => 'saved successfully!', 'status' => 200], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $scheme_benefit_amount = SchemeBenefitAmount::with(['scheme', 'benefit'])->find($id);

        return response()->json(new SchemeBenefitAmountsResource($scheme_benefit_amount));
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
            'scheme_option_id' => 'required|integer',
            'benefit_option_id' => 'required|integer',
            'prescribed_amount' => 'required|numeric',
        ]);

        $scheme_benefit_amount = SchemeBenefitAmount::find($id);
        $scheme_benefit_amount->scheme_option_id = $request->scheme_option_id;
        $scheme_benefit_amount->benefit_option_id = $request->benefit_option_id;
        $scheme_benefit_amount->currency_id = 1;
        $scheme_benefit_amount->limit_amount = $request->limit_amount;

        $scheme_benefit_amount->save();

        return response()->json(['msg' => 'updated successfully!', 'status' => 200], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SchemeBenefitAmount::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!', 'status' => 200], 200);
    }
}
