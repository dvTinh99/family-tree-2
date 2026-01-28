<?php

namespace App\Http\Controllers;

abstract class Controller
{
    function responseSuccess($data, $message, $code = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    function responseError($data, $message, $code = 500)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
