<?php

namespace App\Models\Api\V1\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\User;
use App\Models\Api\V1\Membership\MainMember;
use App\Models\Api\V1\Membership\Family;
use App\Models\Api\V1\Media\File;

class Broker extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'code',
        'office_number',
        'cellphone_number',
        'email',
        'physical_address',
        'postal_address',
        'postal_code',
        'nearest_city',
        'status',
    ];

    protected $primaryKey = 'broker_id';

    public function employerGroup(){
        return $this->hasMany(EmployerGroup::class, 'broker_id');
    }

    public function mainMembers(){
        return $this->hasMany(MainMember::class, 'broker_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function brokerHouse(){
        return $this->belongsTo(BrokerHouse::class, 'broker_house_id');
    }

    public function families(){
        return $this->hasMany(Family::class, 'broker_id');
    }

    public function files(){
        return $this->morphMany(File::class, 'fileable');
    }
}
