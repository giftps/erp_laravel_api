<?php
    use App\Models\Api\V1\UserAccess\Permission;
    use App\Models\Api\V1\UserAccess\Module;
    use App\Models\Api\V1\Lookups\AgeGroup;
    use App\Models\Api\V1\ExchangeRate;

    use App\Models\Api\V1\Membership\Family;
    use App\Models\Api\V1\Membership\Member;
    use App\Models\Api\V1\Membership\MemberActivity;
    use App\Models\Api\V1\Membership\MedicalHistory;
    use App\Models\Api\V1\Lookups\Year;
    use App\Models\Api\V1\Lookups\BenefitOption;
    use App\Models\Api\V1\Lookups\SchemeBenefitAmount;
    use App\Models\Api\V1\Lookups\MedicalHistoryOption;
    use Illuminate\Support\Facades\Storage;
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Redis;
    use App\Models\Api\V1\Lookups\SchemeSubscription;
    use PhpOffice\PhpSpreadsheet\IOFactory;

    use Maatwebsite\Excel\Facades\Excel;
    use App\Models\Api\V1\HealthProcessings\Tariff;
    use App\Http\Resources\Api\V1\HealthProcessings\TariffsResource;
    use App\Imports\TariffsImport;
    use Illuminate\Support\Facades\Cache;
    use App\Models\ImportProgress;
    use Illuminate\Http\UploadedFile;
    use App\Http\Resources\ImportProgressResource;

    use App\Models\Api\V1\Membership\MemberBenefit;
    use App\Models\Api\V1\Lookups\SubscriptionPeriod;

    function isPermissionGranted($module, $action){
        $role_id = auth()->user()->role->role_id;
        $module_id = Module::where('name', '=', $module)->first()->module_id;
        

        // return $module_id;
        $permission = Permission::where('role_id', '=', $role_id)->where('module_id', '=', $module_id)->first();

        if(auth()->user()->role->name === 'Super Admin'){
            return true;
        }

        switch($action){
            case 'can_add':
                return $permission ? $permission->can_add : null;
            case 'can_edit':
                return $permission ? $permission->can_edit : null;
            case 'can_delete':
                return $permission ? $permission->can_add : null;
            default:
                return false;
        }
    }

    function sendAText($phone_number, $message){
        $basic  = new \Nexmo\Client\Credentials\Basic('588b28f9', 'Nqc1I4l7HIMzHjLX');
        $client = new \Nexmo\Client($basic);
    
        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS($phone_number, 'SES', $message)
        );
            
        $message = $response->current();
            
        if ($message->getStatus() == 0) {
            return response()->json(['msg' => 'sent', 'status' => 200], 200);
        } else {
            return "The message failed with status: " . $message->getStatus() . "\n";
        }
    }

    // Saving files
    function storeFile($passed_file, $type){
        $image = $passed_file->getClientOriginalName();
        $fileName   = pathinfo($image, PATHINFO_FILENAME);
        $extension = $passed_file->getClientOriginalExtension();
        $fileToStore = $fileName . '_' . time() . '.' . $extension;
        $path = $type . '/' . date("Y") . '/' . date('M');

        $passed_file->storeAs('public/' . $path, $fileToStore);
        return 'storage/' . $path . '/' . $fileToStore;
    }

    function getAge($dob){
        $age = date_diff(date_create($dob), date_create(date('Y-m-d')));
        $member_age = $age->format('%y');

        return $member_age;
    }

    function ageGroup($age){
        $age_groups = AgeGroup::all();

        foreach($age_groups as $age_group){
            if($age >= $age_group->min_age && $age <= $age_group->max_age){
                return $age_group;
            }else if($age >= $age_group->min_age && !$age_group->max_age){
                return $age_group;
            }
        }
    }

    function exchangeRate($from, $to){
        $exchange_rate = ExchangeRate::where('from', '=', $from)->where('to', '=', $to)->where('date', '=', date('Y-m-d'))->first();

        if(!$exchange_rate){
            $url = "https://xecdapi.xe.com/v1/convert_from.json/?from=$from&to=$to&amount=1";

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $headers = array(
            "Authorization: Basic c3BlY2lhbHR5ZW1lcmdlbmN5c2VydmljZXN0L2FzZXMtdW5pc3VyZTg5NTA2MTg5OnBjZmU2NDlxOXVhczl1MDgzazVucW90dXFq",
            );

            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            //for debug only!
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $resp = json_decode(curl_exec($curl));
            curl_close($curl);

            // Converting an array into a collection
            $to_currency = collect($resp->to);

            // Saving the rate in the database 
            $exch_rat = new ExchangeRate;
            $exch_rat->from = $resp->from;
            $exch_rat->to = $to;
            $exch_rat->rate = $to_currency[0]->mid;
            $exch_rat->date = date('Y-m-d'); 
            $exch_rat->save();

            // Changing the shape of the response
            return collect([
                'from' => $resp->from,
                'amount' => $resp->amount,
                'to' => $to_currency->map(function($item){
                    return collect([
                        'quotecurrency' => $item->quotecurrency,
                        'mid' => round($item->mid, 2)
                    ]);
                })
            ]);
        }else{
            return collect([
                'from' => $exchange_rate->from,
                'amount' => 1,
                'to' => [
                    [
                        'quotecurrency' => $exchange_rate->to, 
                        'mid' => round($exchange_rate->rate, 2)
                    ]
                ]
            ]);
        }
    }

    function historicExchangeRate($from, $to, $start_timestamp, $end_timestamp){
        // Timestamp format: 2011-02-11T12:00
        $url = "https://xecdapi.xe.com/v1/historic_rate/period/?from=$from&to=$to&start_timestamp=$start_timestamp&end_timestamp=$end_timestamp";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
        "Authorization: Basic c3BlY2lhbHR5ZW1lcmdlbmN5c2VydmljZXN0L2FzZXMtdW5pc3VyZTg5NTA2MTg5OnBjZmU2NDlxOXVhczl1MDgzazVucW90dXFq",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = json_decode(curl_exec($curl));
        curl_close($curl);
        
        // Converting an array into a collection
        $to = collect($resp->to);

        // Changing the shape of the response
        return collect([
            'from' => $resp->from,
            'amount' => $resp->amount,
            'to' => $to
        ]);
    }

    /**
     * All the benefit limits for the member
     */
    function benefitLimits($id){
        $member = Member::find($id);
        $scheme_option_id = $member->scheme_option_id;
        $scheme = $member->schemeOption->name;
        $join_date = $member->join_date;

        // Joining the benefit options with the scheme benefit amounts to that benefit limits of a member
        // Scheme can be returned
        $data = BenefitOption::leftJoin('scheme_benefit_amounts', function($join) use ($scheme_option_id){
            $join->on('scheme_benefit_amounts.benefit_option_id', '=', 'benefit_options.id');
            $join->where('scheme_option_id', '=',$scheme_option_id);
        })
        ->orderBy('created_at', 'DESC')
        ->get(['benefit_options.id', 'benefit_options.description', 'scheme_benefit_amounts.currency_id', 'scheme_benefit_amounts.limit_amount', 'benefit_options.created_at']);

        $date = new Carbon($join_date);

        $from_year = $date->format('Y');

        $years = Year::where('year', '>=', $from_year)->get();

        /**
         * This executes if the year hasnt been passed
         * in the query string.
         */
        $data = $years->map(function($year) use($scheme, $scheme_option_id){
            
            $scheme_benefit_amounts = SchemeBenefitAmount::where('scheme_option_id', '=', $scheme_option_id)->where('year_id', '=', $year->id)->get();

            return collect([
                "year_id" => $year->id,
                "year" => $year->year,
                "benefits" => $scheme_benefit_amounts->map(function($item) use ($scheme, $year){
                    return collect([
                        "benefit_option_id" => $item->benefit_option_id,
                        "description" => $item->benefit->description,
                        "currency" => $item->currency->code,
                        "limit_amount" => $item->limit_amount ?? 0,
                        "claimed" => 0,
                        "limit_used" => 0,
                        "authorised" => 0,
                        "remaining" => 0,
                        "paid_by_member" => 0,
                        "year" => $year->year,
                        "limit_message" => 0,
                        "scheme" => $scheme,
                        "effective_date" => $year->year . '-01-01',
                    ]);
                })
            ]);
        });

        /**
         * This is executed if the year has been 
         * passed in the query string
         */

        if(isset($_GET['year']) && $_GET['year'] != ''){
            $selected_year = $_GET['year'];

            $year = Year::where('year', '=', $selected_year)->first();

            if($year){

                $scheme_benefit_amounts = SchemeBenefitAmount::where('scheme_option_id', '=', $scheme_option_id)->where('year_id', '=', $year->id)->get();

                $data = collect([
                    "year_id" => Year::where('year', '=', $selected_year)->first()->id,
                    "year" => $selected_year,
                    "benefits" => $scheme_benefit_amounts->map(function($item) use ($scheme, $selected_year){
                        return collect([
                            "benefit_option_id" => $item->benefit_option_id,
                            "description" => $item->benefit->description,
                            "currency" => $item->currency->code,
                            "limit_amount" => $item->limit_amount ?? 0,
                            "claimed" => 0,
                            "limit_used" => 0,
                            "authorised" => 0,
                            "remaining" => 0,
                            "paid_by_member" => 0,
                            "year" => $selected_year,
                            "limit_message" => 0,
                            "scheme" => $scheme,
                            "effective_date" => $selected_year . '-01-01',
                        ]);
                    })
                ]);
            }else{
                return [];
            }
        }

        return $data;
    }

    /*
        Generating the member number for each member
        that is being added
    */
    function memberNumber(){
        // Generating the member number
        $member_number = Member::all()->last();
        $nextId = ($member_number === null ? 0 : $member_number->member_id) + 1;

        $suffix = str_pad($nextId, 5, '0', STR_PAD_LEFT);

        $member_number = '10' . $suffix;

        return $member_number;
    }

    /*
        Generating the family code 
        for the family that is being added to the
        System
    */
    function familyCode($last_name, $method, $id){
        // Generating the family Code
        $last_family_number = null;
        $nextId = null;

        if ($method === 'store'){
            $last_family_number = Family::all()->last();
            $nextId = ($last_family_number === null ? 0 : $last_family_number->id) + 1;
        }else if($method === 'update'){
            $last_family_number = Family::find($id);
            $nextId = $last_family_number->id;
        }

        $suffix = str_pad($nextId, 3, '0', STR_PAD_LEFT);

        $code_prefix = ucfirst(substr($last_name,0,3));

        $family_code = $code_prefix . $suffix;

        return $family_code;
    }

    /**
     * Updating the family of members
     */
    function addUpdateFamily($request, $method, $family_id){
        $family = null;
        $family_code = null;

        if ($method === 'store'){
            $family = new Family;
            $family_code = familyCode($request->last_name, 'store', null); // The family code method is at the top
        }else if($method === 'update'){
            $family = Family::find($family_id);
            $family_code = familyCode($request->last_name, 'update', $family_id); // The family code method is at the top
        }
        
        $family->group_id = $request->group_id;
        $family->broker_id = $request->broker_id;
        $family->group_type_id = $request->group_type_id;
        $family->subscription_period_id = $request->subscription_period_id;
        $family->family_code = $family_code;
        $family->has_funeral_cash_benefit = 1;
        $family->nationality = $request->nationality;
        $family->physical_address = $request->physical_address;
        $family->postal_address = $request->postal_address;
        $family->postal_code = $request->postal_code;
        $family->nearest_city = $request->nearest_city;
        $family->province = $request->province;
        $family->beneficiary_name = $request->beneficiary_name;
        $family->beneficiary_mobile_number = $request->beneficiary_mobile_number;
        $family->beneficiary2_name = $request->beneficiary2_name;
        $family->beneficiary2_mobile_number = $request->beneficiary2_mobile_number;
        $family->status = $method === 'store' ? 'pending' : $request->status;
        $family->in_holding_tank = $request->status != 'active' && true;
        $family->application_date = date("Y-m-d");

        // Logic for suspension start date
        $family->suspension_date = $request->suspension_date;

        // Logic for suspension lift date
        $family->suspension_lifted_date = $request->suspension_lifted_date;

        // Logic for next renewal date
        $family->next_renewal_date = $request->next_renewal_date;

        $family->save();

        return $family->id;
    }

    /**
     * Adding the principle member of the family 
     */
     function addUpdatePrincipal($request, $family_id, $id, $method){
        $member = null;

        if($method === 'store'){
            $member = new Member;
        }else if($method === 'update'){
            $member = Member::find($id);
        }
        
        $member->family_id = $family_id;
        $member->scheme_option_id = $request->scheme_option_id;
        $member->scheme_type_id = $request->scheme_type_id;
        $member->dependent_code = "00";
        $member->member_number = memberNumber(); //The membership number method being called is at the top
        $member->title = $request->title;
        $member->first_name = $request->first_name;
        $member->last_name = $request->last_name;
        $member->other_names = $request->other_names;
        $member->dob = $request->dob;
        $member->gender = $request->gender;
        $member->marital_status = $request->marital_status;
        $member->language = $request->language;
        $member->nrc_or_passport_no = $request->nrc_or_passport_no;
        $member->occupation = $request->occupation;
        $member->relationship = $request->relationship;
        $member->email = $request->email;
        $member->work_number = $request->work_number;
        $member->mobile_number = $request->mobile_number;
        $member->join_date = date("Y-m-d");
        $member->is_principal = true;
        $member->weight = $request->weight;
        $member->height = $request->height;

        $member->has_sports_loading = $request->has_sports_loading;
        $member->sports_loading_start_date = $request->sports_loading_start_date;
        $member->sports_loading_end_date = $request->sports_loading_end_date;
        $member->sporting_activity = $request->sporting_activity;

        $member->save();

        return 'saved';
    }

    /*
        Updating dependents on condition that
        the data received has got member id.
    */
    function addUpdateDependents($dependents, $family_id, $scheme_option_id, $scheme_type_id, $method){
        
        if($method === 'store' || $method === 'update' && $dependents){
            for($i = 0; $i < count($dependents); $i++){

                $dep_code = $i + 1;
                
                $member = null;
                // Checking if the member id exists
                if(isset($dependents[$i]['member_id'])){
                    $member_id = $dependents[$i]['member_id'];

                    $member = Member::find($member_id);

                    if(!$member){
                        return 'dependant not found';
                    }
                }else{
                    $member = new Member;
                }

                // Saving the data
                $member->family_id = $family_id;
                $member->scheme_option_id = isset($dependents[$i]['scheme_option_id']) ? $dependents[$i]['scheme_option_id'] : $scheme_option_id;
                $member->scheme_type_id = isset($dependents[$i]['scheme_type_id']) ? $dependents[$i]['scheme_type_id'] : $scheme_type_id;
                $member->dependent_code = "0$dep_code";
                $member->member_number = memberNumber(); //The membership number method being called is at the top
                $member->title = isset($dependents[$i]['title']) ? $dependents[$i]['title'] : null;
                $member->first_name = isset($dependents[$i]['first_name']) ? $dependents[$i]['first_name'] : null;
                $member->last_name = isset($dependents[$i]['last_name']) ? $dependents[$i]['last_name'] : null;
                $member->dob = isset($dependents[$i]['dob']) ? $dependents[$i]['dob'] : null;
                $member->gender = isset($dependents[$i]['gender']) ? $dependents[$i]['gender'] : null;
                $member->marital_status = isset($dependents[$i]['marital_status']) ? $dependents[$i]['marital_status'] : null;
                $member->language = isset($dependents[$i]['language']) ? $dependents[$i]['language'] : null;
                $member->language = isset($dependents[$i]['id_type']) ? $dependents[$i]['id_type'] : null;
                $member->relationship = isset($dependents[$i]['relationship']) ? $dependents[$i]['relationship'] : null;
                $member->nrc_or_passport_no = isset($dependents[$i]['nrc_or_passport_no']) ? $dependents[$i]['nrc_or_passport_no'] : null;
                $member->occupation = isset($dependents[$i]['occupation']) ? $dependents[$i]['occupation'] : null;
                $member->email = isset($dependents[$i]['email']) ? $dependents[$i]['email'] : null;
                $member->work_number = isset($dependents[$i]['work_number']) ? $dependents[$i]['work_number'] : null;
                $member->mobile_number = isset($dependents[$i]['mobile_number']) ? $dependents[$i]['mobile_number'] : null;
                $member->weight = isset($dependents[$i]['weight']) ? $dependents[$i]['weight'] : null;
                $member->height = isset($dependents[$i]['height']) ? $dependents[$i]['height'] : null;
                $member->join_date = date("Y-m-d");

                $member->has_sports_loading = isset($dependents[$i]['has_sports_loading']) ? $dependents[$i]['has_sports_loading'] : null;
                // sporting logic of dates and activity on condition that the family has sports loading
                $member->sports_loading_start_date = isset($dependents[$i]['sports_loading_start_date']) ? $dependents[$i]['sports_loading_start_date'] : null;
                $member->sports_loading_end_date = isset($dependents[$i]['sports_loading_end_date']) ? $dependents[$i]['sports_loading_end_date'] : null;
                $member->sporting_activity = isset($dependents[$i]['sporting_activity']) ? $dependents[$i]['sporting_activity'] : null;

                $member->is_principal = false;
                $member->save();
            }
        }

        return 'saved';
    }

    function currentYearId(){
        $year = Year::where('year', '=', date('Y'))->first();

        if($year){
            return $year_id = $year->id;
        }

        return null;
    }

    function getYearId($year_value){
        $year = Year::where('year', '=', $year_value)->first();

        if($year){
            return $year_id = $year->id;
        }

        return null;
    }

    // Getting the source url of a post or put request
    function getOriginUrl(){
        if(isset($_SERVER['HTTP_ORIGIN'])){
            return $_SERVER['HTTP_ORIGIN'];
        }
    }

    // Checking the medical conditions
    function hasMedicalConditionOptions($family, $medical_history_option_id, $dependent_code){

        $member = Member::where('family_id', '=', $family->id)->where('dependent_code', '=', $dependent_code)->first();

        if($member){
            $medical_history = MedicalHistory::where('member_id', '=', $member->member_id)->where('medical_history_option_id', '=', $medical_history_option_id)->first();

            return [
                'has_condition' => $medical_history ? 1 : 0,
                'is_spouse' => ($member->relationship == 'Spouse' || $member->relationship == 'spouse') ? 1 : 0
            ];
        }else{
            return [
                'has_condition' => 'none',
                'is_spouse' => 'none'
            ];
        }
    }

    // Redis custom global methods
    function redisKeyExists($key){
        return Redis::exists($key);
    }

    function redisGetDisplayValues($key){
        $values = Redis::get($key);

        if($values){
            return json_decode($values);
        }else{
            return [];
        }
    }

    function setData($key, $value){
        Redis::set($key, json_encode($value));
    }

    function memberActivity($member_id, $description){
        $member_activity = new MemberActivity;
        $member_activity->member_id = $member_id;
        $member_activity->description = $description;
        if($member_activity->save()){
            return 'saved';
        }

        return 'failed';
    }

    // Getting the scheme prices
    function getSchemePrice($year_id, $subscription_period_id, $scheme_option_id, $age_group_id){
        $scheme_subscription = SchemeSubscription::where('year_id', '=', $year_id)
                            ->where('subscription_period_id', '=', $subscription_period_id)
                            ->where('scheme_option_id', '=',  $scheme_option_id)
                            ->where('age_group_id', '=', $age_group_id);

        if($scheme_subscription){
            return $scheme_subscription->first();
        }else{
            return null;
        }
    }

    // Getting the total number of records in an excel file
    function countImportRecords($file){
        // Load the Excel or CSV file
        $reader = IOFactory::createReaderForFile($file->path());
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file->path());

        // Get the number of rows in the first sheet
        $worksheet = $spreadsheet->getActiveSheet();
        $total_rows = $worksheet->getHighestRow();

        // Subtract one to exclude the header row
        $total_rows--;

        return (int)$total_rows;
    }

    // Saving import progress information of excel file
    function saveProgress($file, $name) {
        if($name){
            $total_rows = countImportRecords($file); //Getting total rows from a helper function in the helper.php file

            // Saving the total number of rows in a table
            $progress = ImportProgress::where('name', '=', $name)->first();
            if(!$progress){
                $progress = new ImportProgress;
            }
            $progress->name = $name;
            $progress->total_records = $total_rows;
            $progress->processed_records = 0;
            $progress->percentage_complete = 0;
            $progress->save();
        }else{
            return response()->json(['error' => 'no name provided'], 400);
        }
    }

    // Progress of the import 
    function importProgress($name){
        if($name){
            $progress = ImportProgress::where('name', '=', $name)->first();

            if($progress){
                return response()->json(new ImportProgressResource($progress));
            }
        }else{
            return response()->json(['error' => 'no name provided'], 400);
        }
    }


    /**
     * Beginning of adding member benefits
     */
    function addMemberBenefits($member_id){
        $benefit_options = BenefitOption::all();

        $member = Member::find($member_id);

        if (!$member->join_date){
            $member->join_date = date('Y-m-d');
            $member->save();
        }

        if(count($member->memberBenefits()->where('year_id', '=', currentYearId())->get()) == 0){
            foreach($benefit_options as $benefit){
                $member_benefit = new MemberBenefit;
                $member_benefit->member_id = $member_id;
                $member_benefit->benefit_option_id = $benefit->id;
                $member_benefit->year_id = currentYearId();
                $member_benefit->currency = 'USD';
                $member_benefit->limit_amount = benefitLimit($benefit->id, $member);
                $member_benefit->claimed_amount = 0;
                $member_benefit->limit_used = 0;
                $member_benefit->authorised_amount = 0;
                $member_benefit->remaining_amount = benefitLimit($benefit->id, $member);
                $member_benefit->paid_by_member_amount = 0;
                $member_benefit->status = 'active';
                $member_benefit->effective_date = date('Y-m-d');
                $member_benefit->end_date = benefitEndDate($member->family->subscription_period_id);
                $member_benefit->save();
            }
        }
    }

    function benefitLimit($benefit_option_id, $member){
        $annual_limit = SchemeBenefitAmount::where('year_id', '=', currentYearId())->where('scheme_option_id', '=', $member->scheme_option_id)->where('benefit_option_id', '=', $benefit_option_id)->first();

        $subscription_period_id = $member->family->subscription_period_id;

        $subscription_period = SubscriptionPeriod::find($subscription_period_id);

        $limit_per_month = benefitLimitPerMonth($annual_limit?->limit_amount, $subscription_period_id);

        if($subscription_period->name == 'Quarterly'){
            return $limit_per_month * 3;
        }

        if($subscription_period->name == 'Bi-Annually'){
            return $limit_per_month * 6;
        }

        if($subscription_period->name == 'Annually'){
            return $limit_per_month * 12;
        }
    }

    function benefitLimitPerMonth($annual_limit, $subscription_period_id){
        if($annual_limit){
            return (double)$annual_limit/12;
        }

        return null;
    }

    function benefitEndDate($subscription_period_id){
        $subscription_period = SubscriptionPeriod::find($subscription_period_id);

        if($subscription_period->name == 'Quarterly'){
            return Carbon::now()->addMonth(2)->format('Y-m-d');
        }

        if($subscription_period->name == 'Bi-Annually'){
            return Carbon::now()->addMonth(5)->format('Y-m-d');
        }

        if($subscription_period->name == 'Annually'){
            return Carbon::now()->addMonth(11)->format('Y-m-d');
        }
    }
    /**
     * End of adding member benefits
     */

     function addMonthsToDate($start_date, $period){
        // Create a Carbon instance from a formatted date
        $originalDate = Carbon::createFromFormat('Y-m-d', $start_date);

        if($period == 'Quarterly'){
            return $originalDate->addMonths(3)->subDay()->format('Y-m-d');
        }

        if($period == 'Bi-Annually'){
            return $originalDate->addMonths(6)->subDay()->format('Y-m-d');
        }

        if($period == 'Annually'){
            return $originalDate->addMonths(12)->subDay()->format('Y-m-d');
        }

        // Output the new date
        return $formattedDate;
    }

    function firstDateOfNextMonth(){
        // Todays date
        $originalDate = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
        return $originalDate->addMonths(1)->firstOfMonth()->format('Y-m-d');
    }
?>