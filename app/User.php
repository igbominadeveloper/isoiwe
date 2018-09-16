<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $primaryKey = 'unique_id';


    public function books(){
        return $this->hasMany(Book::class);
    }

    public function authors(){
        return $this->hasMany(Author::class);
    }

    public function setUniqueIdAttribute($date){

        $unique_id = str_random(6).'-'.$date.'-'.str_random(6);

        return $this->attributes['unique_id'] = $unique_id;
    }

    public function getUniqueIdAttribute($value){
        return $value;
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     * Rating, Books
     */
    public function ratings(){
        return $this->hasManyThrough(Rating::class,Book::class);
    }
}
