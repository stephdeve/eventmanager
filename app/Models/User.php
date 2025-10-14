<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

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
    ];
    
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => 'string',
        'subscription_plan' => 'string',
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
