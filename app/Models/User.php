<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',       // ⬅️ tambahkan ini
        'profile_image',
        'description',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function following()
    {
        return $this->belongsToMany(
            User::class,
            'user_followers',
            'follower_id',
            'user_id'
        );
    }

    /**
     * Users that are following this user.
     */
    public function followers()
    {
        return $this->belongsToMany(
            User::class,
            'user_followers',
            'user_id',
            'follower_id'
        );
    }

    public function reportsMade()
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    public function reportsReceived()
    {
        return $this->hasMany(Report::class, 'reported_user_id');
    }

    public function warnings()
    {
        return $this->hasMany(Warning::class, 'user_id');
    }

    public function warningsGiven()
    {
        return $this->hasMany(Warning::class, 'admin_id');
    }

    public function bans()
    {
        return $this->hasMany(Ban::class, 'user_id');
    }

    public function bansGiven()
    {
        return $this->hasMany(Ban::class, 'admin_id');
    }

    public function appeals()
    {
        return $this->hasMany(Appeal::class, 'user_id');
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
