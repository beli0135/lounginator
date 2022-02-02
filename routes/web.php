<?php

use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserController;
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

    //admin
    //Route::resource('/admin/user', UserController::class);
    Route::get('/admin/user/index', [UserController::class, 'index'])->name('admin.userindex');

    route::view('profile','profile')->name('profile');
    route::put('profile','App\Http\Controllers\ProfileController@store')->name('profile.update');
      

    //pages
    Route::get('/pages/index', [PagesController::class, 'index'])->name('pages.index');

    //posts

    Route::resource('/posts', PostsController::class);
    Route::post('createArticleComment',[PostsController::class, 'createArticleComment'])->name('createArticleComment');
    

    //tweets
    
    Route::get('/tweets/index', [TweetController::class, 'index'])->name('tweets.index');

    Route::get('/tweets/h/{param}', [TweetController::class, 'indexHashtag'])->name('tweets.indexHashtag');
    
    Route::post('1_tw_fav', [TweetController::class, 'makeUserFavorite'])->name('tweets.makeUserFavorite');
    Route::post('2_tw_mute', [TweetController::class, 'makeUserMute'])->name('tweets.makeUserMute');
    Route::post('3_tw_block', [TweetController::class, 'makeUserBlocked'])->name('tweets.makeUserBlocked');
    Route::post('4_tw_report', [TweetController::class, 'reportTweet'])->name('tweets.reportTweet');
    
    Route::post('createTweet',[TweetController::class, 'createTweet'])->name('createTweet');
    Route::post('deleteTweet',[TweetController::class, 'destroy'])->name('tweets.deleteTweet');
    Route::post('toggleLike',[TweetController::class, 'toggleLike'])->name('tweets.toggleLike');

    
});

require __DIR__.'/auth.php';

Route::get('/invitations/create', 'App\Http\Controllers\InvitationController@create');
Route::post('/invitations','App\Http\Controllers\InvitationController@store');

Route::post('/storage/imgs', [ImageController::class, 'store'])->name('images.store');