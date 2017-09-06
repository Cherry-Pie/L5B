<?php

namespace App\Http\Traits;

trait ApiResponseTrait
{
    public function success($data, $message = '')
    {
        return response()->json([
            'message' => $message, 
            'data'    => $data, 
            'error'   => false,
        ]);
    }
    
    public function fail($message, $code = 500)
    {
        return response()->json([
            'message' => $message, 
            'error'   => false,
        ], $code);
    }

    public function errors($errors, $message, $errorData = [])
    {
        return response()->json([
            'message'    => $message, 
            'error'      => true, 
            'errors'     => $errors, 
            'error_data' => $errorData
        ]);
    }
}
