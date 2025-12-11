<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    use HasFactory, HasUuids;
    
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'event_id',
        'registration_id',
        'owner_user_id',
        'qr_code_data',
        'qr_code_path',
        'qr_code_png_path',
        'status',
        'paid',
        'payment_method',
        'scanned_at',
        'validated_by',
        'validated_at',
        'transferred_to',
    ];

    protected $casts = [
        'paid' => 'boolean',
        'scanned_at' => 'datetime',
        'validated_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_user_id');
    }

    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    public function transfers(): HasMany
    {
        return $this->hasMany(TicketTransfer::class);
    }
}
