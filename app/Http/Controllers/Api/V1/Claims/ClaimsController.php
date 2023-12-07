<?php

namespace App\Http\Controllers\Api\V1\Claims;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Api\V1\Claims\Claim;
use App\Models\Api\V1\Claims\ClaimLineItem;

use App\Http\Resources\Api\V1\Claims\ClaimsResource;

use App\Models\Api\V1\Preauthorisations\Preauthorisation;

use App\Models\Api\V1\Membership\Member;

use App\Models\Api\V1\Membership\MemberBenefit;

use App\Models\Api\V1\HealthProcessings\ServiceProvider;

use App\Models\Api\V1\Lookups\SchemeBenefitAmount;

use App\Models\Api\V1\Lookups\Year;

use App\Models\Api\V1\HealthProcessings\ServiceProviderPriceList;

use App\Models\Api\V1\Preauthorisations\PreauthorisationService;

use App\Models\Api\V1\Lookups\ClaimCode;

use Carbon\Carbon;

use App\Notifications\ClaimsAssessed;

class ClaimsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $claims = Claim::orderBy('created_at', 'DESC')->get();

        return response()->json(ClaimsResource::collection($claims));
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
            'claims_logs_id' => 'required|integer',
            'member_number' => 'required|string',
            'service_provider_id' => 'required|sometimes|integer',
            'auth_type_id' => 'nullable|sometimes|integer',
            'auth_code' => 'required|string',
            'invoice_number' => 'required|string|unique:claims',
            'status' => 'required|string|in:assessed,hold',
            'line_items' => 'required|array',
            'line_items.*.preauthorisation_service_id' => 'nullable|sometimes|integer',
            'line_items.*.tariff_code' => 'required|string',
            'line_items.*.claim_code' => 'required|string',
            'line_items.*.diagnosis' => 'required|string',
            'line_items.*.icd10' => 'required|string',
            'line_items.*.amount' => 'required|numeric',
            'line_items.*.date_of_service' => 'required|date',
        ]);

        $has_preauth = true;

        $preauthorisation = Preauthorisation::where('auth_code', '=', $request->auth_code)->first();
        $member = Member::where('member_number', '=', $request->member_number)->first();

        if(!$member){
            return response()->json(['error' => 'Member with the provided member number does not exist!'], 422);
        }

        if(!$preauthorisation){
            $has_preauth = false;
        }

        $claim = new Claim;
        $claim->preauthorisation_id = $preauthorisation->id;
        $claim->service_provider_id = $request->service_provider_id;
        $claim->auth_type_id = $request->auth_type_id;
        $claim->claim_number = $this->generateClaimNumber();
        $claim->claims_logs_id = $request->claims_logs_id;
        $claim->member_id = $member->member_id;
        $claim->auth_number = $request->auth_code;
        $claim->invoice_number = $request->invoice_number;
        $claim->status = $request->status;
        $claim->save();

        $currency = $claim->claimsLog?->serviceProvider?->receiveCurrency?->code;
        
        if($this->saveOrUpdateClaimLineItems($request->line_items, $claim, $currency) != 'saved'){
            $claim->delete();
            return response()->json(['error' => 'failed to save', 'status' => 500], 500);
        }

        $this->assessedMemberNotify($claim, $request->status);

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
        $claim = Claim::with(['claimLineItems'])->find($id);

        if(!$claim){
            return response()->json(['error' => 'The provided id not found'], 404);
        }

        return response()->json(new ClaimsResource($claim));
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
            'claims_logs_id' => 'required|integer',
            'service_provider_id' => 'nullable|sometimes|integer',
            'auth_type_id' => 'nullable|sometimes|integer',
            'member_id' => 'required|integer',
            'auth_code' => 'required|string',
            'invoice_number' => 'required|string',
            'status' => 'required|string|in:assessed,hold',
            'line_items' => 'required|array',
            'line_items.*.line_item_id' => 'nullable|sometimes|integer',
            'line_items.*.tariff_code' => 'required|string',
            'line_items.*.claim_code' => 'required|string',
            'line_items.*.diagnosis' => 'required|string',
            'line_items.*.icd10' => 'required|string',
            'line_items.*.amount' => 'required|numeric',
            'line_items.*.date_of_service' => 'required|date',
        ]);

        $claim = Claim::find($id);

        $claim->preauthorisation_id = $preauthorisation_id;
        $claim->claims_logs_id = $request->claims_logs_id;
        $claim->service_provider_id = $request->service_provider_id;
        $claim->auth_type_id = $request->auth_type_id;
        $claim->member_id = $request->member_id;
        $claim->auth_number = $request->auth_code;
        $claim->invoice_number = $request->invoice_number;
        $claim->status = $request->status;
        $claim->save();

        $currency = $claim->claimsLog?->serviceProvider?->receiveCurrency?->code;

        if($this->saveOrUpdateClaimLineItems($request->line_items, $claim, $currency) != 'saved'){
            $claim->delete();
            return response()->json(['msg' => 'failed to save', 'status' => 500], 500);
        }

        $this->assessedMemberNotify($claim, $request->status);

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
        Claim::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!', 'status' => 200], 200);
    }

    /**
     * The method below generates the claim number
     */
    private function generateClaimNumber(){
        $claim = Claim::orderBy('created_at', 'DESC')->get()->first();
        $nextId = ($claim === null ? 0 : $claim->id) + 1;

        $suffix = str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $claim_number = 'CL' . $suffix;

        return $claim_number;
    }

    /**
     * Saving the line items that have been passed
     */
    private function saveOrUpdateClaimLineItems($line_items, $claim, $currency){
        
        foreach($line_items as $item){
            $claim_line_item = new ClaimLineItem;
            if(isset($item['line_item_id']) && $item['line_item_id']){
                $claim_line_item = ClaimLineItem::find($item['line_item_id']);
            }

            $amount_in_dollar = $this->providerCurrencyInDollar($claim->preauthorisation?->service_provider_id, $item['amount']);


            $claim_line_item->claim_id = $claim->id;
            $claim_line_item->tariff_code = $item['tariff_code'];
            $claim_line_item->claim_code = $item['claim_code'];
            $claim_line_item->diagnosis = $item['diagnosis'];
            $claim_line_item->icd10 = $item['icd10'];
            $claim_line_item->amount_in_dollar = $amount_in_dollar;
            $claim_line_item->amount = $item['amount'];
            $claim_line_item->date_of_service = $item['date_of_service'];
            $claim_line_item->currency = $currency;
            $claim_line_item->save();

            $member = Member::find($claim?->preauthorisation->member_id);

            $this->addAmountClaimToMemberBenefitsTable($member, $item['claim_code'], $amount_in_dollar, $claim_line_item->id, $item['amount'], $claim->preauthorisation?->service_provider_id);

        }
        
        return 'saved';
    }

    private function providerCurrencyInDollar($service_provider_id, $amount){
        $currency_code = $this->providerCurrency($service_provider_id);

        $exchange_rate = exchangeRate($currency_code, "USD");

        $rate = $exchange_rate['to'][0]['mid'];

        $converted_amount = (double)$amount * (double)$rate;

        return (double)$converted_amount;
    }

    private function dollarInProviderCurrency($service_provider_id, $amount){
        $currency_code = $this->providerCurrency($service_provider_id);

        $exchange_rate = exchangeRate("USD", $currency_code);

        $rate = $exchange_rate['to'][0]['mid'];

        $converted_amount = (double)$amount * (double)$rate;

        return (double)$converted_amount;
    }

    private function providerCurrency($service_provider_id){
        $service_provider = ServiceProvider::find($service_provider_id);
        $currency_code = $service_provider->receiveCurrency->code;

        return $currency_code;
    }

    public function addAmountClaimToMemberBenefitsTable($member, $claim_code, $amount, $line_item_id, $provider_currency_amount, $service_provider_id){
        $claim_code = ClaimCode::where('code', '=', $claim_code)->first();

        $member_benefit = MemberBenefit::where('member_id', '=', $member->member_id)->where('benefit_option_id', '=', $claim_code->benefit_option_id)->where('year_id', '=', currentYearId())->first();


        $member_benefit->claimed_amount = $member_benefit->claimed_amount + $amount;

        $assessed_amount = 0;
        $rejected_amount = 0;
        $comment = '';


        if(($member_benefit->limit_used + $amount) <= $member_benefit->limit_amount){
            $member_benefit->limit_used = $member_benefit->limit_used + $amount;
            $member->remaining_amount = $member_benefit->limit_amount - ($member_benefit->limit_used + $amount);

            // Adding value for the assessed amount
            $assessed_amount = $provider_currency_amount;
            $rejected_amount = 0;
            $comment = 'Assessed without rejection!';
        }else{
            $member_pay = 0;
            if($member_benefit->limit_amount - $member_benefit->claimed_amount < 0){
                $member_pay = $member_benefit->paid_by_member_amount + $amount;
            }

            $member_benefit->limit_used = $member_benefit->limit_amount;
            $member_benefit->remaining_amount = 0;
            $member_benefit->paid_by_member_amount = $member_pay;

            // Calculating the remaining benefits and converting them to provider currency
            $remaining_benefit = $member_benefit->limit_amount - $member_benefit->limit_used;
            $remaining_benefit_in_provider_currency = (double)$this->dollarInProviderCurrency($service_provider_id, $remaining_benefit);
            
            // Assigning rejected amount and assessed amount
            $rejected_amount = (double)$provider_currency_amount - $remaining_benefit_in_provider_currency;
            $assessed_amount = $remaining_benefit_in_provider_currency;

            if($member_pay > 0){
                $comment = $rejected_amount . ' has been rejected due to being more that the available limit of ' . $assessed_amount . '.';
            }else{
                $comment = 'Assessed without rejection!';
            }
        }
        $member_benefit->save();


        // Adding the amount assessed and rejected to the claim line items table
        $claim_line_item = ClaimLineItem::find($line_item_id);
        $claim_line_item->assessed_amount = $assessed_amount;
        $claim_line_item->rejected_amount = $rejected_amount;
        $claim_line_item->comment = $comment;
        $claim_line_item->save();

    }

    private function assessedMemberNotify($claim, $status){
        if($status == 'assessed'){
            $age = getAge($claim->member?->dob);

            $member = $claim->member;

            if($age < 18 && $member->dependent_code != '00'){
                $member = Member::where('family_id', '=', $member->family_id)->where($dependent_code, '=', '00')->first();
            }

            $member->notify(new ClaimsAssessed($member, $claim));
        }
    }
}
