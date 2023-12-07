<?php

namespace App\Http\Controllers\Api\V1\Financials;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Api\V1\Financials\PremiumPayment;
use App\Http\Resources\Api\V1\Financials\PremiumPaymentsResource;

use App\Models\Api\V1\Membership\Member;
use App\Models\Api\V1\Membership\MemberDocument;
use App\Models\Api\V1\Membership\Family;
use App\Models\Api\V1\Lookups\SchemeSubscription;
use App\Models\Api\V1\Lookups\SubscriptionPeriod;
use App\Models\Api\V1\Lookups\Year;

use App\Notifications\PremiumPaymentReceipt;

use Illuminate\Support\Facades\Storage;

use App\Imports\PremiumImport;
use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;

use PDF;

class PremiumPaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pays = PremiumPayment::where('id', '>', 0);

        $search = null;

        if(isset($_GET['search']) && $_GET['search'] != ''){

            $search_value = $_GET['search'];

            $family = Family::where('family_code', '=', $search_value)->first();
            $member = Member::where('member_number', '=', $search_value)->first();

            if($family){
                $search = $family->id;
            }

            if($member){
                $search = $member->family->id;
            }

            if(!$search){
                $search = $search_value;
            }

            $pays->where('family_id', '=', $search)->orWhere('receipt_number', '=', $search);
        }

        $payments = $pays->orderBy('created_at', 'DESC')->paginate(25);

        return response()->json(PremiumPaymentsResource::collection($payments));
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
            'family_id' => 'required|integer',
            'currency' => 'required|string',
            'tax' => 'nullable|sometimes|numeric',
            'amount' => 'required|numeric'
        ]);


        $next_renewal_date =  $this->nextRenewalDate($this->benefitStartDate(), Family::find($request->family_id)->subscription_period_id);

        $family = Family::find($request->family_id);

        $member = $family->members()->where('dependent_code', '=', '00')->first();

        // Checking if the member exists
        if(!$member){
            return response()->json(['error' => 'member not found', 'status' => 404], 404);
        }

        // Getting the total amount the member has to pay based on the number of dependents and schemes
        $total_amount = $this->totalPremium($family, $family->subscription_period_id);

        // Checking if scheme premium was added
        if($total_amount === 0){
            return response()->json(['error' => 'scheme price does not exist in the system.', 'status' => 422], 422);
        }

        // Checking if the amount paid is enough
        if($total_amount > $request->amount){
            return response()->json(['error' => 'insufficient amount additional $' . (double)$total_amount -  (double)$request->amount . ' is needed.', 'status' => 422], 422);
        }

        $receipt_number =  $this->receiptNumber();

        // Saving the payment if the amount is enough
        $payment = new PremiumPayment;
        $payment->family_id = $family->id;
        $payment->processed_by = auth()->user()->user_id;
        $payment->receipt_number = $receipt_number;
        $payment->currency = $request->currency;
        $payment->tax = $request->tax;
        $payment->amount = $request->amount;
        $payment->save();

        if(count($family->payments) == 1){
            $update_family = Family::find($family->id);
            $update_family->benefit_start_date = $family->benefit_start_date ?? $this->benefitStartDate(); //Calling the method with the logic for the benefit start date
            // $update_family->in_holding_tank = false;
            $update_family->next_renewal_date = $next_renewal_date;
            $update_family->status = 'suspended';
            $update_family->benefit_end_date = null;
            $update_family->save();
        }

        $receipt = $this->generateReceipt($receipt_number, $family->id, $request->amount);
        $payment->receipt_path = $receipt['path'];
        $payment->save();


        $membership_schedule_path = $this->generateMembershipSchedule($member);

        // Send to principle member
        $member->notify(new PremiumPaymentReceipt($member, $receipt['attach_file'], $request->amount, $membership_schedule_path));

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
        $payment = PremiumPayment::find($id);

        return response()->json(new PremiumPaymentsResource($payment));
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
            'member_id' => 'required|integer',
            'currency' => 'required|string',
            'tax' => 'nullable|sometimes|numeric',
            'amount' => 'required|numeric'
        ]);

        $payment = new PremiumPayment;
        $payment->member_id = $request->member_id;
        $payment->updated_by = auth()->user()->user_id;
        $payment->currency = $request->currency;
        $payment->tax = $request->tax;
        $payment->amount = $request->amount;
        $payment->save();

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
        PremiumPayment::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!', 'status' => 200], 200); 
    }

    /**
     * Method for the total premium price
     * for the entired family whose payment is to be made.
     */

    private function totalPremium($family, $subscription_period_id){
        $total_amount = 0;
        
        $year = Year::where('year', '=', date('Y'))->first();

        $members = $family->members;

        foreach($members as $member){
            $birthdate = Carbon::createFromFormat('Y-m-d', $member->dob);
            $currentDate = Carbon::createFromFormat('Y-m-d', $family->benefit_start_date ?? date('Y-m-d'));

            $age = $birthdate->diffInYears($currentDate);

            $age_group_id = ageGroup($age)?->id;

            $subscription = SchemeSubscription::where('scheme_option_id', '=', $member->scheme_option_id)
                    ->where('subscription_period_id', '=', $subscription_period_id)
                    ->where('age_group_id', '=', $age_group_id)
                    ->where('year_id', '=', $year?->id)->first();
            
            $total_amount = $total_amount + $subscription?->amount;
        }

        return $total_amount;
    }

    private function benefitStartDate(){
        if (date('d') == 1){
            return date('Y-m-d');
        }else{
            return Carbon::now()->startOfMonth()->format('Y-m-d');
        }
    }

    private function receiptNumber(){
        // Generating the member number
        $receipt_number = PremiumPayment::all()->last();
        $nextId = ($receipt_number === null ? 0 : $receipt_number->id) + 1;

        $suffix = str_pad($nextId, 5, '0', STR_PAD_LEFT);

        $receipt_number = 'RN' . $suffix;

        return $receipt_number;
    }

    private function receiptData($family){
        return $invoice_data = $family->members->map(function($member){
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
                'period' => $scheme_subscription->subscriptionPeriod->name,
                'currency' => $scheme_subscription->currency->code,
                'amount' => $scheme_subscription->amount
            ]);
        });
    }

    private function generateReceipt($receipt_number, $family_id, $total_premium){
        $member = Family::find($family_id)->members()->where('dependent_code', '=', '00')->first();

        $data = [
            'receipt_data' => $this->receiptData(Family::find($family_id)),
            'receipt_number' => $receipt_number,
            'member' => $member,
            'total_amount' => $total_premium
        ];

        $pdf = PDF::loadView('documents.premium-payment-receipt', $data);

        $file_name = time() . 'ses_receipt.pdf';

        $file = 'public/members-receipts/' . $file_name;

        $path = '/storage/members-receipts/' . $file_name;

        // Saving to starage;
        Storage::put($file, $pdf->output());

        // Saving the membership schedule in member documents
        $member_document = new MemberDocument;
        $member_document->member_id = $member->member_id;
        $member_document->name = 'PremiumReceipts';
        $member_document->path = $path;
        $member_document->save();

        return collect([
            'path' => $path,
            'attach_file' => Storage::path($file)
        ]);
    }

    public function premiumPaymentImports(Request $request){
        $this->validate($request, [
            'excel' => 'required|mimes:csv,xslx,xslv,xlsx' 
        ]);

        Excel::import(new PremiumImport, $request->file('excel'));

        return response()->json(['msg' => 'imported successfully!', 'status' => 200], 200);
    }

    public function generateMembershipSchedule($member){
        $data = [
            'member' => $member
        ];

        $pdf = PDF::loadView('documents.membership-schedule', $data);

        $file = 'MembershipSchedule' . $member->member_number . time() .'.pdf';

        $filePath = 'public/membership-schedule/' . $file;
        $path = '/storage/membership-schedule/' . $file;
    
        // Saving to starage;
        Storage::put($filePath, $pdf->output());
    
        // return $pdf->stream('gop.pdf');

        // Saving the membership schedule in member documents
        $member_document = new MemberDocument;
        $member_document->member_id = $member->member_id;
        $member_document->name = 'Membership Schedule';
        $member_document->path = $path;
        $member_document->save();

        return Storage::path($filePath);
    }

    public function searchFamily($search){
        $family_ids = Member::where('member_number', 'LIKE', '%' . $search . '%')->pluck('family_id');
        $families = Family::whereIn('id', $family_ids)->orWhere('family_code', 'LIKE', '%' . $search . '%')->get();

        $data = $families->map(function($family){

            $pricipal_member = $family->members()->where('dependent_code', '=', '00')->first();

            return collect([
                'family_id' => $family->id,
                'principal_member_number' => $pricipal_member->member_number,
                'member_name' => $pricipal_member->first_name . ' ' . $pricipal_member->last_name,
                'family_code' => $family->family_code
            ]);
        });

        return $data;
    }

    // Next renewal date
    private function nextRenewalDate($date, $subscription_period_id){
        $start_date  = Carbon::create($date);

        $subscription_period = SubscriptionPeriod::find($subscription_period_id);

        if($subscription_period->name === 'Quarterly'){
            $new_date = $start_date->addMonths(3)->format('Y-m-d');
            $new_date = Carbon::create($new_date);
            return $new_date->subDays(1)->format('Y-m-d');
        }

        if($subscription_period->name === 'Bi-Annually'){
            $new_date = $start_date->addMonths(6)->format('Y-m-d');
            $new_date = Carbon::create($new_date);
            return $new_date->subDays(1)->format('Y-m-d');
        }

        if($subscription_period->name === 'Annually'){
            $new_date = $start_date->addMonths(12)->format('Y-m-d');
            $new_date = Carbon::create($new_date);
            return $new_date->subDays(1)->format('Y-m-d');
        }
    }
}
