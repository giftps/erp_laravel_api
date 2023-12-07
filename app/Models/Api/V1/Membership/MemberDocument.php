<?php

namespace App\Models\Api\V1\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberDocument extends Model
{
    use HasFactory;

    public function member(){
        return $this->belongsTo(Member::class, 'member_id');
    }
}
