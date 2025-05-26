<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, MorphMany, MorphOne};

class Event extends Model
{
    protected $fillable = ['user_id', 'event_type_id', 'location_id', 'title', 'description', 'start_time', 'end_time'];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function eventType()
    {
        return $this->belongsTo(EventType::class, 'event_type_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'event_id');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function mainImage()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    // Accessors
    public function getFullTitleAttribute()
    {
        return strtoupper($this->title) . ' - ' . date('Y/m/d', strtotime($this->start_time));
    }

    // Mutators
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = ucfirst(strtolower($value));
    }

    // Scopes
    public function scopeUpcoming(Builder $query)
    {
        return $query->where('start_time', '>', now());
    }

    public function scopeOfType(Builder $query, int $typeId)
    {
        return $query->where('event_type_id', $typeId);
    }

    public function scopeAtLocation(Builder $query, int $locationId)
    {
        return $query->where('location_id', $locationId);
    }
}