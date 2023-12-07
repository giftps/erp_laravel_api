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
use App\Models\Api\V1\Lookups\SubscriptionPeriod;
use App\Models\Api\V1\Lookups\Currency;
use App\Models\Api\V1\Lookups\BenefitOption;
use App\Models\Api\V1\Lookups\SchemeBenefitAmount;

class SchemeBenefitPricesImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts, WithValidation, ShouldQueue
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach($rows as $row){

            $year_id = $this->getYearId($row['year']);

            $scheme_option_id = $this->getSchemeOptionId($row['scheme']);

            $benefit_option_id = $this->getBenefitOptionId($row['benefit_code']);

            $currency_id = $this->getCurrencyId($row['currency_code']);


            // Checking if the benefit option and it's price exist
            $scheme_benefit_amounts = SchemeBenefitAmount::where('year_id', '=', $year_id)
                                                    ->where('scheme_option_id', '=', $scheme_option_id)
                                                    ->where('benefit_option_id', '=', $benefit_option_id)->first();

            // Condition for checking if it doesnt exist so that an new one is added.
            if(!$scheme_benefit_amounts){
                $scheme_benefit_amounts = new SchemeBenefitAmount;
            }

            // Saving the passed data
            $scheme_benefit_amounts->year_id = $year_id;
            $scheme_benefit_amounts->scheme_option_id = $scheme_option_id;
            $scheme_benefit_amounts->benefit_option_id = $benefit_option_id;
            $scheme_benefit_amounts->currency_id = $currency_id;
            $scheme_benefit_amounts->limit_amount = $row['amount'];
            $scheme_benefit_amounts->save();

            // Adding progress to database
            $progress = ImportProgress::where('name', '=', 'scheme_benefit_amounts')->get()->last();

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
            '*.benefit_code' => 'required|string',
            '*.year' => 'required|integer',
            '*.currency_code' => 'required|string|in:USD,ZMW,ZAR,INR',
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

    private function getSchemeOptionId($scheme){
        $scheme_option = SchemeOption::where('name', '=', $scheme)->first();

        return $scheme_option?->id;
    }

    private function getCurrencyId($code){
        $currency = Currency::where('code', '=', $code)->first();

        return $currency?->id;
    }

    private function getBenefitOptionId($code){
        $benefit_option = BenefitOption::where('code', '=', $code)->first();
        return $benefit_option?->id;
    }
}
