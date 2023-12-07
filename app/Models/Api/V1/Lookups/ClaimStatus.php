<?php

namespace App\Models\Api\V1\Lookups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
}
