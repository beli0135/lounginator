<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Hashtag;
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

    public function makeUserFavorite( request $request)
    {   
        $user_id = $request->user_id;
        $currentUser = auth()->user()->id;
        
        if ($user_id == $currentUser) {
            return redirect()->route('tweets.index')->with('error',__('yourpost'));
        }

        $record = DB::select('select URR_cdiUserRelation from user_relations where URR_CdiUser = ? and URR_CdiUserRelated = ?', [$currentUser,$user_id]);
        if (isset($record[0])){
            //dd($record[0]->URR_cdiUserRelation); //ovo je ID
            DB::statement('UPDATE user_relations SET URR_isFavorite = ?, URR_updated_at = ? where URR_CdiUser = ? and URR_CdiUserRelated = ? ',[true,now(),$currentUser,$user_id]);
        } else {
            DB::statement('INSERT INTO user_relations (URR_CdiUser,URR_CdiUserRelated,URR_isFavorite,URR_created_at,URR_updated_at) VALUES (?,?,?,?,?)',[$currentUser,$user_id,true,now(),now()]);
        }
        
        return redirect(route('tweets.index') . '#' . $request->id);
    }

    
}
