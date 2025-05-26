<?php

namespace App\Models;

use App\Models\Event;
use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    protected $fillable = ['name' , 'description'];

    public function events(){
        return $this->hasMany(Event::class);
    }
}
