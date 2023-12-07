<?php

namespace App\Http\Controllers\Api\V1\NonStaffUsers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Api\V1\Membership\Family;

use App\Models\Api\V1\Lookups\SubscriptionPeriod;

use App\Models\Api\V1\Membership\Member;
use App\Models\Api\V1\Membership\MemberFolder;

use App\Models\Api\V1\Sales\Broker;

use App\Models\Api\V1\Sales\BrokerHouse;

use App\Models\Api\V1\Sales\Quotation;

use App\Http\Resources\Api\V1\Sales\BrokersResource;

use App\Models\Api\V1\Lookups\SchemeOption;

use App\Http\Resources\Api\V1\Membership\MembersResource;

use App\Models\Api\V1\Membership\MemberDocument;

use App\Notifications\MemberQuotation;

use Illuminate\Support\Facades\Storage;

use PDF;

use Carbon\Carbon;

class BrokersController extends Controller
{
    public function brokerDetails(){
        return response()->json(new BrokersResource(auth('api')->user()->broker));
    }

    public function editBroker(Request $request){
        $this->validate($request, [
            'address1' => 'required|string',
            'city' => 'required|string',
            'phone_number' => 'required|string',
        ]);

        $user = auth()->user();

        $broker = Broker::find($user->broker->broker_id);
        $broker->address1 = $request->address1;
        $broker->address2 = $request->address2;
        $broker->city = $request->city;
        $broker->office_number = $request->office_number;
        $broker->phone_number = $request->phone_number;
        $broker->save();

        return response()->json(['msg' => 'saved successfully!', 'status' => 200], 200);
    }

    public function members(){
        $broker_id = auth('api')->user()->broker?->broker_id;

        if(isset($_GET['broker_id'])){
            $broker_id = $_GET['broker_id'];
        }

        $family_ids = Family::where('broker_id', '=', $broker_id)->pluck('id');

        if(!$family_ids){
            return response()->json(['msg' => 'not found', 'status' => 404], 404);
        }

        $members = Member::whereIn('family_id', $family_ids)->get();

        return response()->json(MembersResource::collection($members));
    }

    public function memberDetails($id){
        $main_members = auth('api')->user()->broker->Familys()->with(['Members'])->find($id);

        return response()->json(new MembersResource($main_members));
    }

    // Method for adding the member and Members being registered to the database.
    public function addMembers(Request $request){
        $this->validate($request, [
            'title' => 'required|string',
            'broker_id' => 'nullable|sometimes|string',
            'group_type_id' => 'required|integer',
            'subscription_period_id' => 'required|integer',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'is_existing_member' => 'required|boolean',
            'cover_start_date' => 'required|date',
            'email' => ($request->is_existing_member == true || $request->is_existing_member == 1) ? 'nullable' : 'required|email|unique:members',
            'mobile_number' => 'required|string',
            'dob' => 'required|date',
            'gender' => 'required|string|in:Male,Female',
            'scheme_option_id' => $request->quotation_type !== 'comparative' ? 'required|integer' : '',
            'quotation_type' => 'required|string|in:comparative,specific',
            'dependents' => 'nullable|sometimes|array',
            'dependents.*.first_name' => 'required|string',
            'dependents.*.last_name' => 'required|string',
            'dependents.*.dob' => 'required|string',
            'dependents.*.email' => 'nullable|sometimes|email|unique:members',
        ]);

        if($request->is_existing_member == true || $request->is_existing_member == 1){
            $registration_token = base64_encode($request->email . time());

            $member = Member::where('email', '=', $request->email)->first();

            if($member){
                $family = Family::find($member->family_id);
                $family->registration_token = $registration_token;
                $family->benefit_start_date = $request->cover_start_date;
                $family->save();
                
                $this->sendNotificationToBrokerAndMember($request, $family, $registration_token);

                return response()->json(['msg' => 'quotation generated successfully'], 200);
            }else{
                return response()->json(['error' => 'family with that email not found'], 404);
            }
        }

        $broker_id = auth('api')->user()->broker ? auth('api')->user()->broker->broker_id : null;

        // Checking if user generating quotation doesnt exist as broker
        // If the user doesnt exist as broker, the user information is added to broker
        if(!$broker_id){
            $broker_id = $this->createSESBroker();
        }

        // Generating the registration token for the user
        $registration_token = base64_encode($request->email . time());

        $family = $this->saveFamily($request, $broker_id, $registration_token);

        // Saving Members
        if($this->saveMembers($request, $family->id) !== "saved"){
            Family::find($family->family_id)->delete();
            return response()->json(['msg' => 'failed to save Members', 'status' => 500], 500);
        }

        // Sending notification to member and broker
        $this->sendNotificationToBrokerAndMember($request, $family, $registration_token);
        
        return response()->json(['msg' => 'saved successfully!', 'registration_token' => $registration_token, 'status' => 200], 200);
    }

    public function updateMember(Request $request, $id){
        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'dob' => 'required|string',
            'email' => 'nullable|sometimes|email|unique:members',
        ]);

        $member = Member::find($id);
        $member->scheme_option_id = $request->scheme_option_id;
        $member->first_name = $request->first_name;
        $member->last_name = $request->last_name;
        $member->dob = $request->dob;
        $member->gender = isset($request->gender) ? $request->gender : '';
        $member->save();

        return response()->json(['msg' => 'updated successfully!', 'status' => 200], 200);
    }

    private function saveFamily($request, $broker_id, $registration_token){
        // Saving the member
        $family = new Family;
        $family->family_code = $this->familyCode($request);
        $family->broker_id = $broker_id;
        $family->group_type_id = $request->group_type_id;
        $family->subscription_period_id = $request->subscription_period_id;
        $family->application_date = date('Y-m-d');
        $family->in_holding_tank = true;
        $family->registration_token = $registration_token;
        $family->benefit_start_date = $request->cover_start_date;
        $family->token_expires_at = Carbon::now()->addMinutes(15);
        $family->registration_stage = 'accept quotation';
        $family->status = 'incomplete';
        $family->save();

        return $family;
    }

    private function saveMembers($request, $family_id){
        $member = new Member;
        $member->member_number = $this->memberNumber();
        $member->title = $request->title;
        $member->dependent_code = "00";
        $member->family_id = $family_id;
        $member->first_name = $request->first_name;
        $member->last_name = $request->last_name;
        $member->email = $request->email;
        $member->mobile_number = $request->mobile_number;
        $member->has_sports_loading = $request->has_sports_loading ? $request->has_sports_loading : false;
        $member->sporting_activity = $request->sporting_activity;
        $member->scheme_option_id = $request->scheme_option_id;
        $member->is_principal = true;
        $member->dob = $request->dob;
        $member->gender = $request->gender;
        $member->save();

        if ($request->dependents && count($request->dependents) > 0){
            for($i=0; $i < count($request->dependents); $i++){

                $dep_code = $i + 1;

                $member = new Member;
                $member->member_number = $this->memberNumber();
                $member->family_id = $family_id;
                $member->dependent_code = "0$dep_code";
                $member->first_name = $request->dependents[$i]['first_name'];
                $member->last_name = $request->dependents[$i]['last_name'];
                $member->dob = $request->dependents[$i]['dob'];
                $member->scheme_option_id = isset($request->dependents[$i]['scheme_option_id']) ? $request->dependents[$i]['scheme_option_id'] : null;
                $member->has_sports_loading = isset($request->dependents[$i]['has_sports_loading']) ? $request->dependents[$i]['has_sports_loading'] : false;
                $member->gender = isset($request->dependents[$i]['gender']) ? $request->dependents[$i]['gender'] : '';
                $member->save();
            }
        }
        return "saved";
    }

    private function familyCode($request){
        // Generating family code
        $last_id = Family::all()->last();
        $nextId = ($last_id === null ? 0 : $last_id->id) + 1;

        $suffix = str_pad($nextId, 5, '0', STR_PAD_LEFT);

        $family_code = ucfirst(substr($request->last_name, 0, 3)) . $suffix;

        return $family_code;
    }

    private function memberNumber(){
        // Generating the Membership Number
        $last_id = Member::all()->last();
        $nextId = ($last_id === null ? 0 : $last_id->member_id) + 1;

        $suffix = str_pad($nextId, 5, '0', STR_PAD_LEFT);

        $membership_number = '10' . $suffix;

        return $membership_number;
    }

    private function quotationNumber(){
        // Generating the Membership Number
        $last_id = Quotation::all()->last();
        $nextId = ($last_id === null ? 0 : $last_id->id) + 1;

        $suffix = str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $quotation_number = date('y') . $suffix;

        return $quotation_number;
    }

    private function saveQuotation($request, $family_id){
        $quotation_number = $this->quotationNumber();

        $file = $this->generateQuotation($request, $family_id, $quotation_number);

        $member_folder_id = MemberFolder::where('name', '=', 'Sales')->first()?->id;

        $quotation = new Quotation;
        $quotation->family_id = $family_id;
        $quotation->quotation_number = $quotation_number;
        $quotation->path = $file['path'];
        $quotation->member_folder_id = $member_folder_id;
        $quotation->is_first = true;
        $quotation->save();

        // Saving it in member documents
        $member = Family::find($family_id)->members()->where('dependent_code', '=', '00')->first();

        $member_document = new MemberDocument;
        $member_document->member_folder_id = $member_folder_id;
        $member_document->member_id = $member->member_id;
        $member_document->name = 'Member Quotation - ' . date('Y-m-d H:i:s');
        $member_document->path = $file['path'];
        $member_document->save();

        return $file['attach_file'];
    }

    public function generateQuotation($request, $family_id, $quotation_number){
        $scheme_options = $request->quotation_type == 'comparative' ? SchemeOption::where('tier_level', '=', 1)->get() : SchemeOption::where('id', '=', $request->scheme_option_id)->get();
        $members = Member::where('family_id', '=', $family_id)->get();
        $broker = Broker::find(auth('api')->user()->broker?->broker_id);
        $quotation_type = $request->quotation_type == 'comparative' ? 'Comparative' : 'Scheme Specific';
        $discount = 15;

        $subscription_period = SubscriptionPeriod::find($request->subscription_period_id);

        

        $cover_start_date = firstDateOfNextMonth();        
        $cover_end_date = addMonthsToDate($cover_start_date, $subscription_period->name);

        if($request->cover_start_date){
            $cover_start_date = $request->cover_start_date;
            $cover_end_date = addMonthsToDate($cover_start_date, $subscription_period->name);
        }

        $data = [
            'broker' => $broker,
            'members' => $members,
            'principle_member' => Member::where('family_id', '=', $family_id)->where('dependent_code', '=', '00')->first(),
            'scheme_options' => $scheme_options,
            'quotation_number' => $quotation_number,
            'quotation_type' => $quotation_type,
            'discount' => $discount,
            'subscription_period_id' => $request->subscription_period_id,
            'cover_start_date' => $cover_start_date,
            'cover_end_date' => $cover_end_date
        ];

        $pdf = PDF::loadView('documents.new-member-quotation', $data);

        $file_name = time() . 'ses_quotation.pdf';

        $file = 'public/member-quotations/' . $file_name;
        $path = '/storage/member-quotations/' . $file_name;

        // Saving to starage;
        Storage::put($file, $pdf->output());

        return collect([
            'path' => $path,
            'attach_file' => Storage::path($file)
        ]);
    }

    private function createSESBroker(){
        $bro = Broker::all()->last();
        $nextId = ($bro === null ? 0 : $bro->broker_id) + 1;
        $suffix = str_pad($nextId, 3, '0', STR_PAD_LEFT);
        $code = substr(strtoupper(auth('api')->user()?->first_name), 0, 4) . $suffix;

        $broker_house = BrokerHouse::where('code', '=', 'SESBH737')->first();

        $broker = new Broker;
        $broker->broker_house_id = $broker_house->broker_house_id;
        $broker->code = 'SES737' . $code;
        $broker->title = 'N/A';
        $broker->first_name = auth('api')->user()?->first_name;
        $broker->surname = auth('api')->user()?->last_name;
        $broker->id_number = 'N/A';
        $broker->address1 = 'Lusaka';
        $broker->address2 = 'Lusaka';
        $broker->city = 'Lusaka';
        $broker->office_number = '000';
        $broker->phone_number = auth('api')->user()?->phone_number;
        $broker->email = auth('api')->user()?->email;
        $broker->status = 'active';

        $broker->active_date = date('Y-m-d H:i:s');

        $broker->inactive_date = date('Y-m-d H:i:s');

        $broker->save();

        return $broker->broker_id;
    }

    private function sendNotificationToBrokerAndMember($request, $family, $registration_token){
        $member_details = Member::where('family_id', '=', $family->id)->where('dependent_code', '=', '00')->first();

        $subscription_period = SubscriptionPeriod::all();

        // Calling the function that generates the quotation pdf for the member details
        $file = $this->saveQuotation($request, $family->id);

        // Getting the origin url
        $origin_url = getOriginUrl();

        $member_details->notify(new MemberQuotation($member_details, $file, $registration_token, $origin_url, 'Member'));

        // Notifying the broker
        $broker = Broker::find($family->broker_id);

        if($broker){
            $broker->notify(new MemberQuotation($member_details, $file, $registration_token, $origin_url, 'Broker'));
        }
    }
}
