<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Symfony\Component\HttpFoundation\Response;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

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
        'password', 'remember_token','created_at','updated_at','email_verified_at','unique_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * Books created by a user
     */
    public function books(){
        return $this->hasMany(Book::class);
    }

    public function authors(){
        return $this->hasMany(Author::class);
    }

    public static function getUniqueIdAttribute(){
        return $unique_id = str_random(6).'-'.date('Y-m-d').'-'.str_random(6);
    }

    public function addBookToLibrary($book){
        $this->books()->save($book);
        return response()->json([
            'message' => $book
        ], Response::HTTP_OK);
    }

    public function updatesBook($data, $book){

        $book->update($data);

        return response()->json([
            'message' => $book
        ], Response::HTTP_OK);
    }

    public function ratesABook($book, $rating){
        if($book->ratings()->save($rating))
            return true;
        return false;
    }

    public function deletesABook($book){

       $this->books()->delete($book);

       return true;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     * Rating, Books
     */
    public function ratings(){
        return $this->hasMany(Rating::class);
    }
}
