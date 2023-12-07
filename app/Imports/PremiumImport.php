<?php

namespace App\Imports;

use App\Models\Api\V1\Financials\PremiumPayment;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

use \PhpOffice\PhpSpreadsheet\Shared\Date;

class PremiumImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts, WithValidation
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public $group_id;

    public function __construct()
    {
        
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row){
            $premium = new PremiumPayment;
        }
    }

    public function batchSize(): int
    {
        return 2000;
    }

    public function chunkSize(): int
    {
        return 2000;
    }

    public function rules(): array
    {
        return [
            '*.family_code' => ['required', 'integer'],
            '*.currency' => ['required', 'string'],
            '*.amount' => ['required', 'numeric'],
        ];
    }
}