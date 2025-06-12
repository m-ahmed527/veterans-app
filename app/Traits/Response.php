<?php

namespace App\Traits;

trait Response
{

    public function success($message, $data = null)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], 200);
    }

    public function error($message, $statusCode = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $statusCode);
    }

    public function validationError($errors, $statusCode = 422)
    {
        return response()->json([
            'success' => false,
            'message' => 'Validation Error',
            'errors' => $errors,
        ], $statusCode);
    }
}
