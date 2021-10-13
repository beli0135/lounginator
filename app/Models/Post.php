<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Cviebrock\EloquentSluggable\Sluggable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, Sluggable;

    protected  $fillable = [
        'slug',
        'tweet',
        'title',
        'article',
        'image_path',
        'nsfw',
        'user_id',
        'thread_id',
    ];    

    public function hashtags()
    {
        return $this->hasMany(Hashtag::class);
    }

    public function tweetlikes()
    {
        return $this->hasMany(Hashtag::class);
    }

    public function articleComments()
    {   
        $user_id = auth()->user()->id;
        $nsfwWhere = '';

        if (env('CUSTOM_NSFW_EXISTS') == true) { 
            $nsfw = auth()->user()->profile->showNSFW();
            $nsfwWhere = '';
            if ($nsfw == 1) {
                $nsfwWhere = ' AND ACM_nsfw in (0,1)';
            } else {
                $nsfwWhere = ' AND ACM_nsfw = 0';
            }
        }   
        $whr = 'ACM_cdiPost not in (select URR_CdiUserRelated from user_relations where URR_CdiUser = '.$user_id.' and (URR_isMuted = 1 or URR_isBlocked = 1)) '. $nsfwWhere;
        
        //$comments = DB::table('article_comments')->whereRaw($whr)->orderBy('updated_at','DESC');
        return $this->hasMany(ArticleComment::class,'ACM_cdiPost','id')->orderBy('updated_at','DESC');
    }

    public function getCoverImagePath()
    {
        $path = public_path() . '/' . $this->image_path;
        
        return $path;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
              ->width(600);
    }

    public function shortTitle()
    {
        if (strlen($this->title) > 37)
        {
            return substr($this->title,0,37) . '...';
        } else {
            return $this->title;
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sluggable():array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function getPassedTime()
    {
        $diff = Carbon::parse($this->updated_at)->diffForHumans();
        return $diff;
    }

    public function articleCommentCount()
    {
        return ArticleComment::all()->where('ACM_cdiPost','=',$this->id) ->count();
    }

    public function tweetLikeCount()
    {
        return Tweetlikes::all()->where('TWL_cdiPost','=',$this->id)->count();
    }

    public function tweetHasYourLike()
    {
        return Tweetlikes::all()
            ->where('TWL_cdiPost','=',$this->id)
            ->where('TWL_cdiUser','=',auth()->user()->id)
            ->count();
    }
}
