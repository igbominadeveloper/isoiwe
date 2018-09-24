<?php

namespace App\Http\Controllers;

use App\BookRating;
use App\Http\Resources\BooksResource;
use App\Http\Resources\RatingResource;
use App\Rating;
use App\Book;
use App\User;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * RatingController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except('index','show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Book $book)
    {
        return RatingResource::collection($book->ratings()->withPivot('user_id')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'book_id' => 'required | integer',
            'rating_id' => 'required | integer'
        ]);

         $rating_id = $request->rating_id;

         $rating = Rating::find($rating_id);

        if (!empty($request)) {
            $book = Book::findOrFail($request->book_id);
        }

        if(auth()->user()->ratesABook($book, $rating))
            return response(new BooksResource($book));
        else
            return response()->json([
                'error' => 'Book rating failed'
            ], 500);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function show(Rating $rating)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rating $rating)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rating $rating)
    {
        //
    }
}
