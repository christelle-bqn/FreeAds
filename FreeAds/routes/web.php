<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

/* 
Route::get('/index', function () {
    return view('index');
}); */

/* Route::get('/', 'IndexController@welcome');
Route::get('/index', 'IndexController@showIndex'); */

Route::get('/', 'IndexController@welcome');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('users/{id}/advertisements', 'AdvertisementController@showUser')->name('advertisements.user');

Route::get('/advertisements/index/{params?}/', 'AdvertisementController@index')->name('advertisements.index');

Route::get('/users/{user}', 'UserController@store')->name('user.store');

Route::post('/advertisements/index/{params?}/', 'AdvertisementController@index')->name('advertisements.index');

Route::post('/advertisements/filter', 'AdvertisementController@filterAds')->name('advertisements.filter');

Route::resource('users', 'UserController');

Route::middleware('auth')->group(function () {
    Route::get('/users', 'UserController@index');
    Route::get('/users/{user}', 'UserController@show');
    Route::put('/users/{user}', 'UserController@update');
    Route::delete('/users/{user}', 'UserController@destroy');
    Route::get('/users/{user}/edit', 'UserController@edit');
});

Route::resource('advertisements', 'AdvertisementController');

Route::middleware('auth')->group(function () {
    Route::get('/advertisements', 'AdvertisementController@index');
    Route::get('/advertisements/{advertisement}', 'AdvertisementController@show');
    Route::put('/advertisements/{advertisement}', 'AdvertisementController@update');
    Route::delete('/advertisements/{advertisement}', 'AdvertisementController@destroy');
    Route::get('/advertisements/{advertisement}/edit', 'AdvertisementController@edit');
});
