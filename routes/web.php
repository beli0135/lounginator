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

Route::group(['middleware' => 'auth'], function() {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    //training profiles
    route::view('profile','profile')->name('profile');
    route::put('profile','App\Http\Controllers\ProfileController@store')->name('profile.update');
      
});

require __DIR__.'/auth.php';

Route::get('/invitations/create', 'App\Http\Controllers\InvitationController@create');
Route::post('/invitations','App\Http\Controllers\InvitationController@store');