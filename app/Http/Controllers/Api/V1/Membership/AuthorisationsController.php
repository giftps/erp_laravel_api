<?php

namespace App\Http\Controllers\Api\V1\Membership;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\V1\Membership\Authorization;
use App\Models\Api\V1\Membership\Member;
use App\Models\Api\V1\Lookups\ClaimCode;
use App\Http\Resources\Api\V1\Membership\AuthorisationsResource;

class AuthorisationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authorisations = Authorization::with(['authoriser', 'member'])->orderBy('created_at', 'DESC')->get();

        return response()->json(AuthorisationsResource::collection($authorisations));
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
            'member_number' => 'required|integer',
            'service_provider_id' => 'required|integer',
            'claim_code' => 'required|integer',
            'notes' => 'nullable|sometimes|string'
        ]);

        $member = Member::where('member_number', '=', $request->member_number)->first();
        $claim_code = Member::where('code', '=', $request->claim_code)->first();

        if(!$member){
            return response()->json(['msg' => 'member number not found', 'status' => 404], 404);
        }

        if(!$claim_code){
            return response()->json(['msg' => 'claim code not found', 'status' => 404], 404);
        }
        
        $authorisation = new Authorisation;
        $authorisation->auth_code = $this->generateAuthCode();
        $authorisation->member_id = $member->member_id;
        $authorisation->claim_code = $claim_code->id;
        $authorisation->service_provider_id = $request->service_provider_id;
        $authorisation->authorizer_id = auth('api')->user()->user_id;
        $authorisation->notes = $request->notes;
        $authorisation->gop_sent = false;
        $authorisation->is_cancelled = false;

        $authorisation->save();

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
        $authorisation = Authorisation::with(['authoriser', 'member'])->find($id);

        return response()->json(new AuthorisationsResource($authorisation));
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
            'member_number' => 'required|integer',
            'service_provider_id' => 'required|integer',
            'claim_code' => 'required|integer',
            'notes' => 'nullable|sometimes|string'
        ]);

        $member = Member::where('member_number', '=', $request->member_number)->first();
        $claim_code = Member::where('code', '=', $request->claim_code)->first();

        if(!$member){
            return response()->json(['msg' => 'member number not found', 'status' => 404], 404);
        }

        if(!$claim_code){
            return response()->json(['msg' => 'claim code not found', 'status' => 404], 404);
        }
        
        $authorisation = Authorisation::find($id);
        $authorisation->auth_code = $this->generateAuthCode();
        $authorisation->member_id = $member->member_id;
        $authorisation->claim_code = $claim_code->id;
        $authorisation->service_provider_id = $request->service_provider_id;
        $authorisation->authorizer_id = auth('api')->user()->user_id;
        $authorisation->notes = $request->notes;
        $authorisation->gop_sent = false;
        $authorisation->is_cancelled = false;

        $authorisation->save();

        return response()->json(['msg' => 'updated successfully!', 'status' => 200], 200);
    }

    private function generateAuthCode(){
        // Generating the member number
        $authorisation = Authorisation::all()->last();
        $nextId = ($authorisation === null ? 0 : $authorisation->id) + 1;

        $suffix = str_pad($nextId, 5, '0', STR_PAD_LEFT);

        $authorisation = $suffix;

        return $authorisation;
    }
}
