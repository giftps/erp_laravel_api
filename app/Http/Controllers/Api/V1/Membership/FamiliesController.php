<?php

namespace App\Http\Controllers\Api\V1\Membership;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Api\V1\Membership\FamilyRequest;

use App\Models\Api\V1\Membership\Family;
use App\Models\Api\V1\Membership\Member;
use App\Models\Api\V1\Membership\MemberDocument;
use App\Models\Api\V1\Membership\FamilySchemeDetail;
use App\Http\Resources\Api\V1\Membership\FamiliesResource;

class FamiliesController extends Controller
{
    public function index()
    {
        $families = Family::all();

        return response()->json(FamiliesResource::collection($families));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FamilyRequest $request)
    {
        // Adding the family and getting the family id
        $family_id = $dependent_code = addUpdateFamily($request, 'store', null);

        // Adding the principal member from helper file
        addUpdatePrincipal($request, $family_id, null, 'store');

        addUpdateDependents($request->dependents, $family_id, $request->scheme_option_id, $request->scheme_type_id, 'store');

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
        $family = Family::with('members', 'familySchemeDetails')->find($id);

        return response()->json(new FamiliesResource($family));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FamilyRequest $request, $id)
    {
        // Adding the family and getting the family id from the helpers
        $family_id = $dependent_code = addUpdateFamily($request, 'update', $id);

        // Getting the id of the priciple member
        $member_id = Family::find($family_id)->members()->where('dependent_code', '=', '00')->first()->member_id;

        // Calling principal member store or update from helper
        addUpdatePrincipal($request, $family_id, $member_id, 'update');

        // Calling method from helper file
        addUpdateDependents($request->dependents, $family_id, $request->scheme_option_id, $request->scheme_type_id, 'store');

        return response()->json(['msg' => 'updated successfully!', 'status' => 200], 200);
    }

    // Uploading the benefit start date
    public function schemeDetails($request, $family_id, $method){

        $family_scheme_details = null;

        if($method == 'store'){
            $family_scheme_details = new FamilySchemeDetail;
        }else if($method == 'update'){
            $family_scheme_details = FamilySchemeDetail::find($request->family_scheme_detail_id);
        }

        $family_scheme_details->benefit_start_date = $request->benefit_start_date;
        $family_scheme_details->benefit_end_date = $request->benefit_end_date;
        $family_scheme_details->has_funeral_cash_benefit = $request->has_funeral_cash_benefit;
        $family_scheme_details->funeral_benefit_start_date = $request->funeral_benefit_start_date;
        $family_scheme_details->funeral_benefit_end_date = $request->funeral_benefit_end_date;
        $family_scheme_details->beneficiary_name = $request->beneficiary_name;
        $family_scheme_details->beneficiary_mobile_number = $request->beneficiary_mobile_number;
        $family_scheme_details->beneficiary2_name = $request->beneficiary2_name;
        $family_scheme_details->beneficiary2_mobile_number = $request->beneficiary2_mobile_number;
        $family_scheme_details->save();

        return 'saved';
    }

    public function membershipForm($member_id){
        $family = Member::find($member_id)->family;
        $member_id = $family->members()->where('dependent_code', '=', '00')->first()?->member_id;

        $member_document = MemberDocument::where('member_id', '=', $member_id)->where('name', 'LIKE', '%Membership Form%')->orderBy('created_at', 'DESC')->first();
        return response()->json(url()->to('') . $member_document?->path);
    }

    public function updateFamilyCommonInfo(Request $request, $id){
        $this->validate($request, [
            'subscription_period_id' => 'required|integer',
            'physical_address' => 'required|string',
            'postal_address' => 'nullable|sometimes|string',
            'postal_code' => 'nullable|sometimes|string',
            'status' => 'required|string',
            'has_funeral_cash_benefit' => 'required|boolean',
            'funeral_benefit_start_date' => 'required|date',
            'funeral_benefit_end_date' => 'required|date',
            'beneficiary_name' => 'nullable|sometimes|string',
            'beneficiary_mobile_number' => 'nullable|sometimes|string',
            'beneficary2_name' => 'nullable|sometimes|string',
            'beneficiary2_mobile_number' => 'nullable|sometimes|string'
        ]);

        $family = Family::find($id);
        $family->subscription_period_id = $request->subscription_period_id;
        $family->physical_address = $request->physical_address;
        $family->postal_address = $request->postal_address;
        $family->postal_code = $request->postal_code;
        $family->status = $request->status;
        $family->has_funeral_cash_benefit = $request->has_funeral_cash_benefit;
        $family->funeral_benefit_start_date = $request->funeral_benefit_start_date;
        $family->funeral_benefit_end_date = $request->funeral_benefit_end_date;
        $family->beneficiary_name = $request->beneficiary_name;
        $family->beneficiary_mobile_number = $request->beneficiary_mobile_number;
        $family->funeral_benefit_end_date = $request->funeral_benefit_end_date;
        $family->beneficiary2_name = $request->beneficiary2_name;
        $family->beneficiary2_mobile_number = $request->beneficiary2_mobile_number;
        $family->save();

        return response()->json(['msg' => 'updated successfully!', 'status' => 200], 200);
    }

    public function changeFamilyStatus(Request $request, $id){
        $this->validate($request, [
            'status' => 'required|string|in:active,suspended'
        ]);

        $date = date('Y-m-d');

        if($request->status == 'active'){
            // Removing member from holding tank and activating
            Family::where('id', '=', $id)->update(['status' => 'active', 'in_holding_tank' => false]);

            // Getting the members in the family
            $members = Member::where('family_id', $id)->where('is_resigned', '=', 0)->get();

            // Calling the method for adding benefits to members
            foreach($members as $member){
                addMemberBenefits($member->member_id);
            }

            return response()->json(['msg' => 'family activated successfully!'], 200);
        }

        if($request->status == 'suspended' && Family::find($id)?->status != 'suspended'){
            $family = Family::find($id);
            $family->status = $request->status;
            $family->in_holding_tank = false;
            $family->save();

            return response()->json(['msg' => 'family suspended successfully!'], 200);
        }
    }
}
