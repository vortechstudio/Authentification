<?php

namespace App\Models;

use App\Events\ModelCreated;
use App\Models\Support\Ticket\Ticket;
use App\Models\Support\Ticket\TicketCategory;
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
        'status_label',
        'image_src',
        'image_header',
        'image_icon',
    ];

    protected $dispatchesEvents = [
        'created' => ModelCreated::class,
    ];

    public function user_service()
    {
        return $this->hasMany(UserService::class);
    }

    public function notes()
    {
        return $this->hasMany(ServiceNote::class);
    }

    public function ticket_categories()
    {
        return $this->hasMany(TicketCategory::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public static function getOptions()
    {
        $arr = collect();
        $services = self::all();
        foreach ($services as $service) {
            $arr->push([
                'id' => $service->id,
                'value' => $service->name,
            ]);
        }

        return $arr;
    }

    public static function getTypeFormat($type, $format = 'text')
    {
        return match ($format) {
            'text' => match ($type) {
                'jeux' => 'Jeux',
                'plateforme' => 'Plateforme'
            },
            'icon' => match ($type) {
                'jeux' => 'fa-gamepad',
                'plateforme' => 'fa-cubes'
            },
            'color' => match ($type) {
                'jeux' => 'yellow-800',
                'plateforme' => 'info'
            },
            'text-color' => 'white',
            default => $type
        };
    }

    public static function getStatusFormat($status, $format = 'text')
    {
        if ($status == '' || $status == null) {
            return null;
        } else {
            return match ($format) {
                'text' => match ($status) {
                    'idea' => 'Idée',
                    'develop' => 'En développement',
                    'production' => 'Production'
                },
                'icon' => match ($status) {
                    'idea' => 'fa-bulb',
                    'develop' => 'fa-code',
                    'production' => 'fa-box'
                },
                'color' => match ($status) {
                    'idea' => 'yellow-800',
                    'develop' => 'primary',
                    'production' => 'deeppurple-800'
                },
                'text-color' => match ($status) {
                    'idea', 'production', 'develop' => 'white'
                },
                default => $status
            };
        }
    }

    public function getImageSrcAttribute()
    {
        if (\Storage::disk('public')->exists('services/'.\Str::slug($this->name).'.webp')) {
            return asset('/storage/services/'.\Str::slug($this->name).'.webp');
        } else {
            return asset('/storage/services/default.png');
        }
    }

    public function getImageHeaderAttribute()
    {
        if (\Storage::disk('public')->exists('services/header_'.\Str::slug($this->name).'.webp')) {
            return asset('/storage/services/header_'.\Str::slug($this->name).'.webp');
        } else {
            return asset('/storage/services/header_default.png');
        }
    }

    public function getImageIconAttribute()
    {
        if (\Storage::disk('public')->exists('services/icon_'.\Str::slug($this->name).'.webp')) {
            return asset('/storage/services/icon_'.\Str::slug($this->name).'.webp');
        } else {
            return asset('/storage/services/icon_default.png');
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

    public static function getRewardTypesFromService(string $service)
    {

        return self::defineRewardTypesFromService(\Str::slug($service));
    }

    private static function defineRewardTypesFromService(string $serviceSlugify): \Illuminate\Support\Collection
    {
        $arr = collect();

        switch ($serviceSlugify) {
            case 'railway-manager' || 'railway-manager-beta':
                $arr->push([
                    'id' => 'argent',
                    'value' => 'Argent',
                ]);
                $arr->push([
                    'id' => 'tpoint',
                    'value' => 'T Point',
                ]);
                $arr->push([
                    'id' => 'engine',
                    'value' => 'Matériel Roulant',
                ]);
                break;
            case 'vortech-lab':
                $arr->push([
                    'id' => 'stricker',
                    'value' => 'Stricker',
                ]);
                $arr->push([
                    'id' => 'head-bank',
                    'value' => 'Contour de header',
                ]);
                $arr->push([
                    'id' => 'head-profil',
                    'value' => 'Contour de profil',
                ]);
                break;
            case 'acces-de-base':
            default:
                break;
        }

        return $arr;
    }
}
