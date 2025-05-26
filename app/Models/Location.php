<?php

namespace App\Models;

use App\Models\Event;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['name' , 'address' , 'city' , 'country'];

    public function events(){
        return $this->hasMany(Event::class);
    }

    public function images(){
        return $this->morphMany(Image::class, 'imageable');
    }

    public function LatestImage(){
        $this->morphOne(Image::class , 'imageable')->latestOfMany();
    }

    
}
