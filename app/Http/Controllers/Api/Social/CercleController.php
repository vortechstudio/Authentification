<?php

namespace App\Http\Controllers\Api\Social;

use App\Http\Controllers\Controller;
use App\Models\Social\Cercle;

class CercleController extends Controller
{
    public function all()
    {
        $cercles = Cercle::with('posts', 'blogs', 'events', 'wiki_category')->get();
        return response()->json($cercles, 200);
    }
}
