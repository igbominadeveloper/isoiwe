<?php

namespace App\Http\Controllers;

use App\Book;
use App\BookRating;
use App\Http\Requests\CreateBookForm;
use App\Http\Resources\BooksResource;
use App\Http\Resources\BookCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{

    /**
     * BookController constructor.
     * @param $user
     * @param $middleware
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except('index','show');
    }



    /*
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BookCollection::collection(Book::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBookForm $request)
    {

        $new_book = new Book();

        $new_book->title = $request->title;
        $new_book->description = $request->description;
        $new_book->author_id = $request->author_id;
        $new_book->published_at = $request->published_at;

        $new_book->unique_id = $request->user()->getUniqueIdAttribute();


        if($request->user()->addBookToLibrary($new_book)){
           return response([
               'data' => new BooksResource($new_book)
           ], 201);
       }

       return response()->json(['error' => 'Book Creation Failed'],500);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return new BooksResource($book);
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
        $this->validate($request,[
           'title' => 'unique:books'
        ]);

        if($request->user()->updatesBook($request->all(),$book)){
            return response([
                'data' => new BooksResource($book)
            ], 200);
        }
        else{
            return response([
                'error' => 'Update Failed'
            ], 500)->json();
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
        if(request()->user()->deletesAbook($book))
            return response([
                'message' => 'Book Deleted'
            ], 200);
        else
            return response("error", 500);
    }
}
