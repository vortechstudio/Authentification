<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    public function all()
    {
        $query = Service::with('notes');
        return response()->json($query->get(), 200);
    }

    public function info(int $id)
    {
        $query = Service::with('notes')->find($id);
        if (!$query) {
            return response()->json(['error' => 'Service not found'], 404);
        } else {
            return response()->json($query, 200);
        }
    }
}
