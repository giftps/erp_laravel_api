<?php

namespace App\Models\Api\V1\Lookups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'name'
    ];

    public function country(){
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
