<?php

namespace App\Imports;

use App\Models\Api\V1\HealthProcessings\ServiceProvider;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

use App\Models\Api\V1\HealthProcessings\Discipline;
use App\Models\Api\V1\Lookups\Currency;

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

class ServiceProvidersImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts, WithValidation, ShouldQueue
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function collection(Collection $rows)
    {
        foreach($rows as $row){
            $practice_number = ServiceProvider::where('practice_number', '=', $row['practice_number'])->first()?->practice_number;
            $pay_currency_id = Currency::where('code', '=', $row['pay_currency'])->first()?->id;
            $receive_currency_id = Currency::where('code', '=', $row['receive_currency'])->first()?->id;
            $discipline = Discipline::where('description', '=', $row['discipline'])->first();
            $activation_date = Date::excelToDateTimeObject((int)$row['activation_date'])->format('Y-m-d');

            DB::table('service_providers')->updateOrInsert(
                [
                    'practice_number' =>  $row['practice_number'],
                    'discipline_id' => $discipline->discipline_id,
                    'pay_currency_id' => $pay_currency_id,
                    'receive_currency_id' => $receive_currency_id,
                    'name' => $row['name'],
                    'mobile_number' => $row['mobile_number'],
                    'provider_category' => $row['provider_category'],
                    'email' => $row['email'],
                    'address1' => $row['address1'],
                    'address2' => $row['address2'],
                    'address3' => $row['address3'],
                    'country' => $row['country'],
                    'is_group_practice' => $row['is_group_practice'],
                    'provider_type' => $row['provider_type'],
                    'is_ses_network_provider' => $row['is_ses_network_provider'],
                    'sla' => $row['sla'],
                    'payment_term_days' => $row['payment_term_days'],
                    'discount' => $row['discount'],
                    'activation_date' => $activation_date,
                    'tier_level' => $row['tier_level'], 
                    'status' => $row['status']
                ],
                ['practice_number' => $practice_number ? $practice_number : $row['practice_number']]
            );

            // Adding progress to database
            $progress = ImportProgress::where('name', '=', 'health_care_providers')->get()->last();

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
            '*.discipline' => ['required', 'string'],
            '*.pay_currency' => ['required', 'string'],
            '*.receive_currency' => ['required', 'string'],
            '*.name' => ['required', 'string'],
            '*.mobile_number' => ['required'],
            '*.provider_category' => ['required', 'string'],
            '*.email' => 'required|email',
            '*.address1' => ['required', 'string'],
            '*.address2' => ['nullable', 'sometimes', 'string'],
            '*.address3' => ['nullable', 'sometimes', 'string'],
            '*.country' => ['required', 'string'],
            '*.practice_number' => ['required'],
            '*.is_group_practice' => ['nullable', 'sometimes', 'boolean'],
            '*.provider_type' => ['required', 'string'],
            '*.is_ses_network_provider' => ['required', 'boolean'],
            '*.sla' => ['required', 'boolean'],
            '*.payment_term_days' => ['required', 'integer'],
            '*.discount' => ['required', 'numeric'],
            '*.activation_date' => ['required'],
            '*.tier_level' => ['required', 'integer'],
            '*.status' => ['required', 'string']
        ];
    }   
}