<?php

namespace App\Http\Controllers\Api\V1\Lookups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Api\V1\Lookups\Year;
use App\Models\Api\V1\Lookups\SchemeSubscription;
use App\Http\Resources\Api\V1\Lookups\SchemeSubscriptionsResource;

class SchemeSubscriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $scheme_subscriptions = SchemeSubscription::all();

        if(isset($_GET['scheme_option_id']) && isset($_GET['year'])){
            $scheme_option_id = $_GET['scheme_option_id'];
            $requested_year = $_GET['year'];

            $year_ids = Year::where('year', '=', $requested_year)->pluck('id');
            
            $scheme_subscriptions = SchemeSubscription::where('scheme_option_id', '=', $scheme_option_id)->whereIn('year_id', $year_ids)->get();
            response()->json(SchemeSubscriptionsResource::collection($scheme_subscriptions));
        }
    
        return response()->json(SchemeSubscriptionsResource::collection($scheme_subscriptions));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $scheme_subscriptions = SchemeSubscription::find($id);

        return response()->json(new SchemeSubscriptionsResource($scheme_subscriptions));
    }

    public function addUpdateSubscription(Request $request){
        $this->validate($request, [
            'year' => 'required|integer',
            'scheme_option_id' => 'required|integer',
            'currency_id' => 'nullable|sometimes|integer',
            'age_group_id' => 'required|integer',
            'subscription_period_id' => 'required|integer',
        ]);

        $subscription = SchemeSubscription::where('scheme_option_id', '=', $request->scheme_option_id)->where('subscription_period_id', '=', $request->subscription_period_id)->where('age_group_id', '=', $request->age_group_id)->first();

        if(!$subscription){
            $subscription = new SchemeSubscription;
        }

        $year = Year::where('year', '=', $request->year)->first();
        if(!$year){
            return response()->json(['msg' => 'selected year not found', 'status' => 404], 404);
        }

        $subscription->year_id = $year->id;
        $subscription->scheme_option_id = $request->scheme_option_id;
        $subscription->currency_id = $request->currency_id ? $request->currency_id : 1;
        $subscription->subscription_period_id = $request->subscription_period_id;
        $subscription->age_group_id = $request->age_group_id;
        if($request->amount){
            $subscription->amount = $request->amount;
        }
        if($request->tax_percentage){
            $subscription->tax_percentage = $request->tax_percentage;
        }
        $subscription->save();

        return response()->json(['msg' => 'updated successfully!', 'status' => 200], 200);
    }
}
