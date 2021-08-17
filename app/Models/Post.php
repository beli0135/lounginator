<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Cviebrock\EloquentSluggable\Sluggable;

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
    ];    

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
        return $this->belongsTo(User::class);
    }

    public function sluggable():array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
