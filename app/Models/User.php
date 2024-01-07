<?php

namespace App\Models;

use App\Models\Railway\RailwayBonus;
use App\Models\Social\Event;
use App\Models\Social\Follow;
use App\Models\Social\Post;
use App\Models\Social\PostComment;
use App\Models\Support\Ticket\Ticket;
use App\Models\Support\Ticket\TicketResponse;
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
        'avatar',
        'status',
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

    protected $appends = [
        "token_tag",
        "status_label",
        "type_label",
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

    public function userRewards()
    {
        return $this->hasMany(UserRewards::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function ticketResponses()
    {
        return $this->hasMany(TicketResponse::class);
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

    public function getAvatarAttribute(): string
    {
        return Gravatar::get($this->email);
    }

    public function getTokenTagAttribute()
    {
        $explode = explode('-', $this->uuid);
        return \Str::upper($explode[4]);
    }

    public function getStatusFormat($style)
    {
        return match ($style) {
            'text' => match ($this->status) {
                "online" => "En ligne",
                "offline" => "Hors ligne",
                "busy" => "Occupé",
                "away" => "Absent",
                default => "Invisible"
            },
            'color' => match ($this->status) {
                "online" => "success",
                "offline" => "secondary",
                "busy" => "danger",
                "away" => "warning",
                default => "dark"
            },
            "icon" => match ($this->status) {
                "online" => "check-circle",
                "offline" => "circle",
                "busy" => "x-circle",
                "away" => "clock",
                default => "eye-slash"
            },
            default => null,
        };
    }

    public function getTypeFormat($style)
    {
        return match ($style) {
            'text' => match ($this->admin) {
                0 => "Utilisateur",
                1 => "Administrateur",
                default => "Non Reconnue"
            },
            'color' => match ($this->admin) {
                0 => "secondary",
                1 => "success",
                default => "danger"
            },
            "icon" => match ($this->admin) {
                0 => "user",
                1 => "user-shield",
                default => "xmark"
            },
            default => null,
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return "<span class='badge badge-".$this->getStatusFormat('color')." text-inverse".$this->getStatusFormat('color')."'>" .
            "<i class='fa-solid fa-".$this->getStatusFormat('icon')." text-inverse-".$this->getStatusFormat('color')." me-2'></i> ".$this->getStatusFormat('text') .
            "</span>";
    }

    public function getTypeLabelAttribute()
    {
        return "<span class='badge badge-".$this->getTypeFormat('color')." text-inverse".$this->getTypeFormat('color')."'>" .
            "<i class='fa-solid fa-".$this->getTypeFormat('icon')." text-inverse-".$this->getTypeFormat('color')." me-2'></i> ".$this->getTypeFormat('text') .
            "</span>";
    }
}
