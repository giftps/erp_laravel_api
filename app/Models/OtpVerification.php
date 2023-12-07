<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'otp', 'expires_at'];
    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
