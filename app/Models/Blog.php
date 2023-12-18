<?php

namespace App\Models;

use App\Enum\BlogAuthorEnum;
use App\Enum\BlogCategoryEnum;
use App\Enum\BlogSubcategoryEnum;
use App\Events\ModelCreated;
use App\Models\Social\Cercle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use VanOns\Laraberg\Traits\RendersContent;

class Blog extends Model
{
    use HasFactory, Notifiable, RendersContent;
    protected $guarded = [];
    protected $casts = [
        'published_at' => 'datetime',
        'publish_social_at' => 'datetime',
    ];
    protected $appends = [
        'slug',
        'category_string',
        'subcategory_string',
        'author_string',
        'status_label'
    ];

    protected $dispatchesEvents = [
        'created' => ModelCreated::class
    ];

    protected $contentColumn = 'contenue';

    public function cercles()
    {
        return $this->belongsToMany(Cercle::class, 'blog_cercle', 'blog_id', 'cercle_id');
    }

    public function getSlugAttribute()
    {
        return \Str::slug($this->title);
    }

    public function getCategoryStringAttribute()
    {
        return match($this->category) {
            "railway" => "Railway Manager",
            "vortech" => "Vortech Studio"
        };
    }

    public function getSubcategoryStringAttribute()
    {
        return match($this->subcategory) {
            "notice" => "Annonce",
            "event" => "Evènement",
            "news" => "A la une",
            "auth" => "Authentification et espace membre"
        };
    }

    public function getAuthorStringAttribute()
    {
        return match($this->author) {
            "vortech" => "Vortech Studio",
            "railway" => "Railway Manager"
        };
    }

    public static function getStatusFormat($status, $format = 'text'): string
    {
        if($format == 'text') {
            return $status ? 'Publié' : 'Brouillon';
        } elseif($format == 'icon') {
            return $status ? 'fa-check' : 'fa-pen';
        } elseif($format == 'color') {
            return $status ? 'success' : 'secondary';
        }elseif($format == "text-color") {
            return $status ? 'white' : 'gray-800';
        } else {
            return $status;
        }
    }

    public function getStatusLabelAttribute(): bool|string
    {
        ob_start();
        ?>
        <span class="badge badge-<?= self::getStatusFormat($this->published, 'color') ?>">
            <i class="fa-solid <?= self::getStatusFormat($this->published, 'icon') ?> fs-4 text-<?= self::getStatusFormat($this->published, 'text-color') ?> me-2"></i>
            <span class="<?= self::getStatusFormat($this->published, 'text-color') ?>"><?= self::getStatusFormat($this->published) ?></span>
        </span>
        <?php
        return ob_get_clean();
    }
}
