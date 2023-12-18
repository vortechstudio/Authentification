<?php

namespace App\Models;

use App\Enum\ServiceStatusEnum;
use App\Enum\ServiceTypeEnum;
use App\Events\ModelCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Service extends Model
{
    use Notifiable;
    protected $guarded = [];
    protected $casts = [
    ];
    protected $appends = [
        'type_label',
        'status_label'
    ];

    protected $dispatchesEvents = [
        'created' => ModelCreated::class
    ];

    public function user_service()
    {
        return $this->hasMany(UserService::class);
    }

    public function notes()
    {
        return $this->hasMany(ServiceNote::class);
    }

    public static function getTypeFormat($type, $format = 'text')
    {
        return match ($format) {
            "text" => match ($type) {
                "jeux" => "Jeux",
                "plateforme" => "Plateforme"
            },
            "icon" => match($type) {
                "jeux" => "fa-gamepad",
                "plateforme" => "fa-cubes"
            },
            "color" => match($type) {
                "jeux" => "yellow-800",
                "plateforme" => "info"
            },
            "text-color" => "white",
            default => $type
        };
    }

    public static function getStatusFormat($status, $format = 'text')
    {
        if($status == '' || $status == null) {
            return null;
        } else {
            return match ($format) {
                "text" => match ($status) {
                    "idea" => "Idée",
                    "develop" => "En développement",
                    "production" => "Production"
                },
                "icon" => match($status) {
                    "idea" => "fa-bulb",
                    "develop" => "fa-code",
                    "production" => "fa-box"
                },
                "color" => match($status) {
                    "idea" => "yellow-800",
                    "develop" => "primary",
                    "production" => "deeppurple-800"
                },
                "text-color" => match($status) {
                    "idea", "production", "develop" => "white"
                },
                default => $status
            };
        }
    }

    public function getTypeLabelAttribute()
    {
        ob_start();
        ?>
        <span class="badge bg-<?= self::getTypeFormat($this->type, 'color') ?>">
            <i class="fa-solid <?= self::getTypeFormat($this->type, 'icon') ?> fs-4 text-<?= self::getTypeFormat($this->type, 'text-color') ?> me-2"></i>
            <span class="text-<?= self::getTypeFormat($this->type, 'text-color') ?>"><?= self::getTypeFormat($this->type) ?></span>
        </span>
        <?php
        return ob_get_clean();
    }

    public function getStatusLabelAttribute()
    {
        ob_start();
        ?>
        <span class="badge bg-<?= self::getStatusFormat($this->status, 'color') ?>">
            <i class="fa-solid <?= self::getStatusFormat($this->status, 'icon') ?> fs-4 text-<?= self::getStatusFormat($this->status, 'text-color') ?> me-2"></i>
            <span class="text-<?= self::getStatusFormat($this->status, 'text-color') ?>"><?= self::getStatusFormat($this->status) ?></span>
        </span>
        <?php
        return ob_get_clean();
    }
}
