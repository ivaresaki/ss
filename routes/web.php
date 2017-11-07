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

/**
 * Routes for subdomains
 */
Route::group(['domain' => '{subdomain}.surgiscript.dev'], function(){
	Route::get('/', function () {
		return view('welcome');
	});

	Route::get('/home', 'HomeController@index')->name('home');

	Route::resource('posts', 'PostController');

	Auth::routes();
	// Route::get('login', 'Auth\LoginController@showLoginForm')->name('login')->middleware('guest');
 //    Route::post('login', 'Auth\LoginController@login')->middleware('guest');

 //    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register')->middleware('guest');
 //    Route::post('register', 'Auth\RegisterController@register')->middleware('guest');
});

/**
 * Routes for main site
 */
Route::group(['middleware' => ['auth']], function(){
	Route::get('signup', 'SiteRegistrationController@create')->name('signup.create');
	Route::post('signup', 'SiteRegistrationController@store')->name('signup.store');

	Route::get('registrations', 'SiteRegistrationController@index')->name('signup.index');

	Route::get('registrations/{registration}', 'SiteRegistrationController@show')->name('signup.show');

	Route::get('registrations/{registration}/approval', 'SiteRegistrationController@approval')
	->middleware(['role:admin'])
	->name('signup.approval');

	Route::post('registrations/{registration}/approve', 'SiteRegistrationController@approve')
	->middleware(['role:admin'])
	->name('signup.approve');

	Route::post('registrations/{registration}/reject', 'SiteRegistrationController@reject')
	->middleware(['role:admin'])
	->name('signup.reject');
});

Route::get('/', function () {
	return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();
