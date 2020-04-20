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

// Cards
Route::get('cards', 'CardController@list');
Route::get('cards/{id}', 'CardController@show');

//Auctions
Route::get('auctions/create', 'AuctionController@showCreateForm');
Route::post('auctions/create', 'AuctionController@create') ->name('auctions');
Route::get('auctions/{id}/edit', 'AuctionController@showEditForm')->name('edit_auction');
Route::put('auctions/{id}/edit', 'AuctionController@update')->name('edit_auction');
Route::get('auctions/{id}', 'AuctionController@show')->name('view_auction');
Route::delete('auctions/{id}', 'AuctionController@delete')->name('delete_auction');
Route::delete('api/images/{id}', 'ImageController@delete');
//Views
Route::get('homepage','HomepageController@show');
Route::view('about', 'pages.about');

// API
Route::put('api/cards', 'CardController@create');
Route::delete('api/cards/{card_id}', 'CardController@delete');
Route::put('api/cards/{card_id}/', 'ItemController@create');
Route::post('api/item/{id}', 'ItemController@update');
Route::delete('api/item/{id}', 'ItemController@delete');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
