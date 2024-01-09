<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cms;

class PagesController extends Controller
{
    public function all()
    {
        $query = Cms::with('parent');
        return response()->json($query->get(), 200);
    }
}
