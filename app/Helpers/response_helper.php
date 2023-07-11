<?php
namespace App\Helpers;
class Response
{
    public static function success($data, $status = 200)
    {
        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], $status);
    }

    public static function error($message, $status = 400)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $status);
    }
}
