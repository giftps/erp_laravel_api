<?php

namespace App\Imports;

use App\Models\Api\V1\Sales\BrokerHouse;
use App\Models\Api\V1\Lookups\BrokerType;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class BrokerHousesImport implements ToCollection, WithStartRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function collection(Collection $rows)
    {        foreach ($rows as $row){
                $contact_person_email = $row[7];
                
                $broker_house = BrokerHouse::where('contact_person_email', '=', $contact_person_email)->first();

                if (!$broker_house){
                    $broker_house = new BrokerHouse;
                }

                $broker_type = BrokerType::where('name', '=', $row[0])->first();

                $broker_house->broker_type_id = $broker_type->broker_type_id;
                $broker_house->user_id = null;
                $broker_house->name = $row[1];
                $broker_house->address1 = $row[2];
                $broker_house->address2 = $row[3];
                $broker_house->city = $row[4];
                $broker_house->code = $row[5];
                $broker_house->contact_person_name = $row[6];
                $broker_house->contact_person_email = $row[7];
                $broker_house->office_number = $row[8];
                $broker_house->mobile_number = $row[9];
                $broker_house->website_address = $row[10];
                $broker_house->active_date = $row[11];
                $broker_house->inactive_date = $row[12];
                $broker_house->status = $row[13];
                $broker_house->save();
            }
    }

    public function startRow(): int
    {
        return 2;
    }
}