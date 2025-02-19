<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

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
Route::get('/', [ListingController::class, 'index'])->name('welcome');


// Show Create Form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

// Store a New Listing
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');


// Show Edit Form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

// Update a Listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->name('listings.update')->middleware('auth');

// Manage Listings
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

// Single Listings
Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listings.show');


// Delete a Listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->name('listings.delete')->middleware('auth');

// Show Register/Create Form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');


// Create New User
Route::post('/users', [UserController::class, 'store']);

// Log User Out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// Show Login Form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// Log In User
Route::post('/users/authenticate', [UserController::class, 'authenticate']);
