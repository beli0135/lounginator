<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Hashtag;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class TweetController extends Controller
{
    public function index()
    {
        $perPage = env('CUSTOM_TWEETS_PER_PAGE');

        if (env('CUSTOM_NSFW_EXISTS') == true) { 
            $nsfw = auth()->user()->profile->showNSFW();
            if ($nsfw == 1) {
                $posts = POST::wherein('nsfw',[0,1])->orderBy('updated_at','DESC')->Paginate($perPage);
            } else {
                $posts = POST::where('nsfw','=',0)->orderBy('updated_at','DESC')->paginate($perPage);    
            }
        } else {
            $posts = POST::where('nsfw','=',0)->orderBy('updated_at','DESC')->paginate($perPage);    
        }
    
        return view('tweets.index')->with('posts',$posts);
    }

    public function indexHashtag($hashtag)
    {
        $perPage = env('CUSTOM_TWEETS_PER_PAGE'); 
            
        $posts = Post::select('posts.*')
            ->join('hashtags','hashtags.HTG_post_id','=','posts.id')
            ->where('hashtags.HTG_hashtag','=',$hashtag)
            ->paginate($perPage);
       
        return view('tweets.index')->with('posts',$posts);    
    }

    public function makeUserFavorite($postId)
    {   
        
    }

    
}
