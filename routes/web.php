<?php

use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\TweetController;
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


    route::view('profile','profile')->name('profile');
    route::put('profile','App\Http\Controllers\ProfileController@store')->name('profile.update');
      

    //pages
    Route::get('/pages/index', [PagesController::class, 'index'])->name('pages.index');

    //posts

    Route::resource('/posts', PostsController::class);

    //tweets
    Route::get('/tweets/index', [TweetController::class, 'index'])->name('tweets.index');
    Route::get('/tweets/h/{param}', [TweetController::class, 'indexHashtag'])->name('tweets.indexHashtag');
    Route::post('/tweets/index}', [TweetController::class, 'makeUserFavorite'])->name('tweets.makeUserFavorite');

     

    
});

require __DIR__.'/auth.php';

Route::get('/invitations/create', 'App\Http\Controllers\InvitationController@create');
Route::post('/invitations','App\Http\Controllers\InvitationController@store');

Route::post('/storage/imgs', [ImageController::class, 'store'])->name('images.store');