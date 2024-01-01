<?php

namespace App\Models;

use App\Models\Railway\RailwayBonus;
use App\Models\Social\Event;
use App\Models\Social\Follow;
use App\Models\Social\Post;
use App\Models\Social\PostComment;
use App\Models\Wiki\Wiki;
use Creativeorange\Gravatar\Facades\Gravatar;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use IvanoMatteo\LaravelDeviceTracking\Traits\UseDevices;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Passport\HasApiTokens;
use NotificationChannels\WebPush\HasPushSubscriptions;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, UseDevices, TwoFactorAuthenticatable, HasPushSubscriptions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'admin',
        'uuid',
        'avatar'
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
        'password' => 'hashed',
    ];

    public function logs()
    {
        return $this->hasMany(UserLog::class);
    }

    public function services()
    {
        return $this->hasMany(UserService::class);
    }

    public function social()
    {
        return $this->hasOne(UserProfil::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }

    public function wikis()
    {
        return $this->belongsToMany(Wiki::class, 'wiki_user', 'user_id', 'wiki_id');
    }

    public function following()
    {
        return $this->hasManyThrough(User::class, Follow::class,'user_id', 'id', 'id', 'following_id');
    }

    public function followers()
    {
        return $this->hasManyThrough(User::class, Follow::class, 'following_id', 'id', 'id', 'user_id');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'user_event', 'user_id', 'event_id');
    }

    public function bonuses()
    {
        return $this->belongsToMany(RailwayBonus::class, 'user_bonus', 'user_id', 'railway_bonus_id')
            ->withPivot('claimed_at')
            ->withTimestamps();
    }

    public function follow(User $user)
    {
        if(!$this->isFollowing($user)) {
            Follow::create([
                "user_id" => auth()->id(),
                "following_id" => $user->id
            ]);
        }
    }

    public function unfollow(User $user)
    {
        Follow::where('user_id', auth()->id())->where('following_id', $user->id)->delete();
    }

    public function isFollowing(User $user)
    {
        return $this->following()->where('users.id', $user->id)->exists();
    }

    public function getAvatarAttribute()
    {
        // TODO: A changer des le système connecter à internet
        if(connection_status() == 0) {
            if (\Storage::disk('public')->exists('/storage/avatars/'.$this->id.'.png')) {
                return asset('/storage/avatars/'.$this->id.'.png');
            } else {
                return asset('/storage/avatars/blank.png');
            }
        } else {
            return Gravatar::get($this->email);
        }
    }
}
