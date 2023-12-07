<?php

namespace App\Http\Controllers\Api\V1\Membership;

use App\Http\Controllers\Controller;
use App\Models\Api\V1\Sales\Quotation;
use App\Models\Api\V1\Membership\Invoice;
use Illuminate\Http\Request;

use App\Models\Api\V1\Membership\MemberDocument;
use App\Models\Api\V1\Membership\Member;
use App\Http\Resources\Api\V1\Membership\MemberDocumentsResource;
use App\Http\Requests\Api\V1\Membership\MemberDocumentsRequest;

class MemberDocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(isset($_GET['member_id']) && $_GET['member_id'] !== ''){
            if(isset($_GET['folder_id']) && $_GET['folder_id'] !== ''){
                $member_id = $_GET['member_id'];
                $family_id = Member::find($member_id)?->family_id;

                $member_folder_id = $_GET['folder_id'];

                $documents = MemberDocument::where('member_id', '=', $member_id)->where('member_folder_id', '=', $member_folder_id)->get();
                
                return response()->json(MemberDocumentsResource::collection($documents));
            }else{
                return response()->json(['msg' => 'the folder id was not specified in the url', 'status' => 422], 422);
            }
        }else{
            return response()->json(['msg' => 'the member id was not specified in the url', 'status' => 422], 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MemberDocumentsRequest $request)
    {
        $document = new MemberDocument;
        $document->member_id = $request->member_id;
        $document->name = $request->name;
        $document->path = storeFile($request->file, str_replace(" ", "_", $request->name));
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
        $documents = MemberDocument::with('member')->find($id);

        return response()->json(new MemberDocumentsResource($documents));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MemberDocumentsRequest $request, $id)
    {
        $document = MemberDocument::find($id);
        $document->member_id = $request->member_id;
        $document->name = $request->name;
        $document->path = storeFile($request->document, str_replace(" ", "_", $request->name));
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
        MemberDocument::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!', 'status' => 200], 200);
    }
}
