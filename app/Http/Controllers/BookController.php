<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Resources\BooksResource;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BooksResource::collection(Book::all());
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
            'title' => 'required|unique',
            'description' => 'required',
            'user_id' => 'required',
            'author_id' => 'required'
        ]);

       $newBook = Book::create($request->all());

       if($newBook){
           return response(200)->toJson($newBook);
       }
       return ['error' => 'Book Creation Failed'];

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return $book;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        if ($book->update($request->all())){
            return response(200)->toJson(['message' => 'Data Updated','book' => $book]);
        }
        else{
            return ['error' => 'Update Failed'];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        if($book->delete()){
            return response()->toJson(['message' => 'Book Deleted']);
        }
        else{
            return response(500);
        }
    }
}
