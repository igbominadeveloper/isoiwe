<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $primaryKey = 'unique_id';

    protected $fillable = [
        'full_name','email'
    ];

    public function books(){
        return $this->hasMany(Book::class);
    }

    public function getUniqueIdAttribute($value){
        return $unique_id = $value;
    }

    public function setUniqueIdAttribute($date){
        $unique_id = str_random(6).'-'.$date.'-'.str_random(6);
        return $this->attributes['unique_id'] = $unique_id;
    }
}
