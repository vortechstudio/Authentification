<?php

namespace App\Models\Railway;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ResearchProject extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $appends = [
        'icon',
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ResearchCategory::class, 'research_category_id');
    }

    public function getIconAttribute()
    {
        if (\Storage::disk('sftp')->exists('/icons/research/'.Str::slug($this->name).'.png')) {
            return storageToUrl(\Storage::disk('sftp')->url('/icons/research/'.Str::slug($this->name).'.png'));
        } else {
            return storageToUrl(\Storage::disk('sftp')->url('/icons/research/default.png'));
        }
    }
}
