<?php

namespace App\Models\Api\V1\Lookups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrokerType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected $primaryKey = 'broker_type_id';

    public function brokerHouses(){
        return $this->hasMany(BrokerHouse::class, 'broker_type_id');
    }
}
