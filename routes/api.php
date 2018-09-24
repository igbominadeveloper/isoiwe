<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/books', 'BookController');

Route::group(['prefix' => '/books/{book}'], function (){
    Route::apiResource('ratings','RatingController');
});