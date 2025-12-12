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

    public function validations(): HasMany
    {
        return $this->hasMany(TicketValidation::class);
    }

    /**
     * Check if ticket has been validated today
     */
    public function isValidatedToday(): bool
    {
        return $this->validations()
            ->whereDate('validation_date', today())
            ->exists();
    }

    /**
     * Check if ticket can be validated today
     */
    public function canBeValidatedToday(): bool
    {
        // Vérifier si le ticket est valide
        if ($this->status !== 'valid') {
            return false;
        }

        // Vérifier si déjà validé aujourd'hui
        if ($this->isValidatedToday()) {
            return false;
        }

        // Vérifier si on est dans la période de l'événement
        $event = $this->event;
        if (!$event) {
            return false;
        }

        $today = today();
        $start = $event->start_date ? $event->start_date->startOfDay() : null;
        $end = $event->end_date ? $event->end_date->endOfDay() : null;

        if (!$start || !$end) {
            return false;
        }

        return $today->between($start, $end);
    }

    /**
     * Validate ticket for today
     */
    public function validateForToday(?User $validator = null): TicketValidation|false
    {
        if (!$this->canBeValidatedToday()) {
            return false;
        }

        return $this->validations()->create([
            'validated_by' => $validator?->id,
            'validation_date' => today(),
            'validated_at' => now(),
            'validation_method' => 'scan',
        ]);
    }
}
