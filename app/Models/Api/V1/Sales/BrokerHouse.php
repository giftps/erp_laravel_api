<?php

namespace App\Models\Api\V1\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Api\V1\Lookups\BrokerType;
use App\Models\Api\V1\Media\File;

class BrokerHouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'broker_type_id',
        'name',
        'address1',
        'address2',
        'city',
        'code',
        'contact_person_name',
        'contact_person_email',
        'mobile_number',
        'office_number',
        'website_address',
        'active_date',
        'inactive_date',
        'status',
    ];

    protected $primaryKey = 'broker_house_id';

    public function brokerType(){
        return $this->belongsTo(BrokerType::class, 'broker_type_id');
    }

    public function brokers(){
        return $this->hasMany(Broker::class, 'broker_house_id');
    }

    public function files(){
        return $this->morphMany(File::class, 'fileable');
    }
}
