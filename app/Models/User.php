<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasUuids;
    
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'subscription_plan',
        'must_verify_identity',
        'is_identity_verified',
        'date_of_birth_verified',
        // OAuth Google
        'google_id',
        'avatar_url',
        'email_verified_at',
    ];
    
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => 'string',
        'subscription_plan' => 'string',
        'subscription_status' => 'string',
        'subscription_started_at' => 'datetime',
        'subscription_expires_at' => 'datetime',
        'must_verify_identity' => 'boolean',
        'is_identity_verified' => 'boolean',
        'date_of_birth_verified' => 'date',
    ];
    
    /**
     * Get the events organized by this user.
     */
    public function organizedEvents()
    {
        return $this->hasMany(Event::class, 'organizer_id');
    }
    
    /**
     * Get the user's event registrations.
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
    
    /**
     * Get the events the user is registered for.
     */
    public function events()
    {
        return $this->belongsToMany(Event::class, 'registrations')
                   ->withPivot('is_validated', 'created_at')
                   ->withTimestamps();
    }
    
    /**
     * Check if the user is an organizer.
     */
    public function isOrganizer(): bool
    {
        return $this->role === 'organizer';
    }
    
    /**
     * Check if the user is a student.
     */
    public function isStudent(): bool
    {
        return in_array($this->role, ['student', 'user'], true);
    }
    
    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user currently has an active organizer subscription.
     */
    public function hasActiveSubscription(): bool
    {
        if ($this->isAdmin()) {
            return true;
        }
        if (!$this->isOrganizer()) {
            return false;
        }
        if (!in_array($this->subscription_plan, ['basic', 'premium', 'pro'], true)) {
            return false;
        }
        if (($this->subscription_status ?? 'inactive') !== 'active') {
            return false;
        }
        if (!$this->subscription_expires_at) {
            return false;
        }
        return now()->lt($this->subscription_expires_at);
    }

    /**
     * Whether the subscription has expired.
     */
    public function isSubscriptionExpired(): bool
    {
        return (bool) ($this->subscription_expires_at && now()->gte($this->subscription_expires_at));
    }

    public function identityVerification()
    {
        return $this->hasOne(IdentityVerification::class)->latestOfMany();
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
