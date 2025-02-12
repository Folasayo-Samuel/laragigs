<?php

use App\Http\Controllers\ListingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Listing;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/hello', function(){
//     return response('<h1>Hello World!</h1>', 200)
//     ->header('Content-Type', 'text/plain')
//     ->header('foo', 'bar');
// });

Route::get('/posts/{id}', function($id){
	dd($id);
	return response('Post ' . $id);
})->where('id', '[0-9]+');

Route::get('/search', function(Request $request){
 return $request->name . ' ' . $request->city;
});

// Route::get('/posts', function(){
//     return response()->json(
//         [
//         'post' => [
//             [
//             'title' => 'Post One'
//             ]
//         ]
//         ]);
// });

// All Listings
Route::get('/', [ListingController::class, 'index']);


// Show Create Form
Route::get('/listings/create', [ListingController::class, 'create']);

// Single Listings
Route::get('/listings/{listing}', [ListingController::class, 'show']);
