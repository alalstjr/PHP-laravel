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

// BlogController
Route::get('/blog/create', 'BlogController@create')->name('blogs.create');
Route::post('/blog/store', 'BlogController@store')->name('blogs.store');
Route::get('/blog/{id}', 'BlogController@show')->name('blogs.show');

// CommentController
Route::post('/comments', 'CommentController@store')->name('comments.store');

// ProfileController
Route::get('/users/{id}', 'ProfileController@show')->name('user.profile.show');

// PostController
Route::get('/post/create', 'PostController@create')->name('posts.create');
Route::post('/posts', 'PostController@store')->name('posts.store');
