<?php

namespace App\Http\Controllers\Api\V1\Membership;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Api\V1\Membership\MemberRequest;
use App\Models\Api\V1\Claims\Claim;
use App\Models\Api\V1\Membership\Family;
use App\Models\Api\V1\Sales\Broker;
use App\Models\Api\V1\Sales\BrokerHouse;
use App\Models\Api\V1\Membership\Member;
use App\Models\Api\V1\Membership\MemberBenefit;
use App\Models\Api\V1\Membership\MemberDocument;
use App\Models\Api\V1\Lookups\Year;
use App\Models\Api\V1\Lookups\ResignCode;
use App\Models\Api\V1\Lookups\BenefitOption;
use App\Models\Api\V1\Preauthorisations\Preauthorisation;
use App\Http\Resources\Api\V1\Preauthorisations\PreauthorisationsResource;
use App\Models\Api\V1\Lookups\SchemeBenefitAmount;
use App\Http\Resources\Api\V1\Membership\MembersResource;
use App\Http\Resources\Api\V1\Membership\MemberDocumentsResource;
use App\Http\Resources\Api\V1\Membership\MemberBenefitsResource;
use App\Imports\MembersImport;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $family_ids = null;

        if(isset($_GET['in_holding_tank']) && $_GET['in_holding_tank'] == 1){
            $family_ids = Family::where('in_holding_tank', '=', 1)->pluck('id');
        }else{

            if(isset($_GET['group_id']) && $_GET['group_id'] != ''){
                $group_id = $_GET['group_id'];

                $family_ids = Family::where('group_id', '=', $group_id)->pluck('id');
            }else{
                $family_ids = Family::where('in_holding_tank', '=', 0)->pluck('id');
            }
        }

        $members = Member::where('member_id', '>', 0);

        if(isset($_GET['search']) && $_GET['search'] != ''){
            $search = $_GET['search'];

            $members->where('member_number', 'LIKE', $search . '%')
                    ->orWhere('first_name', 'LIKE', $search . '%')
                    ->orWhere('last_name', 'LIKE', $search . '%')
                    ->orWhere('email', 'LIKE', $search . '%')
                    ->orWhere('mobile_number', 'LIKE', '%' . $search . '%');
        }

        $members->whereIn('family_id', $family_ids);

        $final_members = $members->paginate(25);

        return response()->json(MembersResource::collection($final_members));
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
            'title' => 'nullable|sometimes|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'other_names' => 'nullable|sometimes|string',
            'marital_status' => 'nullable|sometimes|string',
            'dob' => 'required|string',
            'gender'=> 'required|string',
            'nrc_or_passport_no' => 'nullable|sometimes|string',
            'occupation' => 'nullable|sometimes|string',
            'relationship' => 'nullable|sometimes|string',
            'email' => 'nullable|sometimes|email',
            'work_number' => 'nullable|sometimes|string',
            'mobile_number' => 'nullable|sometimes|string',
            // 'join_date' => 'required|date',
            // 'weight' => 'required',
            // 'height' => 'required',
        ]);

        $member = Member::find($id);
        $member->title = $request->title;
        $member->first_name = $request->first_name;
        $member->last_name = $request->last_name;
        $member->other_names = $request->other_names;
        $member->marital_status = $request->marital_status;
        $member->dob = $request->dob;
        $member->gender = $request->gender;
        $member->nrc_or_passport_no = $request->nrc_or_passport_no;
        $member->occupation = $request->occupation;
        $member->relationship = $request->relationship;
        $member->email = $request->email;
        $member->work_number = $request->work_number;
        $member->mobile_number = $request->mobile_number;
        $member->join_date = $request->join_date;
        $member->weight = $request->weight;
        $member->height = $request->height;
        $member->save();

        $name = auth()->user()->first_name . ' ' . auth()->user()->last_name;

        memberActivity($member->member_id, $name . ' updated member details.');

        return response()->json(['msg' => 'updated successfully!', 'status' => 200], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member = null;

        if (auth()->user()->brokerHouse){
            $broker_house_id = auth()->user()->brokerHouse->broker_house_id;

            $member = Member::with(['family', 'documents'])->where('member_id', '=', $id)->first();

            if($broker_house_id === $member->family->broker->brokerHouse->broker_house_id){
                return response()->json(new MembersResource($member));
            }else{
                return response()->json(['erorr' => 'You do not have permission', 'status' => 401], 401);
            }
        }

        if (auth()->user()->broker){

            $broker_id = auth()->user()->broker->broker_id;

            // $family_ids = Family::where('broker_id', '=', $broker_id);

            $member = Member::with(['family', 'documents'])->where('member_id', '=', $id)->first();

            if($broker_id === $member->family->broker_id){
                return response()->json(new MembersResource($member));
            }else{
                return response()->json(['erorr' => 'You do not have permission', 'status' => 401], 401);
            }
        }

        $member = Member::with(['family', 'documents'])->find($id);

        return response()->json(new MembersResource($member));
    }

    public function memberByToken($token, $id){
        $family = Family::where('registration_token', '=', $token)->first();

        if(!$family){
            return response()->json(['error' => 'invalid token', 'status' => 498], 498);
        }

        $member = $family->members()->where('member_id', '=', $id)->first();

        return response()->json(new MembersResource($member));
    }

    public function memberBenefitLimits($member_id){
        // Calling the helper function
        // return benefitLimits($id);

        $member_benefits = MemberBenefit::where('member_id', '=', $member_id)->where('year_id', '=', currentYearId())->get();

        if(isset($_GET['year']) && $_GET['year'] != ''){
            $year_id = getYearId($_GET['year']);
            $member_benefits = MemberBenefit::where('member_id', '=', $member_id)->where('year_id', '=', $year_id)->get();
        }

        return response()->json(MemberBenefitsResource::collection($member_benefits));
    }

    public function memberPreauthorisations($member_id){
        $preauthorisations = Preauthorisation::where('member_id', '=', $member_id)->orderBy('created_at', 'DESC')->get();

        if(isset($_GET['filter_by']) && $_GET['filter_by'] === 'last_auths'){
            $preauthorisations = Preauthorisation::where('member_id', '=', $member_id)->limit(5)->orderBy('created_at', 'DESC')->get();
        }

        if(isset($_GET['filter_by']) && $_GET['filter_by'] === 'pending'){
            $preauthorisations = Preauthorisation::where('member_id', '=', $member_id)->where('status', '=', 'pending')->orderBy('created_at', 'DESC')->get();
        }

        return response()->json(PreauthorisationsResource::collection($preauthorisations));
    }

    public function memberBenefitYears($member_id){
        $member = Member::find($member_id);

        $join_date = $member->join_date;

        $year_from = (int)date('Y', strtotime($join_date));
        $year_to = (int)date('Y');

        $years = [];

        if($join_date){
            for($i = $year_from; $i <= $year_to; $i++){
                array_push($years, [
                    'year' => $i
                ]);
            }
        }else{
            $years = [['year' => date('Y')]];
        }

        return $years;
    }

    /**
     * Viewing the documents that belong to a member
     */
    public function memberDocuments($member_id){
        $member_documents = MemberDocument::where('member_id', '=', $member_id)->get();

        return response()->json(MemberDocumentsResource::collection($member_documents));
    }

    /**
     * Importing members from excel file
     */
    public function importMembers(Request $request){
        Excel::import(new MembersImport, $request->file('excel'));
    
        return response()->json(['msg' => 'imported successfully!', 'status' => 200], 200);
    }

    // Checking if the member whose quotation is about to be generated already exists in the system
    public function checkMemberExistence($value){
        $member = Member::with(['family'])
                    ->where('dependent_code', '=', '00')
                    ->where(function($query) use ($value){
                        $query->where('email', '=', $value)
                        ->orWhere('nrc_or_passport_no', '=', $value)
                        ->orWhere('mobile_number', '=', $value);
                    })->first();

        if(!$member){
            return null;
        }

        return response()->json(new MembersResource($member));
    }

    public function memberPreauths($member_id){
        $assessed_preauth_ids =  Claim::where('member_id', '=', $member_id)->pluck('preauthorisation_id');

        $member_preauths = Preauthorisation::where('member_id', '=', $member_id)->where('status', '=', 'active')->whereNotIn('id', $assessed_preauth_ids)->orderBy('created_at', 'DESC')->get();

        return response()->json(PreauthorisationsResource::collection($member_preauths));
    }

    public function resignMember(Request $request, $id){
        $this->validate($request, [
            'resign_code_id' => 'required|integer'
        ]);

        $resign_code = ResignCode::find($request->resign_code_id);

        if($resign_code){
            $member = Member::find($id);
            $member->is_resigned = true;
            $member->resign_code = $resign_code->code;
            $member->save();

            return response()->json(['msg' => 'successfully resigned'], 200);
        }else{
            return response()->json(['error' => 'resign code not found'], 404);
        }
    }
}