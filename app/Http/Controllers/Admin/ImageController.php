<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function store (Request $request)
    {   
        $post = new Post();
        $post->id = 0;
        $post->exists = true;
        $image = $post->addMediaFromRequest('upload')->toMediaCollection('images');
        return response()->json([
            'url' => $image->getUrl('thumb')
        ]);
    }
}
