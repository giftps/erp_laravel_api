<?php

namespace App\Http\Controllers\Api\V1\Administrations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\V1\Lookups\Year;
use App\Models\Api\V1\Lookups\SubscriptionPeriod;
use App\Models\Api\V1\Lookups\AgeGroup;
use App\Models\Api\V1\Lookups\SchemeSubscription;
use App\Models\Api\V1\Lookups\SchemeBenefitAmount;

use App\Imports\SchemeSubscriptionsImport;
use App\Imports\SchemeBenefitPricesImport;

use Maatwebsite\Excel\Facades\Excel;

class SchemeAndBenefitPricesController extends Controller
{
    /**
     * Creating a collection for the scheme prices in
     * of a particular year with the scheme periods
     */
    public function schemePrices($year, $scheme_id){
        $year_id = null;

        $year = Year::where('year', '=', $year)->first();

        if($year){
            $year_id = $year->id;
        }

        $subscription_periods = SubscriptionPeriod::all();
        $age_groups = AgeGroup::all();

        $scheme_price_details = $subscription_periods->map(function($period) use ($age_groups, $year_id, $scheme_id){
            return collect([
                "subscription_period_id" => $period->id,
                "subscription_name" => $period->name,
                "subscriptions" => $age_groups->map(function($age_group) use ($period, $year_id, $scheme_id){
                    $schemePrice = $this->getSchemePrice($year_id, $period->id, $scheme_id, $age_group->id);

                    return collect([
                        "scheme_subscriptions_id" => $schemePrice ? $schemePrice->id : $schemePrice,
                        "age_group_id" => $age_group->id,
                        'age_group' => $age_group->min_age . ' - ' . $age_group->max_age,
                        "currency_id" => $schemePrice ? $schemePrice->currency->id : $schemePrice,
                        "amount" => $schemePrice ? $schemePrice->amount : $schemePrice
                    ]);
                })
            ]);
        });

        return $scheme_price_details;
    }

    /**
     * Adding or updating scheme prices 
     * for a particular period
     */
    public function AddUpdateSchemePrice(Request $request){
        $this->validate($request, [
            'year' => 'required|integer',
            'subscription_period_id' => 'required|integer',
            'scheme_option_id' => 'required|integer',
            'age_group_id' => 'required|integer',
            'currency_id' => 'required|integer',
            'amount' => 'required|numeric'
        ]);

        $year = Year::where('year', '=', $request->year)->first();

        $year_id = null;

        if($year){
            $year_id = $year->id;
        }else{
            response()->json(['error', 'That year does not exist'], 422);
        }


        // Checking if a scheme with the requested details exists
        $scheme_subscription = SchemeSubscription::where('year_id', '=', $year_id)
                            ->where('subscription_period_id', '=', $request->subscription_period_id)
                            ->where('scheme_option_id', '=',  $request->scheme_option_id)
                            ->where('age_group_id', '=', $request->age_group_id)->first();

        // Initialising a varible for adding a scheme if it doesnt exist
        if(!$scheme_subscription){
            $scheme_subscription = new SchemeSubscription;
        }

        $scheme_subscription->year_id = $year_id;
        $scheme_subscription->scheme_option_id = $request->scheme_option_id;
        $scheme_subscription->currency_id = $request->currency_id;
        $scheme_subscription->age_group_id = $request->age_group_id;
        $scheme_subscription->subscription_period_id = $request->subscription_period_id;
        $scheme_subscription->amount = $request->amount;
        $scheme_subscription->save();

        return response()->json(['msg' => 'saved successfully!', 'status' => 200], 200);
    }

    /**
     * Getting all the benefit prices that
     * a particular scheme has.
     */
    public function benefitPrices($year, $scheme_option_id){
        $year_id = null;

        $year = Year::where('year', '=', $year)->first();

        if($year){
            $year_id = $year->id;
        }

        $scheme_benefit_amounts = SchemeBenefitAmount::where('year_id', '=', $year_id)
                                ->where('scheme_option_id', '=', $scheme_option_id)
                                ->orderBy('benefit_option_id', 'ASC')->get();
        
        $benefit_amounts = $scheme_benefit_amounts->map(function($item){
            return collect([
                "benefit_option_id" => $item?->benefit_option_id,
                "attributes" => [
                    "description" => $item->benefit?->description,
                    "currency" => $item->currency?->code,
                    "limit_amount" => $item?->limit_amount
                ]
            ]);
        });

        return $benefit_amounts;
    }

    /**
     * Adding the price for the benefit in a particular scheme
     */
    public function addUpdateSchemeBenefitAmount(Request $request){
        $this->validate($request, [
            'year' => 'required|string',
            'scheme_option_id' => 'required|integer',
            'benefit_option_id' => 'required|integer',
            'currency_id' => 'required|integer',
            'limit_amount' => 'required|numeric'
        ]);

        $year_id = null;
        
        $year = Year::where('year', '=', $request->year)->first();

        if($year){
            $year_id = $year->id;
        }

        // Checking if the benefit option and it's price exist
        $scheme_benefit_amounts = SchemeBenefitAmount::where('year_id', '=', $year_id)
                                ->where('scheme_option_id', '=', $request->scheme_option_id)
                                ->where('benefit_option_id', '=', $request->benefit_option_id)->first();
        
        // Condition for checking if it doesnt exist so that an new one is added.
        if(!$scheme_benefit_amounts){
            $scheme_benefit_amounts = new SchemeBenefitAmount;
        }

        // Saving the passed data
        $scheme_benefit_amounts->year_id = $year_id;
        $scheme_benefit_amounts->scheme_option_id = $request->scheme_option_id;
        $scheme_benefit_amounts->benefit_option_id = $request->benefit_option_id;
        $scheme_benefit_amounts->currency_id = $request->currency_id;
        $scheme_benefit_amounts->limit_amount = $request->limit_amount;
        $scheme_benefit_amounts->save();

        return response()->json(['msg' => 'saved successfully!', 'status' => 200], 200);
    }

    /**
     * Getting the currency and price that a scheme has
     * for the subscription period.
     */
    private function getSchemePrice($year_id, $subscription_period_id, $scheme_option_id, $age_group_id){
        $scheme_subscription = SchemeSubscription::where('year_id', '=', $year_id)
                            ->where('subscription_period_id', '=', $subscription_period_id)
                            ->where('scheme_option_id', '=',  $scheme_option_id)
                            ->where('age_group_id', '=', $age_group_id);

        if($scheme_subscription){
            return $scheme_subscription->first();
        }else{
            return [
                "currency" => '',
                "amount" => 0
            ];
        }
    }

    // importing the scheme premium prices
    public function importSchemeSubscriptions(Request $request){
        $this->validate($request, [
            'excel' => 'required|mimes:xlsx,csv,xls'
        ]);

        $file = $request->file('excel');

        // Helper function for initialising import progress
        saveProgress($file, 'scheme_subscriptions');

        Excel::import(new SchemeSubscriptionsImport, $request->file('excel'));

        return response()->json([
            'msg' => 'Import queued successfully!'
        ], 200);
    }

    public function SchemeSubscriptionsImportProgress(){
        // This is a helper function that shows the progress of the import
        return importProgress('scheme_subscriptions');
    }

    /**
     * Importing operations for the scheme's benefits
     */
    public function importSchemeBenefitPrices(Request $request){
        $this->validate($request, [
            'excel' => 'required|mimes:xlsx,csv,xls'
        ]);

        $file = $request->file('excel');

        // Helper function for initialising import progress
        saveProgress($file, 'scheme_benefit_amounts');

        Excel::import(new SchemeBenefitPricesImport, $request->file('excel'));

        return response()->json([
            'msg' => 'Import queued successfully!'
        ], 200);
    }

    public function SchemeBenefitPricesImportProgress(){
        // This is a helper function that shows the progress of the import
        return importProgress('scheme_benefit_amounts');
    }
}
