<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// FlightController
Route::get("/flight/create", "FlightController@create")->name("flights.craete");
Route::post("/flight/store", "FlightController@store")->name("flights.store");

// Profile
Route::get("/users/{id}", "ProfileController@show")->name("user.profile.show");

// PostController
Route::get("/post/create", "PostController@create")->name("posts.create");
Route::post("/post/store", "PostController@store")->name("posts.store");
