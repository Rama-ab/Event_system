<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Reservation extends Model
{

    protected $fillable = ['user_id' , 'event_id' , 'seats'];


    public function user(){
        $this->belongsTo(User::class , 'user_id');
    }


    public function event(){
        return $this->belongsTo(Event::class);
    }

    
    public function scopeMineOrAll(Builder $query){
    $user = auth()->user();

    if ($user->hasRole(['admin', 'organizer'])) {
        return $query;
    }
    return $query->where('user_id', $user->id);
    }
}
