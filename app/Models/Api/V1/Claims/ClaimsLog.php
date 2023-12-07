<?php

namespace App\Models\Api\V1\Claims;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Api\V1\HealthProcessings\ServiceProvider;

class ClaimsLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_number',
        'service_provider_id',
        'date_received',
        'due_date',
        'statement_month',
        'statement_total',
        'number_of_invoices',
        'receiver_id',
        'status'
    ];

    public function batchAllocation(){
        return $this->hasMany(BatchAllocation::class, 'claims_log_id');
    }

    public function receivedBy(){
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function serviceProvider(){
        return $this->belongsTo(ServiceProvider::class, 'service_provider_id');
    }

    public function claims(){
        return $this->hasMany(Claim::class, 'claims_logs_id');
    }
}
