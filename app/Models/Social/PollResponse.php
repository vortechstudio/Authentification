<?php

namespace App\Models\Social;

    use Illuminate\Database\Eloquent\Model;

    class PollResponse extends Model {
        public $timestamps = false;

        protected $casts = [
        'users' => 'array',
        ];
    }
