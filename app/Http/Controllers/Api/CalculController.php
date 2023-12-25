<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Railway\Engine;
use Illuminate\Http\Request;

class CalculController extends Controller
{
    public function estimateEssieux()
    {
        $calc = Engine::calcDurationMaintenance(\request()->get('essieux'));

        return response()->json([
            "text" => $calc,
            "format" => $calc->format("H:i:s")
        ]);
    }
}
