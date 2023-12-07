<?php

namespace App\Imports;

use App\Models\Api\V1\EmployerGroups\EmployerGroup;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Illuminate\Support\Facades\Validator;
use App\Models\Api\V1\Group;

use \PhpOffice\PhpSpreadsheet\Shared\Date;

class GroupsImports implements ToCollection, WithStartRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function collection(Collection $rows)
    {   
        Validator::make($rows->toArray(), [
            '*.0' => 'required'
        ])->validate();

        foreach ($rows as $row){
            $group = Group::where('code', '=', $row[1])->first();

            if(!$group){
                $group = new group;
            }

            $group->group_name = $row[0];
            $group->code = $row[1];
            $group->office_number = $row[2];
            $group->nuit = $row[3];
            $group->website = $row[4];
            $group->industry = $row[5];
            $group->group_size = $row[6];
            $group->contact_person_name = $row[7];
            $group->contact_email = $row[8];
            $group->contact_phone_number = $row[9];
            $group->join_date = $row[10];
            $group->status = $row[11];
            $group->save();
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}