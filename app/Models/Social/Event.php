<?php

namespace App\Models\Social;

use App\Events\ModelCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    use Notifiable;
    public $timestamps = false;
    protected $guarded = [];

    protected $dispatchesEvents = [
        'created' => ModelCreated::class
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    protected $appends = [
        "type_event_string",
        "status_label"
    ];

    public function cercles()
    {
        return $this->belongsToMany(Cercle::class, 'event_cercle', 'event_id', 'cercle_id');
    }

    public function getTypeEventStringAttribute()
    {
        return match ($this->type_event) {
            "poll" => "Sondage",
            "graphic" => "Concours Graphique"
        };
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

    public static function getSrcImage($event_id, $type = 'icon')
    {
        if($type == 'icon') {
            if(Storage::disk('public')->exists("events/{$event_id}/icon.png")) {
                return asset("/storage/events/{$event_id}/icon.png");
            } else {
                return asset('/storage/events/icon_default.png');
            }
        } elseif($type == 'header') {
            if(Storage::disk('public')->exists("events/{$event_id}/header.png")) {
                return asset("/storage/events/{$event_id}/header.png");
            } else {
                return asset('/storage/events/header_default.png');
            }
        } else {
            if(Storage::disk('public')->exists("events/{$event_id}/event.png")) {
                return asset("/storage/events/{$event_id}/event.png");
            } else {
                return asset('/storage/events/default.png');
            }
        }
    }

    public static function getStatusFormat($status, $format = 'text')
    {
        if($status == '' || $status == null) {
            return null;
        } else {
            return match ($format) {
                "text" => match ($status) {
                    "progress" => "En cours",
                    "submitting" => "Soumission en cours",
                    "evaluation" => "Evalutation en cours",
                    "closed" => "Terminer",
                },
                "icon" => match($status) {
                    "progress" => "fa-spinner fa-spin",
                    "submitting" => "fa-envelope",
                    "evaluation" => "fa-certificate",
                    "closed" => "fa-check-circle",
                },
                "color" => match($status) {
                    "progress" => "amber-500",
                    "submitting" => "blue-500",
                    "evaluation" => "yellow-500",
                    "closed" => "green-500",
                },
                "text-color" => match($status) {
                    "progress", "submitting", "evaluation", "closed" => "white",
                },
                default => $status
            };
        }
    }

    public static function typeSelector()
    {
        $arr = collect();
        $arr->push(["id" => "poll", "value" => "Sondages"]);
        $arr->push(["id" => "graphic", "value" => "Concours graphique"]);

        return $arr;

    }
}
