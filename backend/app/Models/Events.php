<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // <- for type hinting
use App\Models\User;

class Events extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'location',
        'payment_method',
    ];

    /**
     * Get all users who RSVP'd to this event.
     */
    public function attendees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_user');
    }

    /**
     * Get the total count of RSVP'd users.
     */
    public function getAttendeeCountAttribute(): int
    {
        return $this->attendees()->count();
    }
}
