<?php

namespace App\Models\Api\V1\Lookups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Api\V1\Membership\Family;

class GroupType extends Model
{
    use HasFactory;

    protected $fillable = [
        'description'
    ];

    public function families(){
        return $this->hasMany(Family::class, 'group_type_id');
    }
}