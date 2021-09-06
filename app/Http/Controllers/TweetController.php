<?php

namespace App\Http\Controllers;

use App\Models\Hashtag;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class TweetController extends Controller
{
    public function index()
    {
        $perPage = env('CUSTOM_TWEETS_PER_PAGE');
        $user_id = auth()->user()->id;
        $nsfwWhere = '';

        if (env('CUSTOM_NSFW_EXISTS') == true) { 
            $nsfw = auth()->user()->profile->showNSFW();
            $nsfwWhere = '';
            if ($nsfw == 1) {
                $nsfwWhere = ' AND posts.nsfw in (0,1)';
            } else {
                $nsfwWhere = ' AND posts.nsfw = 0';
            }
        }   
        
        $whr =  '(posts.user_id not in (select URR_CdiUserRelated from user_relations where URR_CdiUser = '.$user_id.' and (URR_isMuted = 1 or URR_isBlocked = 1)) ' . 
        ' OR posts.user_id not in (select URR_CdiUser from user_relations where URR_CdiUserRelated = '.$user_id.' and URR_isBlocked = 1 ))' .$nsfwWhere;

        $posts = Post::select('posts.*')
        ->whereRaw($whr)
        ->orderBy('posts.updated_at','DESC')
        ->limit(300)
        ->paginate($perPage);
        
        return view('tweets.index')->with('posts',$posts);
    }

    public function indexHashtag($hashtag)
    {
        $perPage = env('CUSTOM_TWEETS_PER_PAGE'); 
            
        $posts = Post::select('posts.*')
            ->join('hashtags','hashtags.HTG_post_id','=','posts.id')
            ->where('hashtags.HTG_hashtag','=',$hashtag)
            ->limit(300)
            ->paginate($perPage);
       
        return view('tweets.index')->with('posts',$posts);    
    }

    public function makeUserFavorite( request $request)
    {   
        $user_id = $request->user_id;
        $currentUser = auth()->user()->id;
        
        if ($user_id == $currentUser) {
            return redirect()->back()->with('error',__('yourpost'));
        }

        $record = DB::select('select URR_cdiUserRelation from user_relations where URR_CdiUser = ? and URR_CdiUserRelated = ?', [$currentUser,$user_id]);
        if (isset($record[0])){
            DB::statement('UPDATE user_relations SET URR_isFavorite = ?, URR_updated_at = ? where URR_CdiUser = ? and URR_CdiUserRelated = ? ',[true,now(),$currentUser,$user_id]);
        } else {
            DB::statement('INSERT INTO user_relations (URR_CdiUser,URR_CdiUserRelated,URR_isFavorite,URR_created_at,URR_updated_at) VALUES (?,?,?,?,?)',[$currentUser,$user_id,true,now(),now()]);
        }
        
        return redirect(route('tweets.index') . '#' . $request->id);
    }

    public function makeUserMute( request $request)
    {   
        $user_id = $request->user_id;
        $currentUser = auth()->user()->id;
        
        if ($user_id == $currentUser) {
            return redirect()->back()->with('error',__('yourpost'));
        }

        $record = DB::select('select URR_cdiUserRelation from user_relations where URR_CdiUser = ? and URR_CdiUserRelated = ?', [$currentUser,$user_id]);
        if (isset($record[0])){
            DB::statement('UPDATE user_relations SET URR_isMuted = ?, URR_updated_at = ? where URR_CdiUser = ? and URR_CdiUserRelated = ? ',[true,now(),$currentUser,$user_id]);
        } else {
            DB::statement('INSERT INTO user_relations (URR_CdiUser,URR_CdiUserRelated,URR_isMuted,URR_created_at,URR_updated_at) VALUES (?,?,?,?,?)',[$currentUser,$user_id,true,now(),now()]);
        }
        
        return redirect(route('tweets.index') . '#' . $request->id);
    }    

    public function makeUserBlocked( request $request)
    {   
        $user_id = $request->user_id;
        $currentUser = auth()->user()->id;
        
        if ($user_id == $currentUser) {
            return redirect()->back()->with('error',__('yourpost'));
        }

        $record = DB::select('select URR_cdiUserRelation from user_relations where URR_CdiUser = ? and URR_CdiUserRelated = ?', [$currentUser,$user_id]);
        if (isset($record[0])){
            DB::statement('UPDATE user_relations SET URR_isBlocked = ?, URR_updated_at = ? where URR_CdiUser = ? and URR_CdiUserRelated = ? ',[true,now(),$currentUser,$user_id]);
        } else {
            DB::statement('INSERT INTO user_relations (URR_CdiUser,URR_CdiUserRelated,URR_isBlocked,URR_created_at,URR_updated_at) VALUES (?,?,?,?,?)',[$currentUser,$user_id,true,now(),now()]);
        }
        
        return redirect(route('tweets.index') . '#' . $request->id);
    }

    public function reportTweet(request $request)
    {
        $user_id = $request->user_id;
        $currentUser = auth()->user()->id;

        if ($user_id == $currentUser) {
            return redirect()->route('tweets.index')->with('error',__('yourpost'));
        }

        $record = DB::select('select * from reported_tweets where RTW_cdiUserReporting = ? and RTW_cdiUserReported = ? and RTW_cdiPost = ?', [$currentUser,$user_id,$request->id]);
        if (!isset($record[0])){
            DB::Statement('INSERT INTO reported_tweets (RTW_cdiUserReporting,RTW_cdiUserReported,RTW_cdiPost,RTW_created_at,RTW_updated_at) '.
            'VALUES (?,?,?,?,?)',[$currentUser,$user_id,$request->id,now(),now()]);
        }

        return redirect()->back()->with('message','Tweet reported');
    }

    public function createTweet(Request $request)
    {
        $request->validate([
            'Tweet_body' => 'required|min:10',
            'cvrimg' => 'mimes:jpg,png,jpeg|max:2048',
        ]);

        $inTweet = $request->Tweet_body;
        $words = explode(' ',$inTweet);

        if ($request->input('isNSFW') == null) {
            $nsfw = false;
         } else {
             $nsfw = true;
         }

       
        $i=-1;
        $h_nsfw = false;
        $hashtags = array();

        foreach ($words as $word) {
            $i++;
            if (strlen($word) < 2 ) {continue;};
            $lwcWrd = strtolower($word);
            if  ($word[0] == '#') {
                if ($lwcWrd == '#nsfw'){
                    $h_nsfw = true;
                }

                $newword = str_replace('#','',$word);
                array_push($hashtags,$newword);

                $words[$i] = '<font color="blue"><a href="/tweets/h/"'.$newword.'>#'.$newword.'</a></font>';
            }
            if (strpos($lwcWrd,'http') !== false) {
                $newword = '<font color="blue"><a href="'.$word.'">'.$word.'</a></font>';
                $words[$i] = $newword;
            }

        }
        if (($h_nsfw == false) && ($nsfw == true)) {
            array_push($words,'#nsfw'); 
        }

        $tweet = implode(' ',$words);

        $imagePath = '';
        if ($request->cvrimg != null) 
        {
            $imagePath = $request->cvrimg->store('uploads','public');
        }
        
        // if ($imagePath != '') {
        //     $tweet = $tweet . '<br> <a href="'. env('APP_URL') . '/storage/' . $imagePath . '"><font color="blue">&rarr; image</font></a>'; 
            
        // }

        $post = array(
            'title' => '',
            'article' => '',
            'slug' => '',
            'nsfw' => $nsfw,
            'tweet' => $tweet,
            'image_path' => $imagePath,
            'user_id' => auth()->user()->id,
        );
        $pst = Post::create($post);

        foreach ($hashtags as $hshStr) {
            $hashtag = array('HTG_post_id' => $pst->id, 'HTG_hashtag' => $hshStr);
            Hashtag::create($hashtag);
        }

        return redirect()->back()->with('message','Tweeted');
    }
}
