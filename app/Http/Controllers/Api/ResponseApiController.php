<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ResponseApiController extends Controller
{
    public function success($data = null)
    {
        return response()->json([
            'status' => "success",
            'data' => $data,
        ]);
    }

    public function error(\Exception $e, $message = null)
    {
        \Log::emergency("LOG API: ".$message, [
            "file" => $e->getFile(),
            "line" => $e->getLine(),
            "trace" => $e->getTraceAsString(),
        ]);
        return response()->json([
            'status' => "error",
            'message' => $message,
        ]);
    }
}
