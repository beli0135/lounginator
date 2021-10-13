<?php

namespace App\Http\Controllers;

use App\Models\ArticleComment;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Hashtag;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
 
//use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except' => []]);
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
            ' OR posts.user_id not in (select URR_CdiUser from user_relations where URR_CdiUserRelated = '.$user_id.' and URR_isBlocked = 1 ))' . 
            $nsfwWhere . ' and posts.article is not null';

        $posts = Post::select('posts.*')
        ->whereRaw($whr)
        ->orderBy('posts.updated_at','DESC')
        ->limit(300)
        ->paginate($perPage);
    
        return view('posts.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:5',
            'article-textarea' => 'required',
            'cvrimg' => 'mimes:jpg,png,jpeg|max:5048',
        ]);
       
        $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        $imagePath = '';
        if ($request->cvrimg != null) 
        {
            $imagePath = $request->cvrimg->store('uploads','public');
        }    

        

        if ($request->input('nsfw') == null) {
           $nsfw = false;
        } else {
            $nsfw = true;
        }

        if ($request->input('tweet') == null) {
            $tweet = '';
         } else {
            $tweet = __('lang.tweetMessage') . 
                '<a href="'. env('APP_URL') . '/posts/' . $slug . 
                    '"><font color="green">&rarr; here</font></a>&nbsp; <br> <font color="blue"><a href="/tweets/h/article">#article</a></font>';
            if ($nsfw == true) {
                $tweet .= ' <font color="blue"><a href="/tweets/h/nsfw">#nsfw</a></font> ';
            }
         }

         $post = array(
            'title' => $request->input('title'),
            'article' => $request->input('article-textarea'),
            'slug' => $slug,
            'nsfw' => $nsfw,
            'user_id' => auth()->user()->id,
        );

        if ($tweet != ''){
            $post['tweet'] = $tweet; 
        }
        
        if ($imagePath != '') {
            $post['image_path'] = $imagePath;
        }
        $pst = Post::create($post);

        if ($tweet != ''){
            $hashtag = array('HTG_post_id' => $pst->id, 'HTG_hashtag' => 'article');
            Hashtag::create($hashtag);
            if ($nsfw == true){
                $hashtag = array('HTG_post_id' => $pst->id, 'HTG_hashtag' => 'nsfw');
                Hashtag::create($hashtag);
            }
        }
        
        return redirect('/posts');//->with('message',__('lang.postadded'));
    }

    /**
     * Display the specified resource.
     *
     * @param  str slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        return view('posts.show')->with('post', Post::where('slug', $slug)->first());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        return view('posts.edit')->with('post', Post::where('slug',$slug)->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $request->validate([
            'title' => 'required|min:5',
            'article-textarea' => 'required',
            'cvrimg' => 'mimes:jpg,png,jpeg|max:5048',
        ]);
       
        
        $imagePath = '';
        if ($request->cvrimg != null) 
        {
            $imagePath = $request->cvrimg->store('uploads','public');
        }    
        if ($request->input('nsfw') == null) {
           $nsfw = false;
        } else {
            $nsfw = true;
        }


         $post = array(
            'title' => $request->input('title'),
            'article' => $request->input('article-textarea'),
            'nsfw' => $nsfw,
        );
        
        if ($imagePath != '') {
            $post['image_path'] = $imagePath;
        }

        Post::where('slug', $slug)->update($post);
        
        return redirect('/posts/'. $slug);//->with('message',__('lang.postadded'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $post = Post::where('slug', $slug);
        $image = DB::table('posts')->where('slug', $slug)->value('image_path');
        if ($image != '') {
            Storage::delete('/public/' . $image);
        }
        $post->delete();

        return redirect('/posts');
    }

    public function createArticleComment(Request $request)
    {
        $request->validate([
            'Tweet_body' => 'required|min:3',
            'cvrimg' => 'mimes:jpg,png,jpeg|max:2048',
        ]);

        $post_id = $request->post_id;
        $user_id = auth()->user()->id;
        $user_username = DB::table('users')->where('id',$user_id)->value('username');
        $user_name = DB::table('users')->where('id',$user_id)->value('name');
        $user_profile_pic = DB::table('profiles')->where('user_id',$user_id)->value('image');

        $comment = $request->Tweet_body;

        if ($request->isNSFW == null) {
            $nsfw = false;
        } else {
            $nsfw = true;
        }

        $imagePath = '';
        if ($request->cvrimg != null) 
        {
            $imagePath = $request->cvrimg->store('uploads','public');
        }

        $AComment = array(
            'ACM_cdiPost' => $post_id,
            'ACM_dssUsername' => $user_username,
            'ACM_dssUserFullName' => $user_name,
            'ACM_dssProfileImage' => $user_profile_pic,
            'ACM_dssComment' => $comment,
            'ACM_nsfw' => $nsfw,
            'ACM_created_at' => now(),
            'ACM_updated_at' => now(),
           
        );

        if ($imagePath != '') {
            $AComment['ACM_image_path'] = $imagePath;
        }

        ArticleComment::create($AComment);

        return redirect()->back()->with('message',__('lang.commented'));
    }

    


}
