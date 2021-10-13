<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'invcode',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile(){
        return $this->hasOne(Profile::class);
    }

    // public function image()
    // {
    //     return DB::table('profiles')->where('user_id', $this->id)->value('image');
    // }

        
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function hasRole($role)
    {
        $plucked = $this->roles->pluck('name');
        return in_array($role, $plucked->all());   
    }

    public function isAdmin()
    {
        return $this->hasRole('Admin');
    }

    public function isModerator()
    {
        return $this->hasRole('Moderator');
    }

    public function isEmployee()
    {
        return ($this->isAdmin() || $this->isModerator());
    }

}
