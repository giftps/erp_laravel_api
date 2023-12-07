<?php

namespace App\Models\Api\V1\Lookups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExclusionCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'description'
    ];
}
