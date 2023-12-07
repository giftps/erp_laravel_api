<?php

namespace App\Imports;

use App\Models\Api\V1\EmployerGroups\EmployerGroup;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Illuminate\Support\Facades\Validator;

use \PhpOffice\PhpSpreadsheet\Shared\Date;

class EmployerGroupsImports implements ToCollection, WithStartRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function collection(Collection $rows)
    {   
        Validator::make($rows->toArray(), [
            '*.0' => 'required',
            '*.1' => 'required',
            '*.2' => 'required',
            '*.3' => 'nullable|sometimes',
            '*.4' => 'required',
            '*.5' => 'nullable|sometimes',
            '*.6' => 'required',
            '*.7' => 'nullable|sometimes',
            '*.8' => 'nullable|sometimes',
            '*.9' => 'nullable|sometimes',
            '*.10' => 'required',
            '*.11' => 'required',
            '*.12' => 'nullable|sometimes|email',
            '*.13' => 'nullable|sometimes',
            '*.14' => 'nullable|sometimes',
            '*.15' => 'required',
            '*.16' => 'nullable|sometimes',
            '*.17' => 'nullable|sometimes',
            '*.18' => 'nullable|sometimes',
            '*.19' => 'nullable|sometimes',
            '*.20' => 'nullable|sometimes',
            '*.21' => 'nullable|sometimes',
            '*.22' => 'nullable|sometimes',
            '*.23' => 'nullable|sometimes',
            '*.24' => 'nullable|sometimes',
            '*.25' => 'nullable|sometimes',
            '*.26' => 'nullable|sometimes',
            '*.27' => 'nullable|sometimes',
            '*.28' => 'nullable|sometimes',
            '*.29' => 'nullable|sometimes',
            '*.30' => 'nullable|sometimes',
            '*.31' => 'nullable|sometimes',
            '*.32' => 'nullable|sometimes',
            '*.33' => 'nullable|sometimes',
            '*.34' => 'nullable|sometimes',
            '*.35' => 'nullable|sometimes',
            '*.36' => 'nullable|sometimes',
            '*.37' => 'nullable|sometimes',
            '*.38' => 'nullable|sometimes',
            '*.39' => 'nullable|sometimes',
            '*.40' => 'nullable|sometimes',
            '*.41' => 'nullable|sometimes',
            '*.42' => 'nullable|sometimes',
            '*.43' => 'nullable|sometimes',
        ])->validate();

        foreach ($rows as $row){
            $member = Member::where('member_number', '=', $row[0])->first();

            if(!$member){
                $member = new Member;
            }

            $member->family_id = $this->getFamilyId($row, $row[2], $row[6]);
            $member->scheme_option_id = $this->getSchemeOptionId($row[15]);
            $member->scheme_type_id = $this->getSchemeTypeId($row[16]);
            $member->dependent_code = $row[1];
            $member->member_number = $row[0];
            $member->title = $row[3];
            $member->first_name = $row[4];
            $member->last_name = $row[6];
            $member->other_names = $row[5];
            $member->dob = Date::excelToDateTimeObject($row[10])->format('Y-m-d');
            $member->gender = $row[11];
            $member->marital_status = $row[7];
            $member->language = $row[41];
            $member->nrc_or_passport_no = $row[8];
            $member->occupation = $row[9];
            $member->relationship = $row[42];
            $member->email = $row[12];
            $member->work_number = $row[14];
            $member->mobile_number = $row[13];
            $member->join_date = Date::excelToDateTimeObject($row[43])->format('Y-m-d');
            $member->is_principal = $row[1] == "00" ? true : false;
            $member->has_sports_loading = $row[32];
            $member->sports_loading_start_date = Date::excelToDateTimeObject($row[33])->format('Y-m-d');
            $member->sports_loading_end_date = Date::excelToDateTimeObject($row[34])->format('Y-m-d');
            $member->sporting_activity = $row[35];
            $member->save();
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}