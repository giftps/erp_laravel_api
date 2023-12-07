<?php

namespace App\Http\Controllers\Api\V1\HealthProcessings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File; 

use App\Models\Api\V1\HealthProcessings\ServiceProviderDocument;
use App\Http\Resources\Api\V1\HealthProcessings\ServiceProviderDocumentsResource;

class ServiceProviderDocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!isset($_GET['service_provider_id']) || $_GET['service_provider_id'] == ''){
            return response()->json(['please provide the service_provider_id'], 422);
        }

        $documents = ServiceProviderDocument::orderBy('created_at', 'DESC')->get();

        $service_provider_id = $_GET['service_provider_id'];

        if ($service_provider_id){
            $documents = ServiceProviderDocument::where('service_provider_id', '=', $service_provider_id)->orderBy('created_at', 'DESc')->get();
        }

        return response()->json(ServiceProviderDocumentsResource::collection($documents));
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
            'folder_id' => 'nullable|sometimes|integer',
            'name' => 'required|string',
            'file' => 'required|mimes:pdf,docx,png,jpg,jpeg,csv,xlsx,xls'
        ]);

        $document = new ServiceProviderDocument;
        $document->service_provider_id = $request->service_provider_id;
        $document->name = $request->name;
        $document->url = storeFile($request->file, str_replace(" ", "_", 'Service_Providers'));
        $document->save();

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
        $document = ServiceProviderDocument::find($id);

        if($document){
            return response()->json(new ServiceProviderDocumentsResource($document));
        }

        return response()->json(['error' => 'the supplied ID not found'], 404);
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
            'folder_id' => 'nullable|sometimes|integer',
            'name' => 'required|string',
            'file' => 'required|mimes:pdf,docx,png,jpg,jpeg,csv,xlsx,xls'
        ]);

        $document = ServiceProviderDocument::find($id);
        $document->service_provider_id = $request->service_provider_id;
        $document->name = $request->name;
        if($request->file){
            File::delete($document->url);
            $document->url = storeFile($request->file, str_replace(" ", "_", 'Service_Providers'));
        }
        $document->save();

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
        $document = ServiceProviderDocument::find($id);

        File::delete($document->url);

        $document->delete();

        return response()->json(['msg' => 'deleted successfully!', 'status' => 200], 200);
    }
}
