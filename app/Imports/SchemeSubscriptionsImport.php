<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\ImportHasFailedNotification;
use Illuminate\Support\Facades\DB;
use App\Models\ImportProgress;
use Illuminate\Http\UploadedFile;
use \PhpOffice\PhpSpreadsheet\Shared\Date;

use App\Models\Api\V1\Lookups\SchemeOption;
use App\Models\Api\V1\Lookups\Year;
use App\Models\Api\V1\Lookups\AgeGroup;
use App\Models\Api\V1\Lookups\SubscriptionPeriod;
use App\Models\Api\V1\Lookups\Currency;
use App\Models\Api\V1\Lookups\SchemeSubscription;

class SchemeSubscriptionsImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach($rows as $row){

            $year_id = $this->getYearId($row['year']);

            $subscription_period_id = $this->getSubscriptionPeriodId($row['subscription_period']);

            $scheme_option_id = $this->getSchemeOptionId($row['scheme']);

            $age_group_id = $this->getAgeGroupId($row['age_group_code']);

            $currency_id = $this->getCurrencyId($row['currency_code']);


            // Checking if a scheme with the requested details exists
            $scheme_subscription = SchemeSubscription::where('year_id', '=', $year_id)
                                ->where('subscription_period_id', '=', $subscription_period_id)
                                ->where('scheme_option_id', '=',  $scheme_option_id)
                                ->where('age_group_id', '=', $age_group_id)->first();

            // Initialising a varible for adding a scheme if it doesnt exist
            if(!$scheme_subscription){
                $scheme_subscription = new SchemeSubscription;
            }

            $scheme_subscription->year_id = $year_id;
            $scheme_subscription->scheme_option_id = $scheme_option_id;
            $scheme_subscription->currency_id = $currency_id;
            $scheme_subscription->age_group_id = $age_group_id;
            $scheme_subscription->subscription_period_id = $subscription_period_id;
            $scheme_subscription->amount = $row['amount'];
            $scheme_subscription->save();

            // Adding progress to database
            $progress = ImportProgress::where('name', '=', 'scheme_subscriptions')->get()->last();

            $processed_records = $progress->processed_records + 1;
            $total_records = $progress->total_records;

            $progress->processed_records = $processed_records;
            $progress->percentage_complete = ($processed_records/$total_records) * 100;
            $progress->save();
        }
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function rules(): array
    {
        return [
            '*.scheme' => 'required|string',
            '*.year' => 'required|integer',
            '*.currency_code' => 'required|string|in:USD,ZMW,ZAR,INR',
            '*.age_group_code' => 'required|string',
            '*.subscription_period' => 'required|string|in:Quarterly,Bi-Annually,Annually',
            '*.amount' => 'required|numeric'
        ];
    }   

    private function getYearId($year){
        $year = Year::where('year', '=', $year)->first();

        if($year){
            return $year->id;
        }else{
            $new_year = new Year;
            $new_year->year = $row['year'];
            $new_year->save();

            return $new_year->id;
        }
    }

    private function getSubscriptionPeriodId($subscription_period){
        $subscription_period = SubscriptionPeriod::where('name', '=', $subscription_period)->first();

        return $subscription_period?->id;
    }

    private function getSchemeOptionId($scheme){
        $scheme_option = SchemeOption::where('name', '=', $scheme)->first();

        return $scheme_option?->id;
    }

    private function getAgeGroupId($code){
        $age_group = AgeGroup::where('code', '=', $code)->first();

        return $age_group?->id;
    }

    private function getCurrencyId($code){
        $currency = Currency::where('code', '=', $code)->first();

        return $currency?->id;
    }
}
