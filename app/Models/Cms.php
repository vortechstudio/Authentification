<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cms extends Model
{
    use SoftDeletes;

    protected $casts = [
        'published_at' => 'datetime',
    ];
    protected $guarded = [];

    protected $appends = [
        "publish_label",
        "is_parent"
    ];

    public function parent()
    {
        return $this->belongsTo(Cms::class, 'parent_id');
    }

    public static function getPublishFormat($publish, $format = 'text'): string
    {
        if($format == 'text') {
            return $publish ? 'Publié' : 'Brouillon';
        } elseif($format == 'icon') {
            return $publish ? 'fa-check' : 'fa-pen';
        } elseif($format == 'color') {
            return $publish ? 'success' : 'secondary';
        }elseif($format == "text-color") {
            return $publish ? 'white' : 'gray-800';
        } else {
            return $publish;
        }
    }

    public function getPublishLabelAttribute(): bool|string
    {
        ob_start();
        ?>
        <span class="badge badge-<?= self::getPublishFormat($this->published, 'color') ?>">
            <i class="fa-solid <?= self::getPublishFormat($this->published, 'icon') ?> fs-4 text-<?= self::getPublishFormat($this->published, 'text-color') ?> me-2"></i>
            <span class="<?= self::getPublishFormat($this->published, 'text-color') ?>"><?= self::getPublishFormat($this->published) ?></span>
        </span>
        <?php
        return ob_get_clean();
    }

    public static function getParentFormat($parent_id, $format = 'text'): string
    {
        if($parent_id != null || $parent_id != '') {
            if($format == 'text') {
                return "Publié";
            } elseif($format == 'icon') {
                return "fa-check";
            } elseif($format == 'color') {
                return "success";
            }elseif($format == "text-color") {
                return "white";
            } else {
                return $parent_id;
            }
        } else {
            return "";
        }
    }

    public function getIsParentAttribute()
    {
        ob_start();
        ?>
        <span class="badge badge-<?= self::getParentFormat($this->parent_id, 'color') ?>">
            <i class="fa-solid <?= self::getParentFormat($this->parent_id, 'icon') ?> fs-4 text-<?= self::getParentFormat($this->parent_id, 'text-color') ?> me-2"></i>
            <span class="<?= self::getParentFormat($this->parent_id, 'text-color') ?>"><?= self::getParentFormat($this->parent_id) ?></span>
        </span>
        <?php
        return ob_get_clean();
    }
}
