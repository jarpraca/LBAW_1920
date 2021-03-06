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

// Auctions
Route::get('auctions/search', 'AuctionController@search')->name('search');
Route::get('auctions', 'AuctionController@showCreateForm')->name('create_auction');
Route::post('auctions', 'AuctionController@create')->name('auctions');
Route::get('auctions/{id}/edit', 'AuctionController@showEditForm')->name('edit_auction');
Route::put('auctions/{id}/edit', 'AuctionController@update')->name('edit_auction');
Route::get('auctions/{id}', 'AuctionController@show')->name('view_auction');
Route::delete('auctions/{id}', 'AuctionController@delete')->name('delete_auction');
Route::post('auctions/{id}/bids/{id_user}/auto', 'BidController@auto')->name('auto_bid');
Route::put('auctions/{id}/stop', 'AuctionController@stop')->name('stop_auction');

// Profiles
Route::get('profiles/{id}', 'UserController@show')->name('profiles');
Route::delete('profiles/{id}', 'UserController@delete')->name('delete_profile');
Route::get('profiles/{id}/edit', 'UserController@showEditForm')->name('edit_profile');
Route::put('profiles/{id}/edit', 'UserController@update')->name('edit_profile');

// Views
Route::get('homepage', 'HomepageController@show')->name('homepage');
Route::view('about', 'pages.about');
Route::view('help', 'pages.help');


// API
Route::post('api/auctions/{id}/bids/{id_user}', 'BidController@create')->name('create_bid');
Route::delete('api/images/{id}', 'ImageController@delete');
Route::put('api/reports/{id}/{decision}', 'AdminController@updateReportStatus');
Route::get('api/reports', 'AdminController@indexReports');
Route::get('api/users', 'AdminController@indexUsers');
Route::post('api/users/{id}/block', 'AdminController@block');
Route::post('api/users/{id}/unblock', 'AdminController@unblock');
Route::delete('api/users/{id}', 'AdminController@delete');
Route::put('api/auctions/{id}/choose_methods', 'AuctionController@choose_methods');
Route::post('api/watchlists/{id_auction}', 'AuctionController@addWatchlist');
Route::delete('api/watchlists/{id_auction}', 'AuctionController@removeWatchlist');
Route::put('api/rates/{id}', 'AuctionController@rate');
Route::delete('api/users/{id}/image', 'UserController@deletePhoto');
Route::post('api/auctions/{id}/report', 'AuctionController@addReport');
Route::get('api/auctions/{id}/biddingHistory', 'AuctionController@biddingHistory');
Route::get('api/auctions/{id}/topBids', 'AuctionController@topBids');
Route::get('api/profiles/{id}/notifications', 'UserController@showNotifications');
Route::get('api/profiles/{id}/notif_count', 'UserController@hasUnreadNotifications');
Route::put('api/notifications/{id}/read', 'UserController@markRead');

// Admin
Route::get('admin', 'AdminController@show')->name('admin');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallBack');

Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::get('recover', 'Auth\LoginController@showRecoverForm')->name('recover');
Route::post('recover', 'Auth\LoginController@recover');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
