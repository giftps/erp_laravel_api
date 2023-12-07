<?php

namespace App\Http\Controllers\Api\V1\HealthProcessings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\V1\HealthProcessings\ServiceProviderContact;
use App\Http\Resources\Api\V1\HealthProcessings\ServiceProviderContactsResource;

class ServiceProviderContactsController extends Controller
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

            $contacts = ServiceProviderContact::where('service_provider_id', '=', $service_provider_id)->get();

            return response()->json(ServiceProviderContactsResource::collection($contacts));
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'contact_number' => 'required|string',
            'mobile_number' => 'required|string',
            'email' => 'required|email',
            'designation' => 'required|string'
        ]);

        $contact = new ServiceProviderContact;
        $contact->service_provider_id = $request->service_provider_id;
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;
        $contact->contact_number = $request->contact_number;
        $contact->mobile_number = $request->mobile_number;
        $contact->email = $request->email;
        $contact->designation = $request->designation;
        $contact->save();

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
        $contact = ServiceProviderContact::with(['serviceProvider'])->find($id);

        if($contact){
            return response()->json(new ServiceProviderContactsResource($contact));
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'contact_number' => 'required|string',
            'mobile_number' => 'required|string',
            'email' => 'required|email',
            'designation' => 'required|string'
        ]);

        $contact = ServiceProviderContact::find($id);
        $contact->service_provider_id = $request->service_provider_id;
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;
        $contact->contact_number = $request->contact_number;
        $contact->mobile_number = $request->mobile_number;
        $contact->email = $request->email;
        $contact->designation = $request->designation;
        $contact->save();

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
}
