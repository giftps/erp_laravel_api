<?php

namespace App\Models\Api\V1\Lookups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Api\V1\Membership\Member;

class SchemeType extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'identifier',
        'description'
    ];

    public function members(){
        return $this->hasMany(Member::class, 'scheme_type_id');
    }
}
