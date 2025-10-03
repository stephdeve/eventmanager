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
    ];
    
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => 'string',
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
        return $this->role === 'student';
    }
    
    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
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
