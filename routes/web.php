<?php

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

Route::get('/', 'Auth\LoginController@home');

//Auctions
Route::get('auctions', 'AuctionController@showCreateForm');
Route::post('auctions', 'AuctionController@create') ->name('auctions');
Route::get('auctions/{id}/edit', 'AuctionController@showEditForm')->name('edit_auction');
Route::put('auctions/{id}/edit', 'AuctionController@update')->name('edit_auction');
Route::get('auctions/{id}', 'AuctionController@show')->name('view_auction');
Route::delete('auctions/{id}', 'AuctionController@delete')->name('delete_auction');
Route::post('auctions/{id}/bids/{id_user}', 'BidController@create')->name('create_bid');

//Views
Route::get('homepage','HomepageController@show')->name('homepage');
Route::view('about', 'pages.about');

// API
Route::delete('api/images/{id}', 'ImageController@delete');


// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::get('recover', 'Auth\LoginController@showRecoverForm')->name('recover');
Route::post('recover', 'Auth\LoginController@recover');
