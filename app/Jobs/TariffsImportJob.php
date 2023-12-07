<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use App\Imports\TariffsImport;
use Illuminate\Validation\Rule;
use App\Models\Api\V1\Lookups\ClaimCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TariffsImportJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $file;
    protected $totalRows;
    protected $currentRow;

    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $file = Storage::disk('local')->get($this->file);
        $tariffs = Excel::load($file)->get();

        $totalRows = $tariffs->count();
        $importedRows = 0;

        $validatedData = $tariffs->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')
            ],
            'password' => 'required',
            'role_name' => 'required'
        ]);

        foreach ($validatedData->chunk(1000) as $chunk) {
            foreach ($chunk as $user) {
                $roleName = $user['role_name'];
                $role = DB::table('roles')->where('name', $roleName)->first();

                DB::table('tariffs')->insert([
                    'tariff_group' => $row['tariff_group'],
                    'tariff_code' => isset($row['tariff_code']) ? (string)$row['tariff_code'] : null,
                    'effective_date' =>$row['effective_date'],
                    'practice_type' => $row['practice_type'],
                    'description' => $row['description'],
                    'ses_rate' => $row['ses_rate'],
                    'claim_code_id' => ClaimCode::where("code", "=", (string)$row['claim_code'])->first()?->id,
                    'effective_date' =>$row['effective_date']
                ]);

                $importedRows++;

                // Show progress
                $progress = ($importedRows / $totalRows) * 100;
                Cache::put('tariffs_import_progress', $progress);
            }
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
