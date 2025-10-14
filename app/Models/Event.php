<?php

namespace App\Models;

use App\Support\Currency;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'capacity',
        'available_seats',
        'price',
        'currency',
        'cover_image',
        'organizer_id',
        'is_restricted_18',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'capacity' => 'integer',
        'available_seats' => 'integer',
        'price' => 'integer', // Stocké en plus petite unité
        'currency' => 'string',
        'is_restricted_18' => 'boolean',
    ];
    
    /**
     * Get the URL of the cover image.
     *
     * @return string|null
     */
    public function getCoverImageUrlAttribute()
    {
        if (!$this->cover_image) {
            return asset('images/event-default.jpg');
        }
        
        return asset('storage/' . $this->cover_image);
    }
    
    /**
     * Get the price in euros.
     *
     * @return float
     */
    public function getPriceForDisplayAttribute(): string
    {
        return Currency::format($this->price, $this->currency ?? 'EUR');
    }
    
    /**
     * Check if the event is full.
     *
     * @return bool
     */
    public function isFull()
    {
        return $this->available_seats <= 0;
    }
    
    /**
     * Scope a query to only include upcoming events.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now());
    }

    /**
     * Get the organizer of the event.
     */
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    /**
     * Get all registrations for the event.
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Get all users registered for the event.
     */
    public function attendees()
    {
        return $this->belongsToMany(User::class, 'registrations')
                   ->withPivot('is_validated', 'created_at')
                   ->withTimestamps();
    }

    /**
     * Check if the event has available seats.
     */
    public function hasAvailableSeats(): bool
    {
        return $this->available_seats > 0;
    }

    /**
     * Get the number of registered attendees.
     */
    public function getRegisteredAttendeesCountAttribute(): int
    {
        return $this->registrations()->count();
    }
}
