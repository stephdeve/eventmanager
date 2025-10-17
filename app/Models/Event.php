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
        'category',
        'start_date',
        'end_date',
        'location',
        'google_maps_url',
        'capacity',
        'available_seats',
        'is_capacity_unlimited',
        'price',
        'currency',
        'allow_payment_numeric',
        'allow_payment_physical',
        'allow_ticket_transfer',
        'daily_start_time',
        'daily_end_time',
        'cover_image',
        'organizer_id',
        'is_restricted_18',
        'slug',
        'shareable_link',
        'promo_clicks',
        'promo_registrations',
        // Finance
        'total_revenue_minor',
        'total_tickets_sold',
        'revenue_threshold_minor',
        'revenue_threshold_notified_at',
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
        'is_capacity_unlimited' => 'boolean',
        'price' => 'integer', // Stocké en plus petite unité
        'currency' => 'string',
        'category' => 'string',
        'google_maps_url' => 'string',
        'allow_payment_numeric' => 'boolean',
        'allow_payment_physical' => 'boolean',
        'allow_ticket_transfer' => 'boolean',
        'is_restricted_18' => 'boolean',
        'promo_clicks' => 'integer',
        'promo_registrations' => 'integer',
        'total_revenue_minor' => 'integer',
        'total_tickets_sold' => 'integer',
        'revenue_threshold_minor' => 'integer',
        'revenue_threshold_notified_at' => 'datetime',
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
        if ($this->is_capacity_unlimited) {
            return false;
        }
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

    public function payments()
    {
        return $this->hasMany(EventPayment::class);
    }

    /**
     * Get all tickets for the event.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Get approved reviews for the event.
     */
    public function reviews()
    {
        return $this->hasMany(EventReview::class)->where('approved', true)->latest();
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
        if ($this->is_capacity_unlimited) {
            return true;
        }
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
