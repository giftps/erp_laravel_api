<?php

namespace App\Http\Controllers\Api\V1\HealthProcessings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Api\V1\HealthProcessings\ServiceProviderPriceList;
use App\Http\Resources\Api\V1\HealthProcessings\ServiceProviderPriceListsResource;

use App\Imports\ServiceProviderPricelistImport;

use Maatwebsite\Excel\Facades\Excel;

class ServiceProviderPriceListsController extends Controller
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

            $price_list = ServiceProviderPriceList::where('service_provider_id', '=', $service_provider_id)->orderBy('created_at', 'DESc')->get();

            return response()->json(ServiceProviderPriceListsResource::collection($price_list));
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
            'tariff_id' => 'required|integer',
            'year' => 'required|integer|min:' . 1990,
            'description' => 'required|string',
            'price' => 'required|numeric'
        ]);

        $price_list = new ServiceProviderPriceList;
        $price_list->service_provider_id = $request->service_provider_id;
        $price_list->tariff_id = $request->tariff_id;
        $price_list->description = $request->description;
        $price_list->year = $request->year;
        $price_list->price = $request->price;
        $price_list->save();

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
        $service_provider_price_list = ServiceProviderPriceList::with('serviceProvider')->find($id);

        if($service_provider_price_list){
            return response()->json(new ServiceProviderPriceListsResource($service_provider_price_list));
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
            'tariff_id' => 'required|integer',
            'year' => 'required|integer|min:' . 1990,
            'description' => 'required|string',
            'price' => 'required|numeric'
        ]);

        $price_list = ServiceProviderPriceList::find($id);
        $price_list->service_provider_id = $request->service_provider_id;
        $price_list->tariff_id = $request->tariff_id;
        $price_list->year = $request->year;
        $price_list->description = $request->description;
        $price_list->price = $request->price;
        $price_list->save();

        return response()->json(['msg' => 'updated successfully!'], 200);
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

    public function importPriceList(Request $request){
        $this->validate($request, [
            'excel' => 'required|mimes:xlsx,csv,xls'
        ]);

        $file = $request->file('excel');

        // Helper function for initialising import progress
        saveProgress($file, 'price_list');

        Excel::import(new ServiceProviderPricelistImport, $request->file('excel'));

        return response()->json([
            'msg' => 'Import queued successfully!'
        ], 200);
    }

    public function importProgress(){
        // This is a helper function that shows the progress of the import
        return importProgress('price_list');
    }
}
