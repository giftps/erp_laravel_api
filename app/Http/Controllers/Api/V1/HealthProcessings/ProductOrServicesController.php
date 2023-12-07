<?php

namespace App\Http\Controllers\Api\V1\HealthProcessings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\V1\HealthProcessings\ProductOrServicePrice;
use App\Http\Resources\Api\V1\HealthProcessings\ProductOrServicePricesResource;

class ProductOrServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $service_provider_id = $_GET['service_provider_id'];
        
        $products_or_services = ProductOrServicePrice::all();

        if($service_provider_id){
            $products_or_services = ProductOrServicePrice::where('service_provider_id', '=', $service_provider_id)->get();
        }

        return response()->json(ProductOrServicePricesResource::collection($products_or_services));
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
            'service_type_id' => 'required|integer',
            'claim_code_id' => 'required|integer',
            'name' => 'required|string',
            'amount' => 'required|numeric'
        ]);

        $service = new ProductOrServicePrice;
        $service->service_provider_id = $request->service_provider_id;
        $service->claim_code_id = $request->claim_code_id;
        $service->service_type_id = $request->service_type_id;
        $service->tariff_code = $request->tariff_code;
        $service->name = $request->name;
        $service->amount = $request->amount;
        $service->save();

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
        $products_or_service = ProductOrServicePrice::find($id);

        return response()->json(new ProductOrServicePricesResource($$products_or_service));
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

        $service = ProductOrServicePrice::find($id);
        $service->service_provider_id = $request->service_provider_id;
        $service->claim_code_id = $request->claim_code_id;
        $service->service_type_id = $request->service_type_id;
        $service->tariff_code = $request->tariff_code;
        $service->name = $request->name;
        $service->amount = $request->amount;
        $service->save();

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
        ProductOrServicePrice::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!']);
    }

    public function providerServices($provider_id){
        $services = ProductOrServicePrice::where('service_provider_id', '=', $provider_id)->get();

        return response()->json(ProductOrServicePricesResource::collection($services));
    }
}
