<?php

namespace App\Models\Api\V1\Claims;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class BatchAllocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'claims_log_id',
        'assessor_id',
        'assigned_on',
        'status'
    ];

    public function claimsLog(){
        return $this->belongsTo(ClaimsLog::class, 'claims_log_id');
    }

    public function assessor(){
        return $this->belongsTo(User::class, 'assessor_id');
    }
}
