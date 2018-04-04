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



Auth::routes();

Route::middleware('auth')->middleware('checkAccessToken')->group(function() {

  Route::get('/home', function () {
      return redirect()->route('home');
  });
  Route::get('/', 'HomeController@index')->name('home');
  Route::get('/follows', 'HomeController@follows')->name('follows');
  Route::get('/profile', 'HomeController@profile')->name('profile');
  Route::get('/person/{id}/profile', 'HomeController@person')->name('person_profile');
  Route::get('/locations', 'HomeController@locations')->name('locations');
  Route::get('/location/{id}/medias', 'HomeController@locationMedias')->name('location_medias');
});

Route::get('/redirect/auth', 'HomeController@redirectToAuth')->name('redirect_auth');
Route::get('/autenticationserver', 'HomeController@autenticationServer')->name('autentication');
