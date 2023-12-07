<?php

namespace App\Http\Controllers\Api\V1\Membership;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Api\V1\Membership\MemberFolder;

use App\Http\Resources\Api\V1\Membership\MemberFoldersResource;

class MemberFoldersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $member_folders = MemberFolder::orderBy('created_at', 'DESC')->get();

        return response()->json(MemberFoldersResource::collection($member_folders));
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
            'name' => 'required|string'
        ]);

        $member_folder = new MemberFolder;
        $member_folder->name = $request->name;
        $member_folder->save();

        if($member_folder){
            return response()->json(['msg' => 'saved successfully!', 'status' => 200], 200);
        }else{
            return response()->json(['error' => 'failed to save', 'status' => 422], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member_folders = MemberFolder::find($id);

        return response()->json(new MemberFoldersResource($member_folders));
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

        $member_folder = MemberFolder::find($id);
        $member_folder->name = $request->name;
        $member_folder->save();

        if($member_folder){
            return response()->json(['msg' => 'saved successfully!', 'status' => 200], 200);
        }else{
            return response()->json(['error' => 'failed to save', 'status' => 422], 422);
        }
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
