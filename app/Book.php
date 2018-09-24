<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed ratings
 */
class Book extends Model
{
    protected $fillable = [
        'title','author_id','description','published_at','unique_id',
    ];

    protected $dates = [
        'published_at'
    ];

    protected $hidden = [
      'created_at','updated_at','rating_id','user_id','unique_id'
    ];

    public function ratings(){
        return $this->belongsToMany(Rating::class);
    }

    public function setUniqueIdAttribute($date){
        $unique_id = str_random(6).'-'.$date.'-'.str_random(6);
        return $this->attributes['unique_id'] = $unique_id;
    }

    public function getUniqueIdAttribute($value){
        return $unique_id = $value;
    }

    public function author(){
        return $this->belongsTo(Author::class);
    }

}
