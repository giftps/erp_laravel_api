<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallCategory extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    protected $primaryKey = 'call_category_id';

    use HasFactory;

    public function callLogs(){
        return $this->hasMany(CallLog::class, 'call_log_id');
    }
}
