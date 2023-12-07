<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Models\Api\V1\HealthProcessings\Tariff;
use App\Models\Api\V1\Lookups\ClaimCode;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\ImportHasFailedNotification;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\ImportProgress;
use Illuminate\Http\UploadedFile;

class TariffsImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts, WithValidation, ShouldQueue
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function collection(Collection $rows)
    {  
        foreach($rows as $row){
            // Add the row data to the $data array
            DB::table('tariffs')->insert([
                'tariff_group' => $row['tariff_group'],
                'code' => isset($row['tariff_code']) ? (string)$row['tariff_code'] : null,
                'effective_date' =>$row['effective_date'],
                'practice_type' => $row['practice_type'],
                'description' => $row['description'],
                'ses_rate' => (double)$row['ses_rate'],
                'claim_code_id' => ClaimCode::where("code", "=", (string)$row['claim_code'])->first()?->id,
                'effective_date' =>$row['effective_date'],
            ]);

            // Adding progress to database
            $progress = ImportProgress::where('name', '=', 'tariffs')->get()->last();

            $processed_records = $progress->processed_records + 1;
            $total_records = $progress->total_records;

            $progress->processed_records = $processed_records;
            $progress->percentage_complete = ($processed_records/$total_records) * 100;
            $progress->save();
        };
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
            '*.tariff_group' => ['required', 'string'],
            '*.code' => ['nullable', 'sometimes', 'integer'],
            '*.effective_date' => ['required', 'date'],
            '*.practice_type' => ['required', 'integer'],
            '*.description' => ['required', 'string'],
            '*.ses_rate' => ['required', 'numeric'],
            '*.claim_code' => ['required', 'integer'],
            '*.claim_type' => ['nullable', 'sometimes', 'string'],
        ];
    }
}