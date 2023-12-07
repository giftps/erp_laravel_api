<?php

namespace App\Models\Api\V1\Membership;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberBankDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_name',
        'account_holder',
        'account_number',
        'branch',
        'branch_code',
        'account_type',
        'swift_code',
        'member_id'
    ];

    protected $primaryKey = 'member_bank_details_id';

    public function member(){
        return $this->belongsTo(Member::class);
    }
}
