<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Cviebrock\EloquentSluggable\Services\SlugService;
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
        $nsfw = auth()->user()->profile->showNSFW();

        if ($nsfw == 1) {
            $posts = POST::wherein('nsfw',[0,1])->orderBy('updated_at','DESC')->Paginate(25);
        } else {
            $posts = POST::where('nsfw','=',0)->orderBy('updated_at','DESC')->paginate(25);    
        }
        
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
                '<a href="'. $slug . '">here</a>&nbsp;'
            ;
         }

         $post = array(
            'title' => $request->input('title'),
            'article' => $request->input('article-textarea'),
            'slug' => $slug,
            'nsfw' => $nsfw,
            'tweet' => $tweet,
            'user_id' => auth()->user()->id,
        );
        
        if ($imagePath != '') {
            $array['image_path'] = $imagePath;
        }
        Post::create($post);
        
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
            $array['image_path'] = $imagePath;
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
        $post->delete();

        return redirect('/posts');
    }
}
