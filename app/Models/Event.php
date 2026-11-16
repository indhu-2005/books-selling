<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'event_date',
        'event_time',
        'location',
        'event_type',
        'description',
        'speaker',
        'image',
        'entry_fee',
        'max_attendees',
        'attendees_count',
    ];

    protected $casts = [
        'event_date' => 'date',
        'max_attendees' => 'integer',
        'attendees_count' => 'integer',
    ];

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }
}
