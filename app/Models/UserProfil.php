<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfil extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'banned_at' => 'datetime',
        'banned_for' => 'datetime',
    ];

    protected $appends = [
        'header_img_link',
        'profil_img_link',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getHeaderImgLinkAttribute()
    {
        if(\Storage::disk('sftp')->exists('user/'.$this->user_id.'/header_profil.png')) {
            return storageToUrl(\Storage::disk('sftp')->url('user/'.$this->user_id.'/header_profil.png'));
        } else {
            return storageToUrl(\Storage::disk('sftp')->url('user/default/header_profil.png'));
        }
    }

    public function getProfilImgLinkAttribute()
    {
        if(\Storage::disk('sftp')->exists('user/'.$this->user_id.'/profil.png')) {
            return storageToUrl(\Storage::disk('sftp')->url('user/'.$this->user_id.'/profil.png'));
        } else {
            return storageToUrl(\Storage::disk('sftp')->url('user/default/profil.png'));
        }
    }
}
