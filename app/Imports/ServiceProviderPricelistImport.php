<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use App\Models\Api\V1\HealthProcessings\ServiceProvider;
use App\Models\Api\V1\HealthProcessings\ServiceProviderPriceList;
use App\Models\Api\V1\HealthProcessings\Tariff;
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

class ServiceProviderPricelistImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts, WithValidation, ShouldQueue
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach($rows as $row){
            $service_provider_id = ServiceProvider::where('practice_number', '=', $row['practice_number'])->first()?->service_provider_id;

            $unique_identifier = ServiceProviderPriceList::where('service_provider_id', '=',  $service_provider_id)->where('description', '=', $row['description'])->first()?->id;
            
            $tariff_id = Tariff::where('code', '=', $row['tariff_code'])->first()?->id;

            DB::table('service_provider_price_lists')->updateOrInsert(
                [
                    'service_provider_id' => $service_provider_id,
                    'tariff_id' => $tariff_id,
                    'year' => $row['year'],
                    'description' => $row['description'],
                    'price' => $row['price']
                ],
                ['id' => $unique_identifier]
            );

            // Adding progress to database
            $progress = ImportProgress::where('name', '=', 'price_list')->get()->last();

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
            '*.practice_number' => 'required',
            '*.tariff_code' => 'required',
            '*.year' => 'required|integer|min:' . 1990,
            '*.description' => 'required|string',
            '*.price' => 'required|numeric'
        ];
    }   
}
