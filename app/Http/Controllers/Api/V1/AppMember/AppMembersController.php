<?php

namespace App\Http\Controllers\Api\V1\AppMember;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Api\V1\Membership\Family;
use App\Models\Api\V1\Membership\Member;
use App\Models\Api\V1\Membership\MemberDocument;
use App\Models\Api\V1\Preauthorisations\Preauthorisation;
use App\Models\Api\V1\HealthProcessings\ServiceProvider;

use App\Http\Resources\Api\V1\Membership\MembersResource;
use App\Http\Resources\Api\V1\Membership\MemberDocumentsResource;
use App\Http\Resources\Api\V1\Preauthorisations\PreauthorisationsResource;
use App\Http\Resources\Api\V1\HealthProcessings\ServiceProvidersResource;

use App\Notifications\RegistrationCompletionCode;

use Illuminate\Support\Facades\Mail; 
use App\Mail\ContactSupport;

use App\Models\Api\V1\Membership\MemberBenefit;

use App\Http\Resources\Api\V1\Membership\MemberBenefitsResource;

class AppMembersController extends Controller
{
    /***
     * Getting the logged in member
     */

     public function authMember(){
        $member_id = auth()->user()->member_id;
        return response()->json(new MembersResource(Member::with(['family'])->find($member_id)));
     }

    /**
    * All the auth member dependants
    */
    public function authMemberDependants(){
        return response()->json(MembersResource::collection(Family::find(auth()->user()->family_id)->members));
    }

    /**
     * Getting all the documents for the particular member
     */
    public function authMemberDocuments(){
        $member_id = auth()->user()->member_id;

        $documents = MemberDocument::where('member_id', '=', $member_id)->get();

        return response()->json(MemberDocumentsResource::collection($documents));
    }

    public function authMemberPreauthorisations(){
        $member_id = auth()->user()->member_id;

        $preauthorisations = Preauthorisation::where('member_id', '=', $member_id)->get();

        return response()->json(PreauthorisationsResource::collection($preauthorisations));
    }

    public function authMemberBenefitLimits(){
        $member_id = auth()->user()?->member_id;
        
        $member_benefits = MemberBenefit::where('member_id', '=', $member_id)->where('year_id', '=', currentYearId())->get();

        if(isset($_GET['year']) && $_GET['year'] != ''){
            $year_id = getYearId($_GET['year']);
            $member_benefits = MemberBenefit::where('member_id', '=', $member_id)->where('year_id', '=', $year_id)->get();
        }

        return response()->json(MemberBenefitsResource::collection($member_benefits));
    }

    public function schemeServiceProviders(){
        $tier_level = auth()->user()->schemeOption->tier_level;

        $service_providers = ServiceProvider::where('tier_level', '=', $tier_level);
        
        $providers = $service_providers->get();

        if(isset($_GET['search']) && $_GET['search'] != ''){
            $search = $_GET['search'];
            $providers = $service_providers->where('provider_name', 'LIKE', $search . '%')->limit(10)->get();
        }

        if(isset($_GET['search']) && $_GET['search'] == ''){
            $providers = $service_providers->limit(10)->get();
        }

        return response()->json(ServiceProvidersResource::collection($providers));
    }

    public function contactSupport(Request $request){
        $this->validate($request, [
            'subject' => 'required|string',
            'message' => 'required|string'
        ]);

        Mail::to('sokoenock@gmail.com')->send(new ContactSupport($request->subject, $request->message));

        return response()->json(['msg' => 'sent', 'status' => 200], 200);
    }

    public function sendConfirmationCode(Request $request){
        $this->validate($request, [
            'identification' => 'required|string'
        ]);

        $member = Member::where('dependent_code', '=', '00')->where('email', '=', $request->identification)->orWhere('mobile_number', '=', $request->identification)->orWhere('nrc_or_passport_no', '=', $request->identification)->first();

        $code = rand(10000, 99999);

        if(!$member){
            return response()->json(['error' => 'Credentials not found'], 404);
        }

        if($member->mobile_number){
            sendAText($member->mobile_number, "Your registration code is: $code.");
        }

        $member->notify(new RegistrationCompletionCode($member, $code));

        return response()->json(['msg' => 'success', 'token' => $this->generateRegistrationToken($request->identification, $member->family_id, $code)], 200);
    }

    private function generateRegistrationToken($identification, $family_id, $code){
        $registration_token = base64_encode($identification . time());
        
        $family = Family::find($family_id);
        $family->registration_token = $registration_token;
        $family->any_code = $code;
        $family->save();

        return $registration_token;
    }

    public function isCorrectCode(Request $request){
        $this->validate($request, [
            'code' => 'required|string',
            'identification' => 'required|string'
        ]);

        $member = Member::where('dependent_code', '=', '00')->where('email', '=', $request->identification)->orWhere('mobile_number', '=', $request->identification)->orWhere('nrc_or_passport_no', '=', $request->identification)->first();
        
        $family = Family::where('id', '=', $member->family_id)->where('any_code', '=', $request->code)->first();

        if(!$family){
            return response()->json(['error' => 'You have entered an incorrect code'], 422);
        }

        return response()->json(['msg' => 'success'], 200);
    }
}
