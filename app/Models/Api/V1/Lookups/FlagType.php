<?php

namespace App\Models\Api\V1\Lookups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlagType extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description'
    ];
}
