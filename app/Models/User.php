<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\Api\V1\UserAccess\Role;

use App\Models\Api\V1\Sales\Broker;
use App\Models\Api\V1\Sales\BrokerHouse;
use App\Models\Api\V1\Membership\Exclusion;
use App\Models\Api\V1\Lookups\Department;

use App\Models\Api\V1\Claims\ClaimsLog;

use App\Models\Api\V1\Claims\BatchAllocation;

class User extends Authenticatable
{ 
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
    protected $fillable = [
        'unique_id',
        'first_name',
        'last_name',
        'email',
        'role_id',
        'phone_number',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'pivot',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $primaryKey = 'user_id';

    public function role(){
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function authorisations(){
        return $this->hasMany(Authorisation::class, 'authorisation_id');
    }

    public function brokerHouse(){
        return $this->hasOne(BrokerHouse::class, 'user_id');
    }

    public function broker(){
        return $this->hasOne(Broker::class, 'user_id');
    }

    public function otp(){
        return $this->hasOne(OtpVerification::class, 'user_id');
    }

    public function exclusions(){
        return $this->hasMany(Exclusion::class, 'excluded_by');
    }

    public function routeNotificationForVonage($notification)
    {
        return $this->phone_number;
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function claimLogs(){
        return $this->hasMany(ClaimsLog::class, 'receiver_id');
    }

    public function batchAllocation(){
        return $this->hasMany(BatchAllocation::class, 'assessor_id');
    }
}
