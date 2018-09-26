<?php

namespace App\Http\Controllers;

use App\BookRating;
use App\Exceptions\NotResourceOwnerException;
use App\Http\Resources\BooksResource;
use App\Http\Resources\RatingResource;
use App\Rating;
use App\Book;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
        return RatingResource::collection($book->ratings->load('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Book $book)
    {
        $this->validate($request, [
            'star' => 'required | integer',
            'comment' => 'required | string'
        ]);
        $rating = new Rating();
        $rating->user_id = $request->user()->id;
        $rating->book_id = $book;
        $rating->comment = $request->comment;
        $rating->star = $request->star;

        if($request->user()->ratesABook($book, $rating)) {
            return response()->json([
                'response' => "Book Rating successful"
            ], Response::HTTP_CREATED);
        }
        else{
            return response()->json([
                'errors' => "Book rating failed"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book, Request $request)
    {
        return $request->all();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Rating $rating
     * @param  \App\Book $book
     * @return \Illuminate\Http\Response
     */
    public function update(Book $book, Rating $rating, Request $request)
    {
        return $book;

        $rating = $request->user()->ratings()->where('book_id',$book->id)->first();

        $rating->update($request->all());

        return response()->json([
            'response' => 'Rating Updated'
        ],Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rating  $rating
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book, Rating $rating, Request $request)
    {
        $rating = $request->user()->ratings()->where('book_id',$book->id)->first();
        if($rating->delete())
            return response()->json(null,Response::HTTP_NO_CONTENT);
    }
}
