<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'member_id',
        'call_type',
        'request_type',
        'call_log_number',
        'notes'
    ];

    protected $primaryKey = 'call_log_id';

    public function authorisation(){
        return $this->hasOne(Authorisation::class, 'call_log_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function member(){
        return $this->hasMany(Member::class, 'member_id');
    }

    public function callCategory(){
        return $this->belongsTo(CallCategory::class, 'call_category_id');
    }
}
