<?php

namespace App\Models\Social;

use App\Events\ModelCreated;
use App\Models\User;
use App\Service\PollingSystem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;

class Event extends Model
{
    use Notifiable, Searchable;

    public $timestamps = false;

    protected $guarded = [];

    protected $dispatchesEvents = [
        'created' => ModelCreated::class,
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    protected $appends = [
        'type_event_string',
        'status_label',
    ];

    public function searchableAs()
    {
        return match(config('app.env')) {
            "local" => "dev_event",
            "staging" => "test_event",
            "production" => "prod_event",
        };
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        $array['cercles'] = $this->cercles->pluck('name')->toArray();

        return $array;
    }

    public static function UpToSubmitting(\LaravelIdea\Helper\App\Models\Social\_IH_Event_C|array|Event|null $event)
    {
        /*
         * Vérification à effectuer avant soumission
         * - Nombre de participant
         */
        if ($event->participants()->count() != 0) {
            $event->update([
                'status' => 'submitting',
            ]);

            return null;
        } else {
            \Log::debug('Error: Certains pré-requis nécessaire ne sont pas remplie pour passer à la soumission', [
                'type' => ['Participant à 0'],
            ]);
            session()->flash('error', 'Certains pré-requis nécessaire ne sont pas remplie pour passer à la soumission');
        }

        // Envoyer une notification aux utilisateurs souhaitant participer que l'évènement accepte les soumissions
    }

    public static function UpToEvaluation(\LaravelIdea\Helper\App\Models\Social\_IH_Event_C|array|Event|null $event)
    {
        $verify = match ($event->type_event) {
            'poll' => PollingSystem::verify($event)
        };

        if ($verify) {
            $event->update([
                'status' => 'evaluation',
            ]);

            return null;
        } else {
            return (new \Exception("Certains pré-requis nécessaire ne sont pas remplie pour passer à l'évaluation"))->getMessage();
        }
    }

    public static function UpToTerminate(\LaravelIdea\Helper\App\Models\Social\_IH_Event_C|array|Event|null $event)
    {
        $event->update([
            'status' => 'closed',
        ]);

        return null;
    }

    public function cercles()
    {
        return $this->belongsToMany(Cercle::class, 'event_cercle', 'event_id', 'cercle_id');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'user_event', 'event_id', 'user_id');
    }

    public function poll()
    {
        return $this->hasOne(Poll::class);
    }

    public function getTypeEventStringAttribute()
    {
        return match ($this->type_event) {
            'poll' => 'Sondage',
            'graphic' => 'Concours Graphique'
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
        if ($type == 'icon') {
            if (Storage::disk('sftp')->exists("events/{$event_id}/icon.png")) {
                return storageToUrl(Storage::disk('sftp')->url("events/{$event_id}/icon.png"));
            } else {
                return storageToUrl(Storage::disk('sftp')->url('events/icon_default.png'));
            }
        } elseif ($type == 'header') {
            if (Storage::disk('sftp')->exists("events/{$event_id}/header.png")) {
                return storageToUrl(Storage::disk('sftp')->url("events/{$event_id}/header.png"));
            } else {
                return storageToUrl(Storage::disk('sftp')->url('events/header_default.png'));
            }
        } else {
            if (Storage::disk('sftp')->exists("events/{$event_id}/event.png")) {
                return storageToUrl(Storage::disk('sftp')->url("events/{$event_id}/event.png"));
            } else {
                return storageToUrl(Storage::disk('sftp')->url('events/event_default.png'));
            }
        }
    }

    public static function getStatusFormat($status, $format = 'text')
    {
        if ($status == '' || $status == null) {
            return null;
        } else {
            return match ($format) {
                'text' => match ($status) {
                    'progress' => 'En cours',
                    'submitting' => 'Soumission en cours',
                    'evaluation' => 'Evalutation en cours',
                    'closed' => 'Terminer',
                },
                'icon' => match ($status) {
                    'progress' => 'fa-spinner fa-spin',
                    'submitting' => 'fa-envelope',
                    'evaluation' => 'fa-certificate',
                    'closed' => 'fa-check-circle',
                },
                'color' => match ($status) {
                    'progress' => 'amber-500',
                    'submitting' => 'blue-500',
                    'evaluation' => 'yellow-500',
                    'closed' => 'green-500',
                },
                'text-color' => match ($status) {
                    'progress', 'submitting', 'evaluation', 'closed' => 'white',
                },
                default => $status
            };
        }
    }

    public static function typeSelector()
    {
        $arr = collect();
        $arr->push(['id' => 'poll', 'value' => 'Sondages']);
        $arr->push(['id' => 'graphic', 'value' => 'Concours graphique']);

        return $arr;

    }
}
