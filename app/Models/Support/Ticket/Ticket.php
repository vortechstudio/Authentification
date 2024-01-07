<?php

namespace App\Models\Support\Ticket;

use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    protected $appends = [
        'priority_label',
        'status_label',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function category()
    {
        return $this->belongsTo(TicketCategory::class, 'ticket_category_id');
    }

    public function responses()
    {
        return $this->hasMany(TicketResponse::class);
    }

    public function getPriorityStyle(string $style)
    {
        return match ($style) {
            "icon" => match ($this->priority) {
                "low" => "fa-angle-down",
                "medium" => "fa-minus",
                "high" => "fa-angle-up",
            },
            "text" => match ($this->priority) {
                "low" => "Basse",
                "medium" => "Normal",
                "high" => "Haute",
            },
            "color" => match ($this->priority) {
                "low" => "text-success",
                "medium" => "text-primary",
                "high" => "text-danger",
            },
        };
    }

    public function getStatusStyle(string $style)
    {
        return match ($style) {
            "icon" => match ($this->status) {
                "open" => "fa-circle",
                "closed" => "fa-check-circle",
                "pending" => "fa-clock",
            },
            "text" => match ($this->status) {
                "open" => "Ouvert",
                "closed" => "Fermé",
                "pending" => "En attente",
            },
            "color" => match ($this->status) {
                "open" => "success",
                "closed" => "primary",
                "pending" => "warning",
            },
        };
    }

    public function getPriorityLabelAttribute()
    {
        return "<i class='fa-solid {$this->getPriorityStyle('icon')} {$this->getPriorityStyle('color')} fs-1' data-bs-toggle='tooltip' data-bs-original-title='{$this->getPriorityStyle('text')}'></i>";
    }

    public function getStatusLabelAttribute()
    {
        return "<span class='badge badge-{$this->getStatusStyle('color')} text-inverse-{$this->getStatusStyle('color')}'><i class='fa-solid {$this->getStatusStyle('icon')} text-inverse-{$this->getStatusStyle('color')} me-2'></i> {$this->getStatusStyle('text')}</span>";
    }
}
