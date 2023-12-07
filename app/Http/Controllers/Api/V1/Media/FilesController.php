<?php

namespace App\Http\Controllers\Api\V1\Media;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\V1\Media\File;
use App\Http\Resources\Api\V1\Media\FilesResource;

use App\Models\Api\V1\Membership\Member;
use App\Models\Api\V1\Sales\Broker;
use App\Models\Api\V1\Sales\BrokerHouse;
use App\Models\Api\V1\HealthProcessings\ServiceProvider;

class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!isset($_GET['folder_id'])){
            return response()->json(['error' => 'folder_id not added in query string'], 422);
        }

        $folder_id = $_GET['folder_id'];
        
        $files = File::where('folder_id', '=', $folder_id)->orderBy('created_at', 'DESC')->get();

        if(isset($_GET['fileable_id'])){
            $fileable_id = $_GET['fileable_id'];
            $files = File::where('folder_id', '=', $folder_id)->where('fileable_id', '=', $fileable_id)->orderBy('created_at', 'DESC')->get();
        }

        return response()->json(FilesResource::collection($files));
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
            'folder_id' => 'required|integer',
            'name' => 'nullable|sometimes|string',
            'file' => 'required|mimes:pdf,docx,png,jpg,jpeg,csv,xlsx,xls',
            'fileable_id' => 'required|integer',
            'fileable_type' => 'required|string|in:member,broker,broker_house,service_provider'
        ]);

        $file_association = $this->fileableAssociation($request->fileable_id, $request->fileable_type);

        $file = new File;
        $file->folder_id = $request->folder_id;
        $file->name = $request->name;
        $file->fileable()->associate($file_association);
        $file->path = storeFile($request->file, str_replace(" ", "_", 'uploaded_documents'));
        $file->save();

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
        $file = File::find($id);

        if(!$file){
            return response()->json(['error' => 'file not found'], 404);
        }

        return response()->json(new FilesResource($file));
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
            'folder_id' => 'required|integer',
            'name' => 'nullable|sometimes|string',
            'file' => 'required|mimes:pdf,docx,png,jpg,jpeg,csv,xlsx,xls',
            'fileable_id' => 'required|integer',
            'fileable_type' => 'required|string|in:member,broker,broker_house,service_provider'
        ]);

        $file_association = $this->fileableAssociation($request->fileable_id, $request->fileable_type);

        $file = File::find($id);
        $file->folder_id = $request->folder_id;
        $file->name = $request->name;
        $file->fileable()->associate($file_association);
        $file->path = storeFile($request->file, str_replace(" ", "_", 'uploaded_documents'));
        $file->save();

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
        $file = File::find($id);

        if(!$file){
            return response()->json(['error' => 'file not found'], 404);
        }

        $file->delete();

        return response()->json(['msg' => 'deleted successfully!'], 200);
    }

    private function fileableAssociation($fileable_id, $filable_type){
        // member,broker,broker_house,service_provider
        if($filable_type == 'member'){
            return Member::find($fileable_id);
        }

        if($filable_type == 'broker'){
            return Broker::find($fileable_id);
        }

        if($filable_type == 'broker_house'){
            return BrokerHouse::find($fileable_id);
        }

        if($filable_type == 'service_provider'){
            return ServiceProvider::find($fileable_id);
        }
    }
}
