<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class ResponseService
{
    public static function success($data = null, $message = 'Success', $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public static function error($message = 'Error', $code = 500, $data = null)
    {
        Log::error($message, ['data' => $data]);
        
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ], $code);
    }
}