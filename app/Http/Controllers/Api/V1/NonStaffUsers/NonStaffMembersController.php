<?php

namespace App\Http\Controllers\Api\V1\NonStaffUsers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Api\V1\Membership\Family;

use App\Models\Api\V1\Sales\Broker;

use App\Models\Api\V1\Membership\Member;

use App\Models\Api\V1\Membership\Invoice;

use App\Models\Api\V1\Membership\MemberFolder;

use App\Models\Api\V1\Lookups\Year;

use App\Models\Api\V1\Sales\Quotation;

use App\Models\Api\V1\Lookups\SchemeSubscription;

use App\Models\Api\V1\Lookups\MedicalHistoryOption;

use App\Models\Api\V1\Membership\MedicalHistory;

use App\Models\Api\V1\Membership\MemberDocument;

use App\Models\Api\V1\UserAccess\Role;

use App\Http\Resources\Api\V1\Membership\MedicalHistoriesResource;

use App\Notifications\MemberInvoice;

use App\Models\User;

use App\Models\Api\V1\Lookups\Department;

use App\Notifications\AwaitingUnderwriting;

use App\Notifications\RegistrationComplete;

use App\Http\Resources\Api\V1\Membership\MembersResource;
use App\Http\Resources\Api\V1\Membership\FamiliesResource;

use App\Http\Requests\Api\V1\Membership\FamilyRequest;

use Illuminate\Support\Facades\Storage;

use Illuminate\Validation\Rule;

use PDF;

class NonStaffMembersController extends Controller
{
    /**
     * This method saves whether the member accepts or rejects the quotation.
     */

    public function acceptOrRejectQuotation(Request $request, $register_token){
        $this->validate($request, [
            'status' => 'required|string|in:accepted,rejected',
            'rejection_reason' => $request->status == 'rejected' ? 'required|string' : 'nullable' 
        ]);

        $family = Family::where('registration_token', '=', $register_token)->first();

        if(!$family){
            return response()->json(['error' => 'invalid token'], 498);
        }

        // Saving the stage at which registration is
        $family->registration_stage = 'personal details';
        $family->save();

        // Saving the action performed on the quotation
        $quotation = Quotation::where('family_id', '=', $family->id)->where('is_first', '=', 1)->first();
        $quotation->family_id = $family->id;
        $quotation->status = $request->status;

        if($request->status == 'rejected'){
            $quotation->rejection_reason = $request->rejection_reason;
        }

        $quotation->save();

        return response()->json(['msg' => 'saved successfully!', 'status' => 200], 200);
    }

    /**
     * Accepting or rejecting the invoice that was
     * generated after underwriting
     */
    public function acceptOrRejectInvoice(Request $request, $register_token){
        $this->validate($request, [
            'status' => 'required|string|in:accepted,rejected',
            'rejection_reason' => $request->status == 'rejected' ? 'required|string' : 'nullable' 
        ]);

        $family = Family::where('registration_token', '=', $register_token)->first();

        if(!$family){
            return response()->json(['error' => 'invalid token'], 498);
        }

        $family->is_invoice_accepted = $request->status === 'accepted' ? true : false;
        $family->invoice_rejection_reason = $request->invoice_rejection_reason;
        $family->save();

        return response()->json(['msg' => 'saved successfully!', 'status' => 200], 200);
    }

    public function showDetails($register_token){        
        $family = Family::with('members', 'familySchemeDetails', 'broker')->where('registration_token', '=', $register_token)->first();

        if(!$family){
            return response()->json(['error' => 'invalid token', 'status' => 498], 498);
        }

        return response()->json(new FamiliesResource($family));
    }

    public function tokenValidity($register_token){
        $family = Family::where('registration_token', '=', $register_token)->first();

        if(!$family){
            return response()->json(['error' => 'invalid token', 'status' => 498], 498);
        }

        return response()->json(['msg' => 'success', 'status' => 200], 200);
    }

    /**
     * Online completion of registration from method by member
     */
    public function completeRegistration(Request $request, $register_token){
        $this->validate($request, [
            'broker_id' => 'required|integer',
            // For princal
            'scheme_option_id' => 'required|integer',
            'scheme_type_id' => 'nullable|sometimes|integer',
            'title' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'nullable|sometimes|email',
            'dob' => 'required|date',
            'gender' => 'required|string|in:Male,Female',
            'nrc_or_passport_no' => 'required|string',
            'occupation' => 'required|string',
            'mobile_number' => 'required|string',
            // End of principal

            // Family Details
            'group_type_id' => 'required|integer',
            'subscription_period_id' => 'required|integer',
            'physical_address' => 'required|string',
            'status' => 'required|string',
            'has_funeral_cash_benefit' => 'required|boolean',
            // 'has_sports_loading' => 'required|boolean',
            // End of family details

            // Dependent Details
            'dependents' => 'array',
            'dependents.*.title' => 'nullable|sometimes|string',
            'dependents.*.first_name' => 'required|string',
            'dependents.*.last_name' => 'required|string',
            'dependents.*.dob' => 'required|date',
            'dependents.*.email' => 'nullable|sometimes|email',
            'dependents.*.gender' => 'required|string|in:Male,Female',
            'dependents.*.has_sports_loading' => 'required|boolean',
            'dependents.*.sports_loading_start_date' => 'nullable|sometimes|date',
            'dependents.*.sports_loading_end_date' => 'nullable|sometimes|date',
            'dependents.*.sporting_activity' => 'nullable|sometimes|string'
        ]);

        $family = Family::where('registration_token', '=', $register_token)->first();

        if(!$family){
            return response()->json(['error' => 'invalid token', 'status' => 498], 498);
        }

        $previous_state = $this->previousStepState('complete-registration', $family);

        if($previous_state == 'rejected'){
            return response()->json(['error' => 'family details cannot be updated since quotation was rejected.', 'status' => 403], 403);
        }

        // Adding the family and getting the family id from the helpers
        $family_id = $dependent_code = addUpdateFamily($request, 'update', $family->id);

        // Getting the id of the priciple member
        $member_id = Family::find($family_id)->members()->where('dependent_code', '=', '00')->first()->member_id;

        // Calling principal member store or update from helper
        addUpdatePrincipal($request, $family_id, $member_id, 'update');

        // Calling method from helper file
        $dependants = addUpdateDependents($request->dependents, $family_id, $request->scheme_option_id, $request->scheme_type_id, 'update');

        if($dependants == 'dependant not found'){
            return response()->json(['msg' => 'one or more of the dependant(s) with the provided id not found', 'status' => 401], 401);
        }

        $family->registration_stage = 'medical details';

        return response()->json(['msg' => 'updated successfully!', 'status' => 200], 200);
    }

    /**
     * Saving member medical history
     */
    public function familyMembersMedicalHistory(Request $request, $register_token){
        $this->validate($request, [
            'medical_histories' => 'required|array',
            'medical_histories.*.medical_history_option_id' => 'required|integer',
            'medical_histories.*.member_id' => 'required|integer',
            'medical_histories.*.doctors_name' => 'nullable|sometimes|string',
            'medical_histories.*.doctors_email' => 'nullable|sometimes|email',
            'medical_histories.*.doctors_phone_number' => 'nullable|sometimes|string',
            'medical_histories.*.action_taken' => 'required|string|in:yes,no',
        ]);

        $family = Family::where('registration_token', '=', $register_token)->first();

        if(!$family){
            return response()->json(['error' => 'invalid token', 'status' => 498], 498);
        }

        $family = Family::where('registration_token', '=', $register_token)->first();

        $previous_state = $this->previousStepState('medical-history', $family);

        if($previous_state == 'incomplete'){
            return response()->json(['error' => 'previous step (member details) is incomplete!', 'status' => 403], 403);
        }

        for($i = 0; $i < count($request->medical_histories); $i++){
            $medical_history = MedicalHistory::where('member_id', '=', $request->medical_histories[$i]['member_id'])->where('medical_history_option_id', '=', $request->medical_histories[$i]['medical_history_option_id'])->first();

            if(!$medical_history){
                $medical_history = new MedicalHistory;
            }
            
            $medical_history->member_id = $request->medical_histories[$i]['member_id'];
            $medical_history->medical_history_option_id = $request->medical_histories[$i]['medical_history_option_id'];
            $medical_history->action_taken = $request->medical_histories[$i]['action_taken'];
            
            if($request->medical_histories[$i]['action_taken'] == 'yes'){
                $medical_history->condition = isset($request->medical_histories[$i]['condition']) ? $request->medical_histories[$i]['condition'] : null;
                $medical_history->doctors_name = isset($request->medical_histories[$i]['doctors_name']) ? $request->medical_histories[$i]['doctors_name'] : null;
                $medical_history->action_taken = isset($request->medical_histories[$i]['action_taken']) ? $request->medical_histories[$i]['action_taken'] : null;
                $medical_history->doctors_email = isset($request->medical_histories[$i]['doctors_email']) ? $request->medical_histories[$i]['doctors_email'] : null;
                $medical_history->doctors_phone_number = isset($request->medical_histories[$i]['doctors_phone_number']) ? $request->medical_histories[$i]['doctors_phone_number'] : null;
            }
            $medical_history->save();
        }

        $family->status = 'pending';
        $family->save();

        return response()->json(['msg' => 'saved successfully!', 'status' => 200], 200);
    }

    /**
     * Viewing member medical history
     */

    public function memberMedicalHistory($register_token, $member_id){
        $family = Family::where('registration_token', '=', $register_token)->first();

        if(!$family){
            return response()->json(['error' => 'invalid token', 'status' => 498], 498);
        }

        $member = $family->members()->where('member_id', '=', $member_id)->first();

        return response()->json(MedicalHistoriesResource::collection($member?->medicalHistory));
    }

    /**
     * Saving the digital signature and adding it's path
     */
    public function storeDigitalSignature(Request $request, $register_token){
        $this->validate($request, [
            'signature' => 'required|image'
        ]);

        $family = Family::where('registration_token', '=', $register_token)->first();

        if(!$family){
            return response()->json(['error' => 'invalid token', 'status' => 498], 498);
        }

        $family = Family::where('registration_token', '=', $register_token)->first();
        $family->digital_signature = storeFile($request->signature, 'digital_signatures');
        $family->save();

        return response()->json(['msg' => 'saved successfully!', 'status' => 200, 'registration_token' => $register_token], 200);
    }

    /**
     * Saving the invoice details and calling the generate invoice method
     */
    private function saveInvoice($family_id, $invoice_data, $total_amount){
        $invoice_number = $this->invoiceNumber();

        $invoice_generate = $this->generateInvoice($invoice_data, $invoice_number, $family_id);

        $member_folder_id = MemberFolder::where('name', '=', 'Finance')->first()?->id;

        $invoice = new Invoice;
        $invoice->family_id = $family_id;
        $invoice->member_folder_id = $member_folder_id;
        $invoice->invoice_number = $invoice_number;
        $invoice->discount = 0;
        $invoice->amount = $total_amount;
        $invoice->path = $invoice_generate['path'];
        $invoice->save();

        // Saving it in member documents
        $member = Family::find($family_id)->members()->where('dependent_code', '=', '00')->first();

        $member_document = new MemberDocument;
        $member_document->member_folder_id = $member_folder_id;
        $member_document->member_id = $member->member_id;
        $member_document->name = 'Member Invoice';
        $member_document->path = $invoice_generate['path'];
        $member_document->save();

        return $invoice_generate['attach_file'];
    }

    /**
     * Generating the invoice after member accepts
     * underwriting.
     */
    private function generateInvoice($invoice_data, $invoice_number, $family_id){

        $member = Family::find($family_id)->members()->where('dependent_code', '=', '00')->first();

        $data = [
            'invoice_data' => $invoice_data,
            'invoice_number' => $invoice_number,
            'member' => $member,
            'total_amount' => $this->getInvoiceTotalAmount($invoice_data)
        ];

        $pdf = PDF::loadView('documents.new-member-invoice', $data);

        $file_name = time() . 'ses_invoice.pdf';

        $file = 'public/invoices/' . $file_name;

        $path = '/storage/invoices/' . $file_name;

        // Saving to starage;
        Storage::put($file, $pdf->output());

        return collect([
            'path' => $path,
            'attach_file' => Storage::path($file)
        ]);
    }

    private function invoiceNumber(){
        // Generating the Membership Number
        $last_id = Invoice::all()->last();
        $nextId = ($last_id === null ? 0 : $last_id->id) + 1;

        $suffix = str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $invoice_number = 'INV' . $suffix;

        return $invoice_number;
    }

    private function getInvoiceTotalAmount($invoice_data){
        $total = 0;

        foreach($invoice_data as $inv){
            $total = $total + $inv['amount'];
        }

        return $total;
    }

    public function acceptOrRejectUnderwriting(Request $request, $register_token){
        $this->validate($request, [
            'status' => 'required|string|in:accepted,rejected',
            'rejection_reason' => $request->status == 'rejected' ? 'required|string' : 'nullable' 
        ]);

        $family = Family::where('registration_token', '=', $register_token)->first();

        if(!$family){
            return response()->json(['error' => 'invalid token'], 498);
        }

        if($family->is_underwritten != true){
            return response()->json(['error' => 'you are not allowed to access this resource'], 403);
        }
        
        $family->underwriting_accepted = $request->status == 'accepted' ? true : false;
        $family->underwriting_rejection_reason = $request->rejection_reason;
        $family->save();

        if ($request->status == 'accepted'){
            $invoice_data = $family->members->map(function($member){
                $age_group = ageGroup(getAge($member->dob));
                $year = Year::where('year', '=', date('Y'))->first();
                $year_id = null;
    
                if ($year){
                    $year_id = $year->id;
                }
    
                $scheme_subscription = SchemeSubscription::where('year_id', '=', $year_id)
                                        ->where('scheme_option_id', '=', $member->schemeOption?->id)
                                        ->where('age_group_id', '=', $age_group->id)
                                        ->where('subscription_period_id', '=', (int)$member->family->subscription_period_id)
                                        ->first();
    
                return collect([
                    'member' => $member->first_name . ' ' . $member->last_name,
                    'age_group' => $age_group->min_age . ' - ' . $age_group->max_age,
                    'scheme' => $member->schemeOption?->name,
                    'period' => $scheme_subscription?->subscriptionPeriod->name,
                    'currency' => $scheme_subscription?->currency->code,
                    'amount' => $scheme_subscription?->amount
                ]);
            });
    
            $total_amount = $this->getInvoiceTotalAmount($invoice_data);
    
            $file = $this->saveInvoice($family->id, $invoice_data, $total_amount);
    
            $member = $family->members()->where('dependent_code', '=', '00')->first();

            // Getting the origin url
            $origin_url = getOriginUrl();
    
            $member->notify(new MemberInvoice($member, $file, $register_token, $origin_url, 'Member'));

            $department = Department::where('name', '=', 'Finance')->first();

            if($department){
                $user = User::where('department_id', '=', $department->id)->first();

                if($user){
                    $user->notify(new MemberInvoice($member, $file, $register_token, $origin_url, 'Finance'));
                }
            }

            // Notifying the broker
            $broker = Broker::find($family->broker_id);
            $broker->notify(new MemberInvoice($member, $file, $register_token, $origin_url, 'Broker'));
        }

        return response()->json(['msg' => 'saved successfully!', 'status' => 200], 200);
    }

    private function previousStepState($current_step, $family){
        switch($current_step){
            case 'complete-registration':
                $quotation = $family->quotations()->where('is_first', '=', true)->first();

                if($quotation->status == 'accepted'){
                    return 'accepted';
                }else if($quotation->status == 'rejected'){
                    return 'rejected';
                }
                break;
            case 'medical-history':
                if($family->physical_address && $family->subscription_period_id){
                    foreach($family->members as $member){
                        if(!$member->scheme_option_id || !$member->dob || !$member->weight || !$member->height){
                            return 'incomplete';
                        }
                    }
                }else{
                    return 'incomplete';
                }
                break;
            default: 
                return false;
        }
    }

    public function makeRegistrationAsComplete($register_token){
        $family = Family::where('registration_token', '=', $register_token)->first();

        if(!$family){
            return response()->json(['error' => 'invalid token', 'status' => 498], 498);
        }

        $family = Family::where('registration_token', '=', $register_token)->first();

        // Updating the family status
        $family->status = 'pending underwriting';
        $family->save();

        $role = Role::where('name', '=', 'Underwriter')->first();

        $users = $role->users;

        $membership_form =  $this->generatingMembershipForm($family);

        $member_form_file = $membership_form['attach_file'];

        if(count($users) > 0){
            foreach($users as $user){
                $user->notify(new AwaitingUnderwriting($user, $family->family_code, $member_form_file));
            }
        }

        $member = $family->members()->where('dependent_code', '=', '00')->first();

        $member->notify(new RegistrationComplete($member, $member_form_file));

        // Saving the generated membership form
        $member_folder_id = MemberFolder::where('name', '=', 'Membership')->first()?->id;

        $member_document = new MemberDocument;
        $member_document->member_id = $member->member_id;
        $member_document->member_folder_id = $member_folder_id;
        $member_document->name = 'Membership Form - ' . date('Y-m-d H:i:s');
        $member_document->path = $membership_form['path'];
        $member_document->save();

        return response()->json(['msg' => 'success', 'status' => 200], 200);
    }

    // Generating member application form in pdf format
    public function generatingMembershipForm($family){
        $medical_history_options = MedicalHistoryOption::all();
        $principal = Member::where('family_id', '=', $family->id)->where('dependent_code', '=', '00')->first();
        $family_members = Member::with(['medicalHistory'])->where('family_id', '=', $family->id)->get();
    
        $data = [
            'family' => $family,
            'principal' => $principal,
            'family_members' => $family_members,
            'medical_history_options' => $medical_history_options,
            'is_new_application' => false
        ];
        $pdf = PDF::loadView('documents.membership-form', $data);
    
        $file_name = $family->family_code . 'membership_form.pdf';
    
        $file = 'public/membership_form/' . $file_name;
    
        $path = '/storage/membership_form/' . $file_name;
    
        // Saving to starage;
        Storage::put($file, $pdf->output());

        // Saving to starage;
        Storage::put($file, $pdf->output());
    
        return collect([
            'path' => $path,
            'attach_file' => Storage::path($file)
        ]);
    }

    public function memberMedicalHistoryOptions($registration_token, $member_id){
        $medical_history_options = MedicalHistoryOption::all();

        $family = Family::where('registration_token', '=', $registration_token)->first();

        if(!$family){
            return response()->json(['error' => 'invalid token', 'status' => 498], 498);
        }

        if(!Member::find($member_id)){
            return response()->json(['error' => 'member not found', 'status' => 401], 401);
        }

        $all_medical_options = $medical_history_options->map(function($option) use ($member_id) {
            $medical_history = MedicalHistory::where('member_id', '=', $member_id)->where('medical_history_option_id', '=', $option->medical_history_option_id)->first();

            return collect([
                'medical_history_option_id' => $option->medical_history_option_id,
                'attributes' => collect([
                    'description' => $option->description,
                    'condition' => $medical_history?->condition,
                    'action_taken' => $medical_history?->action_taken,
                    'doctors_name' => $medical_history?->doctors_name,
                    'doctors_email' => $medical_history?->doctors_email,
                    'doctors_phone_number' => $medical_history?->doctors_phone_number,
                    'notes' => $medical_history?->notes
                ])
            ]);
        });

        return $all_medical_options;
    }
}
