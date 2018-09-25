<?php

namespace App\Http\Controllers;

use App\BookRating;
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

        if($request->user()->ratesABook($book, $request)) {
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
