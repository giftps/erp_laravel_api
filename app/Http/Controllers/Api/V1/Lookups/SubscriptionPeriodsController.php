<?php

namespace App\Http\Controllers\Api\V1\Lookups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Api\V1\Lookups\SubscriptionPeriod;
use App\Http\Resources\Api\V1\Lookups\SubscriptionPeriodsResource;

class SubscriptionPeriodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscription_periods = SubscriptionPeriod::all();

        return response()->json(SubscriptionPeriodsResource::collection($subscription_periods));
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
            'status' => 'required|string'
        ]);

        $subscription_periods = new SubscriptionPeriod;
        $subscription_periods->name = $request->name;
        $subscription_periods->status = $request->status;
        $subscription_periods->save();

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
        $subscription_periods = SubscriptionPeriod::find($id);

        return response()->json(new SubscriptionPeriodsResource($subscription_periods));
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
            'status' => 'required|string'
        ]);

        $subscription_periods = SubscriptionPeriod::find($id);
        $subscription_periods->name = $request->name;
        $subscription_periods->status = $request->status;
        $subscription_periods->save();

        return response()->json(['msg' => 'updated successfully!', 'status' => 200], 200);
    }
}
