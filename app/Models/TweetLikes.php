<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TweetLikes extends Model
{
    use HasFactory;

    protected $fillable = ['TWL_cdiPost','TWL_cdiUser'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }



    
}
