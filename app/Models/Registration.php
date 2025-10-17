<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'event_id',
        'quantity',
        'qr_code_data',
        'qr_code_path',
        'qr_code_png_path',
        'is_validated',
        'payment_status',
        'payment_reference',
        'payment_session_url',
        'payment_metadata',
        'paid_at',
        'identity_verification_id',
        'age_restriction_passed',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity' => 'integer',
        'is_validated' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'validated_at' => 'datetime',
        'paid_at' => 'datetime',
        'payment_metadata' => 'array',
        'age_restriction_passed' => 'boolean',
    ];

    /**
     * Get the user that owns the registration.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the event that owns the registration.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Tickets generated for this registration (one per seat).
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Mark the registration as validated.
     */
    public function markAsValidated(): bool
    {
        return $this->update(['is_validated' => true]);
    }

    /**
     * Get the QR code URL for this registration.
     */
    public function getQrCodeUrl(): string
    {
        return route('tickets.show', $this->qr_code_data);
    }

    /**
     * Scope a query to only include validated registrations.
     */
    public function scopeValidated($query)
    {
        return $query->where('is_validated', true);
    }

    /**
     * Scope a query to only include pending validations.
     */
    public function scopePending($query)
    {
        return $query->where('is_validated', false);
    }
}
