<?php

namespace App\Http\Controllers\Api\V1\Lookups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Api\V1\Lookups\SchemeOptionBenefitOption;
use App\Models\Api\V1\Lookups\BenefitOption;
use App\Models\Api\V1\Lookups\SchemeOption;
use App\Models\Api\V1\Lookups\Year;
use App\Models\Api\V1\Lookups\SchemeBenefitAmount;
use App\Http\Resources\Api\V1\Lookups\BenefitOptionsResource;

class SchemeBenefitsController extends Controller
{
    public function index(){
        if(isset($_GET['scheme_option_id'])){
            $scheme_id = $_GET['scheme_option_id'];

            $benefits = SchemeOption::find($scheme_id)->benefitOptions()->orderBy('benefit_option_id')->get();

            return response()->json(BenefitOptionsResource::collection($benefits));
        }else{
            return response()->json(['msg' => 'scheme_option_id not specified in the url', 'status' => 422], 422);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'year' => 'required|string',
            'scheme_option_id' => 'required|integer',
            'benefit_option_ids' => 'required|array',
            'benefit_option_ids.*.benefit_option_id' => 'required|integer',
            'limit_amount' => 'nullable|sometimes|numeric'
        ]);

        $year_id = null;
        $year = Year::where('year', '=', $request->year)->first();
        if($year){
            $year_id = $year->id;
        }

        $benefit_ids = collect($request->benefit_option_ids);
            
        foreach ($benefit_ids as $benefit){
            // Getting all the benefit option ids that are passed
            $benefit_ids_array = $benefit_ids->pluck('benefit_option_id');

            // Deleting the benefit option ids that are in the database but not passed from client
            SchemeBenefitAmount::where('scheme_option_id', '=', $request->scheme_option_id)->whereNotIn('benefit_option_id', $benefit_ids)->delete();

            // Saving the data in the scheme benefit amounts table with
            $scheme_benefits_amount = SchemeBenefitAmount::where('year_id', '=', $year_id)->where('scheme_option_id', $request['scheme_option_id'])->where('benefit_option_id', '=', $benefit['benefit_option_id'])->first();

            if(!$scheme_benefits_amount){
                $scheme_benefits_amount = new SchemeBenefitAmount;
            }

            $scheme_benefits_amount->year_id = $year_id;
            $scheme_benefits_amount->scheme_option_id = $request->scheme_option_id;
            $scheme_benefits_amount->benefit_option_id = $benefit['benefit_option_id'];
            $scheme_benefits_amount->currency_id = 1;
            $scheme_benefits_amount->save();
        }

        return response()->json(['msg' => 'saved successfully!', 'status' => 200]);

    }
}
