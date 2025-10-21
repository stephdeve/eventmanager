<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'title',
        'description',
        'date',
        'type',
        'max_points',
    ];

    protected $casts = [
        'date' => 'datetime',
        'max_points' => 'integer',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
