<?php

namespace App\Imports;

use App\Models\Api\V1\Sales\Broker;
use App\Models\Api\V1\Sales\BrokerHouse;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class BrokersImport implements ToCollection, WithStartRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function collection(Collection $rows)
    {   
        foreach ($rows as $row){
            $email = $row[11];
                
            $broker = Broker::where('email', '=', $email)->first();

            if (!$broker){
                $broker = new Broker;
            }

            $broker_house = BrokerHouse::where('name', '=', $row[0])->first();

            $broker->broker_house_id = $broker_house->broker_house_id;
            $broker->code = $row[1];
            $broker->title = $row[2];
            $broker->first_name = $row[3];
            $broker->surname = $row[4];
            $broker->id_number = $row[5];
            $broker->address1 = $row[6];
            $broker->address2 = $row[7];
            $broker->city = $row[8];
            $broker->office_number = $row[9];
            $broker->phone_number = $row[10];
            $broker->email = $row[11];
            $broker->active_date = $row[11];
            $broker->inactive_date = $row[12];
            $broker->status = $row[13];
            $broker->save();
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}