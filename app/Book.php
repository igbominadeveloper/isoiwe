<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title','author','description','published_at'
    ];

    protected $dates = [
        'published_at'
    ];

    protected $primaryKey = 'unique_id';

    public function rating(){
        return $this->hasOne(Rating::class);
    }

    public function setUniqueIdAttribute($date){
        $unique_id = str_random(6).'-'.$date.'-'.str_random(6);
        return $this->attributes['unique_id'] = $unique_id;
    }

    public function getUniqueIdAttribute($value){
        return $unique_id = $value;
    }

    public function setRatingAttribute(){
//        $current_rating = $this->rating()->rating;
//
//        $new_rating = $current_rating
    }

    public function author(){
        return $this->hasOne(Author::class);
    }
}
