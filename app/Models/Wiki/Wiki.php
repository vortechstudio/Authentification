<?php

namespace App\Models\Wiki;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Wiki extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'posted_at' => 'datetime',
    ];

    protected $appends = [
        'status_label',
    ];

    public function category()
    {
        return $this->belongsTo(WikiCategory::class, 'wiki_category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(WikiSubcategory::class, 'wiki_subcategory_id');
    }

    public function contributors()
    {
        return $this->belongsToMany(User::class, 'wiki_user', 'wiki_id', 'user_id');
    }

    public function logs()
    {
        return $this->hasMany(WikiLog::class);
    }

    public function getStatusLabelAttribute()
    {
        ob_start();
        ?>
        <span class="badge bg-<?= self::getStatusFormat($this->posted, 'color') ?>">
            <i class="fa-solid <?= self::getStatusFormat($this->posted, 'icon') ?> fs-4 text-<?= self::getStatusFormat($this->posted, 'text-color') ?> me-2"></i>
            <span class="text-<?= self::getStatusFormat($this->posted, 'text-color') ?>"><?= self::getStatusFormat($this->posted) ?></span>
        </span>
        <?php
        return ob_get_clean();
    }

    public static function getStatusFormat($status, $format = 'text')
    {
        return match ($format) {
            'text' => ! $status ? 'Brouillon' : 'Publier',
            'icon' => ! $status ? 'fa-edit' : 'fa-check-circle',
            'color' => ! $status ? 'gray-500' : 'success',
            'text-color' => ! $status ? 'black' : 'white',
            default => $status
        };
    }
}
