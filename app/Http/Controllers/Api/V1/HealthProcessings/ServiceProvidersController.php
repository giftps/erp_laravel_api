<?php

namespace App\Http\Controllers\Api\V1\HealthProcessings;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Api\V1\HealthProcessings\ServiceProvider;

use App\Models\Api\V1\HealthProcessings\Discipline;

use App\Models\ServiceProviderContactDetail;

use App\Models\ServiceProviderBankDetail;

use App\Models\ContractDetail;

use App\Http\Resources\Api\V1\HealthProcessings\ServiceProvidersResource;

use App\Imports\ServiceProvidersImport;

use Maatwebsite\Excel\Facades\Excel;

use App\Models\Api\V1\Preauthorisations\Preauthorisation;

use App\Http\Resources\Api\V1\Preauthorisations\PreauthorisationsResource;

use App\Models\ImportProgress;

use App\Http\Resources\ImportProgressResource;

class ServiceProvidersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $service_providers = ServiceProvider::where('service_provider_id', '>', 0);

        if(isset($_GET['search'])){
            $search = $_GET['search'];

            $discipline_ids = Discipline::where('description', 'LIKE', '%' . $search . '%')->pluck('discipline_id');

            $service_providers->where('practice_number', 'LIKE', $search . '%')
                    ->orWhere('provider_name', 'LIKE', '%' . $search . '%')
                    ->orWhereIn('discipline_id', $discipline_ids);
        }

        $providers = $service_providers->orderBy('created_at', 'DESC')->get();

        return response()->json(ServiceProvidersResource::collection($providers));
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
            'discipline_id' => 'required|integer',
            'pay_currency_id' => 'required|integer',
            'receive_currency_id' => 'required|integer',
            'name' => 'required|string',
            'mobile_number' => 'required|string',
            'provider_category' => 'required|string',
            'email' => 'required|email|unique:service_providers',
            'street' => 'required|string',
            'area' => 'nullable|sometimes|string',
            'province' => 'nullable|sometimes|string',
            'country' => 'required|string',
            'practice_number' => 'required|string',
            'is_group_practice' => 'nullable|sometimes|boolean',
            'provider_type' => 'required|string',
            'is_ses_network_provider' => 'required|boolean',
            'sla' => 'required|boolean',
            'payment_term_days' => 'required|integer',
            'discount' => 'required|numeric',
            'activation_date' => 'required|date',
            'tier_level' => 'required|integer',
            'status' => 'required|string'
        ]);

        $service_provider = new ServiceProvider;
        $service_provider->discipline_id = $request->discipline_id;
        $service_provider->pay_currency_id = $request->pay_currency_id;
        $service_provider->receive_currency_id = $request->receive_currency_id;
        $service_provider->name = $request->name;
        $service_provider->email = $request->email;
        $service_provider->mobile_number = $request->mobile_number;
        $service_provider->provider_category = $request->provider_category;
        $service_provider->street = $request->street;
        $service_provider->area = $request->area;
        $service_provider->province = $request->province;
        $service_provider->country = $request->country;
        $service_provider->practice_number = $request->practice_number;
        $service_provider->is_group_practice = $request->is_group_practice;
        $service_provider->provider_type = $request->provider_type;
        $service_provider->is_ses_network_provider = $request->is_ses_network_provider;
        $service_provider->sla = $request->sla;
        $service_provider->payment_term_days = $request->payment_term_days;
        $service_provider->discount = $request->discount;
        $service_provider->activation_date = $request->activation_date;
        $service_provider->tier_level = $request->tier_level;
        $service_provider->status = $request->status;
        $service_provider->save();

        return response()->json(['msg' => 'stored successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service_provider = ServiceProvider::with(['discipline'])->find($id);

        if($service_provider){
            return response()->json(new ServiceProvidersResource($service_provider));
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
            'discipline_id' => 'required|integer',
            'pay_currency_id' => 'required|integer',
            'receive_currency_id' => 'required|integer',
            'name' => 'required|string',
            'mobile_number' => 'required|string',
            'provider_category' => 'required|string',
            'email' => 'required|email|unique:service_providers',
            'street' => 'required|string',
            'area' => 'nullable|sometimes|string',
            'province' => 'nullable|sometimes|string',
            'country' => 'required|string',
            'practice_number' => 'required|string',
            'is_group_practice' => 'nullable|sometimes|boolean',
            'provider_type' => 'required|string',
            'is_ses_network_provider' => 'required|boolean',
            'sla' => 'required|boolean',
            'payment_term_days' => 'required|integer',
            'discount' => 'required|numeric',
            'activation_date' => 'required|date',
            'tier_level' => 'required|integer',
            'status' => 'required|string'
        ]);
        
        $service_provider = ServiceProvider::find($id);
        $service_provider->discipline_id = $request->discipline_id;
        $service_provider->pay_currency_id = $request->pay_currency_id;
        $service_provider->receive_currency_id = $request->receive_currency_id;
        $service_provider->name = $request->name;
        $service_provider->mobile_number = $request->mobile_number;
        $service_provider->provider_category = $request->provider_category;
        $service_provider->email = $request->email;
        $service_provider->street = $request->street;
        $service_provider->area = $request->area;
        $service_provider->province = $request->province;
        $service_provider->country = $request->country;
        $service_provider->practice_number = $request->practice_number;
        $service_provider->is_group_practice = $request->is_group_practice;
        $service_provider->provider_type = $request->provider_type;
        $service_provider->is_ses_network_provider = $request->is_ses_network_provider;
        $service_provider->sla = $request->sla;
        $service_provider->payment_term_days = $request->payment_term_days;
        $service_provider->discount = $request->discount;
        $service_provider->activation_date = $request->activation_date;
        $service_provider->tier_level = $request->tier_level;
        $service_provider->status = $request->status;
        $service_provider->save();

        return response()->json(['msg' => 'updated successfully!']);
    }

    public function serviceProviderPreauthorisations($service_provider_id){
        $preauthorisations = Preauthorisation::where('service_provider_id', '=', $service_provider_id)->get();
        return response()->json(PreauthorisationsResource::collection($preauthorisations));
    }

    public function importServiceProviders(Request $request){
        $this->validate($request, [
            'excel' => 'required|mimes:xlsx,csv,xls'
        ]);

        $file = $request->file('excel');

        // Helper function for initialising import progress
        saveProgress($file, 'health_care_providers');

        Excel::import(new ServiceProvidersImport, $request->file('excel'));

        return response()->json([
            'msg' => 'Import queued successfully!'
        ], 200);
    }

    public function importProgress(){
        // This is a helper function that shows the progress of the import
        return importProgress('health_care_providers');
    }
}
