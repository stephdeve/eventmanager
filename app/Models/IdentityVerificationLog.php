<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentityVerificationLog extends Model
{
    use HasFactory, HasUuids;
    
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'identity_verification_id',
        'event',
        'details',
        'ip_address',
        'user_agent',
        'performed_by',
    ];

    protected $casts = [
        'details' => 'array',
    ];

    public function verification()
    {
        return $this->belongsTo(IdentityVerification::class, 'identity_verification_id');
    }

    public function performer()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
