<?php

namespace App\Http\Controllers\Api\V1\HealthProcessings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Api\V1\HealthProcessings\ServiceProviderPaymentDetail;
use App\Http\Resources\Api\V1\HealthProcessings\ServiceProviderPaymentDetailsResource;

class ServiceProviderPaymentDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(isset($_GET['service_provider_id']) && $_GET['service_provider_id'] != ''){
            $service_provider_id = $_GET['service_provider_id'];

            $payment_details = ServiceProviderPaymentDetail::where('service_provider_id', '=', $service_provider_id)->orderBy('created_at', 'DESc')->get();

            return response()->json(ServiceProviderPaymentDetailsResource::collection($payment_details));
        }else{
            return response()->json(['error' => 'please provider the service_provider_id in your url.'], 422);
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
            'service_provider_id' => 'required|integer',
            'bank' => 'required|string',
            'account_name' => 'required|string',
            'account_number' => 'required|string',
            'branch_code' => 'nullable|sometimes|string',
            'swift_code' => 'nullable|sometimes|string'
        ]);

        $payment_detail = new ServiceProviderPaymentDetail;
        $payment_detail->service_provider_id = $request->service_provider_id;
        $payment_detail->bank = $request->bank;
        $payment_detail->account_name = $request->account_name;
        $payment_detail->account_number = $request->account_number;
        $payment_detail->branch_code = $request->branch_code;
        $payment_detail->swift_code = $request->swift_code;
        $payment_detail->save();

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
        $payment_detail = ServiceProviderPaymentDetail::with('serviceProvider')->find($id);

        if($payment_detail){
            return response()->json(new ServiceProviderPaymentDetailsResource($payment_detail));
        }else{
            return response()->json(['error' => 'data with requested id not found'], 404);
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
            'service_provider_id' => 'required|integer',
            'bank' => 'required|string',
            'account_name' => 'required|string',
            'account_number' => 'required|string',
            'branch_code' => 'nullable|sometimes|string',
            'swift_code' => 'nullable|sometimes|string'
        ]);

        $payment_detail = ServiceProviderPaymentDetail::find($id);
        $payment_detail->service_provider_id = $request->service_provider_id;
        $payment_detail->bank = $request->bank;
        $payment_detail->account_name = $request->account_name;
        $payment_detail->account_number = $request->account_number;
        $payment_detail->branch_code = $request->branch_code;
        $payment_detail->swift_code = $request->swift_code;
        $payment_detail->save();

        return response()->json(['msg' => 'saved successfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
