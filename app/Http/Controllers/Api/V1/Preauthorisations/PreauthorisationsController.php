<?php

namespace App\Http\Controllers\Api\V1\Preauthorisations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Api\V1\Preauthorisations\Preauthorisation;
use App\Models\Api\V1\Preauthorisations\CaseNumber;
use App\Models\Api\V1\Preauthorisations\PreauthorisationService;
use App\Models\Api\V1\HealthProcessings\ServiceProviderPriceList;
use App\Http\Resources\Api\V1\Preauthorisations\PreauthorisationsResource;
use App\Http\Resources\Api\V1\Preauthorisations\CaseNumbersResource;
use App\Models\Api\V1\Lookups\AuthType;

use App\Models\Api\V1\Lookups\ClaimCode;

use App\Models\Api\V1\HealthProcessings\ServiceProvider;

use App\Models\Api\V1\Membership\Member;

use App\Models\Api\V1\Membership\MemberBenefit;

use Illuminate\Support\Facades\Storage;

use App\Models\Api\V1\Lookups\SchemeBenefitAmount;

use App\Models\Api\V1\Lookups\Year;

use App\Jobs\SendGOPJob;

use PDF;

class PreauthorisationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(isset($_GET['search']) && $_GET['search'] != '' && !isset($_GET['from']) && !isset($_GET['to'])){
            $search = $_GET['search'];

            // Plucking the case numbers if they correspond
            $case_number_ids = CaseNumber::where('case_number', '=', $search)->pluck('id');

            // Getting results based on the case number
            if(count($case_number_ids) > 0){
                $preauths = Preauthorisation::whereIn('case_number_id', $case_number_ids)->orderBy('created_at', 'DESC')->get();
                return response()->json(PreauthorisationsResource::collection($preauths));
            }

            $member = Member::where('member_number', '=', $search)->first();

            if($member){
                $preauths = Preauthorisation::where('member_id', '=', $member->member_id)->orderBy('created_at', 'DESC')->get();
                return response()->json(PreauthorisationsResource::collection($preauths));
            }

            // Getting results based on other search values ie auth code.
            $preauths = Preauthorisation::where('auth_code', '=', $search)->orderBy('created_at', 'DESC')->get();

            return response()->json(PreauthorisationsResource::collection($preauths));
        }else{
            if(isset($_GET['search']) && isset($_GET['from']) && isset($_GET['to'])){
                $search = $_GET['search'];
                $from = $_GET['from'];
                $to = $_GET['to'];

                if ($this->validDate($from) == false && $this->validDate($to) == false){
                    return response()->json(['error' => 'invalid from date'], 422);
                }else{
                    if($this->validDate($from) == false){
                        $from = '1970-01-01';
                    }
                }

                if ($this->validDate($to) == false && $this->validDate($from) == false){
                    return response()->json(['error' => 'invalid to date'], 422);
                }else{
                    if($this->validDate($to) == false && $from <= date('Y-m-d')){
                        $to = date('Y-m-d');
                    }
                }

                $preauths = Preauthorisation::where('created_at', '>=', $from);
                $preauths->where('created_at', '<=', $to);

                if($_GET['search'] != ''){
                    // Plucking the case numbers if they correspond
                    $case_number_ids = CaseNumber::where('case_number', '=', $search)->pluck('id');

                    // Getting results based on the case number
                    if(count($case_number_ids) > 0){
                        $preauths->whereIn('case_number_id', $case_number_ids);
                    }

                    $member = Member::where('member_number', '=', $search)->first();
                    if($member){
                        $preauths->where('member_id', '=', $member->member_id);
                    }

                    if(count($preauths->get()) == 0){
                        // Getting results based on other search values ie auth code.
                        $preauths->where('auth_code', '=', $search);
                    }
                }

                $preauthorisations = $preauths->limit(25)->orderBy('created_at', 'DESC')->get();
                return response()->json(PreauthorisationsResource::collection($preauthorisations));
            }
        }

        $preauths = Preauthorisation::limit(25)->orderBy('created_at', 'DESC')->get();

        return response()->json(PreauthorisationsResource::collection($preauths));
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
            'member_id' => 'required|integer',
            'service_provider_id' => 'required|integer',
            'auth_type_id' => 'required|integer',
            'services' => 'nullable|sometimes|string',
            'appointment_date' => 'nullable|sometimes|date|after_or_equal:today',
            'admission_date' => 'nullable|sometimes|date',
            'estimated_discharge_date' => 'nullable|sometimes|date',
            'complaint' => 'nullable|sometimes|string',
            'diagnosis' => 'nullable|sometimes|string',
            'case_number' => 'nullable|sometimes|string',
            'notes' => 'nullable|sometimes|string',
            'total_amount' => 'nullable|sometimes|numeric',
            'quotation_url' => AuthType::find($request->auth_type_id)->description == 'Elective Admission' ? 'required|mimes:pdf' : 'nullable|sometimes|mimes:pdf',
            'is_international' => 'required|boolean',
            'services' => (AuthType::find($request->auth_type_id)->description == 'Elective Admission' ||  AuthType::find($request->auth_type_id)->description == 'Emergency Admission') ? 'nullable|sometimes|array' : 'required|array',
            'case_number' => AuthType::find($request->auth_type_id)->description == 'Elective Admission' ? 'required|string' : 'nullable|sometimes|string',
            'services.*.id' => 'required|integer',
            'services.*.description' => 'required|string'
        ]);

        $member = Member::find($request->member_id);

        if($member->family->status != 'active'){
            return response()->json(['error' => 'Preauth cannot continue. The member is not active!'], 422);
        }

        if($this->schemeCanAccessThisFacility($request->service_provider_id, $request->member_id) === false){
            return response()->json(['error' => 'This member\'s scheme cannot access this facility!', 'status' => 401], 401);
        }

        $case_number_id = null;
        if($request->case_number == 'create_new' || strpos($request->case_number, 'CSE') == true){
            $case_number_id = $this->upsertCaseNumber($request->case_number, $request->member_id, $request->service_provider_id);
        }

        $preauthorisation = new Preauthorisation;
        $preauthorisation->auth_code = $this->authCode();
        $preauthorisation->member_id = $request->member_id;
        $preauthorisation->case_number_id = $case_number_id;
        $preauthorisation->service_provider_id = $request->service_provider_id;
        $preauthorisation->auth_type_id = $request->auth_type_id;
        $preauthorisation->appointment_date = $request->appointment_date;
        $preauthorisation->admission_date = $request->admission_date;
        $preauthorisation->estimated_discharge_date = $request->estimated_discharge_date;
        $preauthorisation->complaint = $request->complaint;
        $preauthorisation->diagnosis = $request->diagnosis;
        $preauthorisation->notes = $request->notes;
        $preauthorisation->total_amount = $request->total_amount;
        $preauthorisation->amount_in_dollar = $this->providerCurrencyInDollar($request->service_provider_id, $request->total_amount);
        $preauthorisation->quotation_url = $request->quotation_url;
        if($request->hasFile('quotation')){
            $preauthorisation->quotation_url = storeFile($request->quotation, 'Quotations');
        }
        $preauthorisation->save();

        $services = collect($request->services);

        $total_amount = $request->total_amount;

        if(AuthType::find($request->auth_type_id)->description != 'Elective Admission' &&  AuthType::find($request->auth_type_id)->description != 'Emergency Admission' && $services && count($services) > 0){
            $totals = $this->addRequestedServices($member, $preauthorisation->id, $services, $request->service_provider_id);

            if(!$totals){
                $preauthorisation->delete();
                return response()->json(['error' => 'An error occured while trying to preauthorise. Please try again!'], 500);
            }

            $preauthorisation->total_amount = $totals['total_amount'];
            $preauthorisation->ses_pay_amount = $totals['total_ses_pay'];
            $preauthorisation->member_pay_amount = $totals['total_member_pay'];
            $preauthorisation->amount_in_dollar = $this->providerCurrencyInDollar($request->service_provider_id, $totals['total_amount']);
            $preauthorisation->save();
        }else{
            // For elective or admission cases
            $auth_type = explode(" ", AuthType::find($request->auth_type_id)?->description)[0];
            $claimCode = ClaimCode::where('description', 'LIKE', '%' . $auth_type . '%')->first();
            $amount_in_dollar = $this->providerCurrencyInDollar($request->service_provider_id, $request->total_amount);
            $this->addAmountToBenefitPreauthorisations($member, $claimCode, $amount_in_dollar);
        }
        

        // Sending the Guarantee of payment
        if($request->send_gop == 1 || $request->send_gop == true){
            $gop_path = $this->generateGOP($preauthorisation, $preauthorisation->member, $request->is_international, $services, $total_amount);

            dispatch(new SendGOPJob($preauthorisation->serviceProvider->email, $gop_path));

            // Making the gop sent to be true
            $preauthorisation->gop_sent = true;
            $preauthorisation->save();
        }

        return response()->json(['msg' => 'saved successfully!', 'status' => 200], 200);
    }

    /** 
     * Displaying the payment details for the authorisation
     * It will show a collection of the maximum about that 
     * SES will pay for the service
    */

    public function paymentDetails(Request $request){
        $this->validate($request, [
            'member_id' => 'required|integer',
            'service_provider_id' => 'required|integer',
            'services' => 'required|array',
            'services.*.id' => 'required|integer',
            'services.*.description' => 'required|string'
        ]);

        $member = Member::find($request->member_id);

        if(count($member->memberBenefits) == 0){
            return response()->json(['error' => 'member has no benefits to compare'], 403);
        }

        $service_provider_id = $request->service_provider_id;

        $services = collect($request->services);

        $data = $this->serviceAndPricesCollection($services, $member, $request->service_provider_id);

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $preauthorisation = Preauthorisation::with('member', 'serviceProvider', 'services')->find($id);

        if($preauthorisation){
            return response()->json(new PreauthorisationsResource($preauthorisation));
        }else{
            return response()->json(['error' => 'preauthorisation with that id not found'], 404);
        }
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
        //
    }

    private function authCode(){
        // Generating the member number
        $auth_code = Preauthorisation::all()->last();
        $nextId = ($auth_code === null ? 0 : $auth_code->id) + 1;

        $suffix = str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $auth_code = 'AU' . $suffix;

        return $auth_code;
    }

    private function generateGOP($authorisation, $member, $is_international, $services, $total_amount){

        if($total_amount && (!$services || count($services) === 0 || $is_international === 1)){
            $is_international = true;
        }

        $data = [
            'scheme' => $member->schemeOption,
            'member' => $member,
            'preauthorisation' => $authorisation,
            'service_provider' => $authorisation->serviceProvider,
            'services' => $this->serviceAndPricesCollection($services, $member, $authorisation->serviceProvider->service_provider_id),
            'total_amount' => $total_amount,
            'currency' => $authorisation->serviceProvider->receiveCurrency->code,
            'date' => date('Y-m-d'),
            'is_international' => $is_international
        ];

        $pdf = PDF::loadView('documents.guarantee-of-payment', $data);

        $file = 'public/gop/' . time() . 'letter_of_guarantee.pdf';
    
        // Saving to starage;
        Storage::put($file, $pdf->output());

        return Storage::path($file);
    }

    private function checkBenefitLimit($member, $services){
        $year_id = Year::where('year', '=', date('Y'))->first()->id;
        $scheme_option_id = $member->schemeOption->id;
        $limit_amount = SchemeBenefitAmount::where('year_id', '=', $year_id)->where('scheme_option_id', '=', $scheme_option_id)->where('benefit_option_id', '=', $benefit_option_id)->first()->limit_amount;
        return $limit_amount;
    }

    private function schemeCanAccessThisFacility($service_provider_id, $member_id){
        $member = Member::find($member_id);
        $service_provider = ServiceProvider::find($service_provider_id);
        
        $scheme_option = $member->schemeOption;

        if($scheme_option && $service_provider->tier_level === $scheme_option->tier_level){
            return true;
        }else{
            return false;
        }
    }

    private function addRequestedServices($member, $preauthorisation_id, $services, $service_provider_id){
        $total_member_pay = 0;
        $total_ses_pay = 0;
        $total_amount = 0;

        if(count($services) > 0){
            foreach($services as $service){

                $service = (object)$service;

                $product_or_service = ServiceProviderPriceList::find($service->id);

                $amount = $product_or_service->price;
                $amount_in_dollar = $this->providerCurrencyInDollar($service_provider_id, $amount);
                $benefit_limit_amount = $this->limitBenefitLimitInProviderCurrency($member, $product_or_service->id);
                $ses_pay_amount = $amount > $benefit_limit_amount ? $benefit_limit_amount : $amount;
                $member_pay_amount = $amount > $benefit_limit_amount ? $amount - $benefit_limit_amount : 0;

                $this->addAmountToBenefitPreauthorisations($member, $product_or_service->tariff->claimCode, $amount_in_dollar);

                /*
                    'ses_pay' => $amount > $benefit_limit ? $benefit_limit : $amount,
                    'member_pay' => $amount > $benefit_limit ? $amount - $benefit_limit : 0,
                */
                $preauth_service = new PreauthorisationService;
                $preauth_service->preauthorisation_id = $preauthorisation_id;
                $preauth_service->service_price_id = $service->id;
                $preauth_service->amount = $amount;
                $preauth_service->amount_in_dollar = $amount_in_dollar;
                $preauth_service->benefit_limit_amount = $benefit_limit_amount;
                $preauth_service->ses_pay_amount = $ses_pay_amount;
                $preauth_service->member_pay_amount = $member_pay_amount;
                $preauth_service->save();

                $total_member_pay = $total_member_pay + $member_pay_amount;
                $total_ses_pay = $total_ses_pay + $ses_pay_amount;
                $total_amount = $total_amount + $amount;
            }
        }

        return collect([
            "total_member_pay" => $total_member_pay,
            "total_ses_pay" => $total_ses_pay,
            "total_amount" => $total_amount
        ]);
    }

    private function limitBenefitLimitInProviderCurrency($member, $service_provider_price_id){

        $price_list = ServiceProviderPriceList::find($service_provider_price_id);

        if($price_list->serviceProvider->is_ses_network_provider !== 1){
            return $price_list->tariff->ses_rate;
        }

        $year_id = Year::where('year', '=', date('Y'))->first()?->id;

        $scheme_option_id = $member->schemeOption->id;

        $benefit_option_id = $price_list->tariff->claimCode->benefit->id;

        $currency_code = $price_list->serviceProvider->receiveCurrency->code;

        $exchange_rate = exchangeRate("USD", $currency_code);

        $limit_amount = SchemeBenefitAmount::where('year_id', '=', $year_id)->where('scheme_option_id', '=', $scheme_option_id)->where('benefit_option_id', '=', $benefit_option_id)->first()->limit_amount;

        $rate = $exchange_rate['to'][0]['mid'];
        
        $benefit_limit = $limit_amount * $rate;

        return round($benefit_limit, 2);
    }

    private function providerCurrency($product_or_service_id){
        $service_provider = ServiceProvider::find($product_or_service_id);
        $currency_code = $service_provider->receiveCurrency->code;

        return $currency_code;
    }

    /**
     * Method for creating the collection for services and 
     * their prices together with benefit limits.
     */
    private function serviceAndPricesCollection($data, $member, $service_provider_id){  
                
        if($data && count($data) > 0){
            
            return $data->map(function($item) use($member, $service_provider_id) {
                $item = (object)$item;

                $price_list = ServiceProviderPriceList::find($item->id);

                $amount = $price_list->price;

                $benefit_limit = $this->limitBenefitLimitInProviderCurrency($member, $item->id);

                return collect([
                    'id' => $item->id,
                    'attributes' => collect([
                        'description' => $item->description,
                        'currency' => $this->providerCurrency($service_provider_id),
                        'amount' => $amount,
                        'benefit_limit' => $benefit_limit,
                        'ses_pay' => $amount > $benefit_limit ? $benefit_limit : $amount,
                        'member_pay' => $amount > $benefit_limit ? $amount - $benefit_limit : 0,
                        'comment' => $amount > $benefit_limit ? 'Limit Exceeded!' : 'Within Limit.'
                    ])
                ]);
            });
        }
    }

    private function providerCurrencyInDollar($service_provider_id, $amount){
        $currency_code = $this->providerCurrency($service_provider_id);

        $exchange_rate = exchangeRate($currency_code, "USD");

        $rate = $exchange_rate['to'][0]['mid'];

        $converted_amount = (double)$amount * (double)$rate;

        return $converted_amount;
    }

    public function addAmountToBenefitPreauthorisations($member, $claim_code, $amount){
        $member_benefit = MemberBenefit::where('member_id', '=', $member->member_id)->where('benefit_option_id', '=', $claim_code->benefit_option_id)->where('year_id', '=', currentYearId())->first();
        $member_benefit->remaining_amount = $member_benefit->remaining_amount - $amount;
        $member_benefit->limit_used = $member_benefit->limit_used + $amount;
        $member_benefit->authorised_amount = $member_benefit->authorised_amount + $amount;
        $member_benefit->save();
    }

    private function upsertCaseNumber($case_number, $member_id, $service_provider_id){
        if($case_number){
            $case_no = CaseNumber::where('case_number', '=', $case_number)->where('service_provider_id', '=', $service_provider_id)->first();

            if($case_no){
                return $case_no->id;
            }else{
                // Generating the next case number
                $generated_case_no = CaseNumber::all()->last();
                $nextId = ($generated_case_no === null ? 0 : $generated_case_no->id) + 1;
                $suffix = str_pad($nextId, 5, '0', STR_PAD_LEFT);
                $generated_case_no = 'CSE' . $suffix;

                // Adding the new case number to the database
                $case_no = new CaseNumber;
                $case_no->service_provider_id = $service_provider_id;
                $case_no->member_id = $member_id;
                $case_no->case_number = $generated_case_no;
                $case_no->save();

                return $case_no->id;
            }
        }
    }

    public function limitedMemberPreauthorisations($member_id){
        // getting a few member preauthorisations
        $preauths = Preauthorisation::where('member_id', '=', $member_id)->limit(5)->get();

        return response()->json(PreauthorisationsResource::collection($preauths));
    }

    public function memberCaseNumbersWithProvider(){
        $member_id = null;
        $service_provider_id = null;

        if(isset($_GET['member_id']) && $_GET['member_id'] != ''){
            $member_id = $_GET['member_id'];
        }else{
            return response()->json(['error' => 'please provide the member_id'], 422);
        }

        if(isset($_GET['service_provider_id']) && $_GET['service_provider_id'] != ''){
            $service_provider_id = $_GET['service_provider_id'];
        }else{
            return response()->json(['error' => 'please provide the service_provider_id'], 422);
        }

        $case_numbers = CaseNumber::where('service_provider_id', '=', $service_provider_id)->where('member_id', '=', $member_id)->get();

        return response()->json(CaseNumbersResource::collection($case_numbers));
    }

    private function validDate($date){
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)){
            return true;
        }else{
            return false;
        }
    }

    public function getPreauthByAuthNumber($auth_number){
        $preauthorisation = Preauthorisation::with('member', 'serviceProvider', 'services')->where('auth_code', '=', $auth_number)->first();

        if($preauthorisation){
            return response()->json(new PreauthorisationsResource($preauthorisation));
        }else{
            return response()->json(['error' => 'Auth code not found!'], 404);
        }
    }

    public function closePreauth(Request $request, $id){
        $this->validate($request, [
            'status' => 'required|string|in:closed'
        ]);
        $preauthorisation = Preauthorisation::find($id);

        if($preauthorisation){
            $preauthorisation->status = $request->status;
            $preauthorisation->save();
            
            return response()->json(['msg' => 'closed successfully!'], 200);
        }else{
            return response()->json(['error' => 'preauthorisation not found'], 404);
        }
    }
}
