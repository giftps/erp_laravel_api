<?php

namespace App\Models\Api\V1\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Api\V1\ServiceProviders\ServiceCode;
use App\Models\User;

class Exclusion extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'dependent_id',
        'member_id'
    ];

    protected $primaryKey = 'exclusion_id';

    public function serviceCode(){
        return $this->belongsTo(ServiceCode::class, 'service_code_id');
    }

    public function member(){
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function excluder(){
        return $this->belongsTo(User::class, 'excluded_by');
    }
}
