<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function books(){
        return $this->belongsToMany(Book::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }
}

// select ratings of a book
// load the users who gave the ratings