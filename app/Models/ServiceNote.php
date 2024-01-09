<?php

namespace App\Models;

use App\Events\ModelCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ServiceNote extends Model
{
    use Notifiable;

    protected $guarded = [];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected $appends = [
        'status_label',
        'is_latest'
    ];

    protected $dispatchesEvents = [
        'created' => ModelCreated::class,
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function getIsLatestAttribute()
    {
        return $this->service->notes->first()->id == $this->id;
    }
    public static function getStatusFormat($status, $format = 'text'): string
    {
        if ($format == 'text') {
            return $status ? 'Publié' : 'Brouillon';
        } elseif ($format == 'icon') {
            return $status ? 'fa-check' : 'fa-pen';
        } elseif ($format == 'color') {
            return $status ? 'success' : 'secondary';
        } elseif ($format == 'text-color') {
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
