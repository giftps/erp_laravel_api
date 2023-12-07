<?php

namespace App\Http\Controllers\Api\V1\Media;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Api\V1\Media\Folder;
use App\Http\Resources\Api\V1\Media\FoldersResource;

class FoldersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $folders = Folder::orderBy('created_at', 'DESC')->get();

        if(isset($_GET['department']) && $_GET['department'] != ''){
            $department = $_GET['department'];
            $folders = Folder::where('department', '=', $department)->orderBy('created_at', 'DESC')->get();
        }

        return response()->json(FoldersResource::collection($folders));
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
            'department' => 'required|string|in:membership,sales,finance,claims,service_provider'
        ]);

        $folder = new Folder;
        $folder->name = $request->name;
        $folder->department = $request->department;
        $folder->save();

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
        $folder = Folder::find($id);

        if(!$folder){
            return response()->json(['error' => 'folder not found'], 404);
        }

        return response()->json(new FoldersResource($folder));
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
            'department' => 'required|string|in:membership,sales,finance,claims'
        ]);

        $folder = Folder::find($id);
        $folder->name = $request->name;
        $folder->department = $request->department;
        $folder->save();

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
        $folder = Folder::find($id);

        if(!$folder){
            return response()->json(['error' => 'folder not found'], 404);
        }

        $folder->delete();

        return response()->json(['msg' => 'deleted successfully!'], 200);
    }
}
