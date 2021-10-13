<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ArticleComment extends Model
{
    use HasFactory;

    protected $fillable = ['ACM_cdiPost','ACM_cdiOfComment',
        'ACM_dssUsername','ACM_dssUserFullName','ACM_dssComment',
        'ACM_cntGood','ACM_cntBad','ACM_nsfw',
        'created_at','updated_at','ACM_image_path','ACM_dssProfileImage'
    ];
     
    public function commentable()
    {
        return $this->morphTo();
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function comments()
    {
        return $this->morphMany(ArticleComment::class, 'commentable');
    }

    public function getPassedTime()
    {
        $diff = Carbon::parse($this->updated_at)->diffForHumans();
        return $diff;
    }

    
}
