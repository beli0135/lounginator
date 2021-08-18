<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio',
        'url',
        'location',
        'birthday',
        'image',
        'nsfw',
    ];

    public function followers()
    {
      return $this->belongsToMany(User::class);
    }

    public function showNSFW()
    {
      return $this->nsfw;
    }

    

}
