<?php

namespace App\Traits; // Define the namespace for the trait

use Illuminate\Http\Response; // Import the Response class from the Illuminate\Http namespace

trait ApiResponser
{
    /**
     * Build success response
     * 
     * @param string|array $data
     * @param int $code
     * @return \Illuminate\Http\Response
     */
    public function successResponse($data, $message = '', $code = Response::HTTP_OK)
    {
        // Return a JSON response for successful operations
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Build valid response
     * 
     * @param string|array $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function validResponse($data, $code = Response::HTTP_OK)
    {
        // Return a JSON response with valid data
        return response()->json(['data' => $data], $code);
    }

    /**
     * Build error response
     * 
     * @param string|array $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($message, $code)
    {
        // Return a JSON response for errors
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => null
        ], $code);
    }

    /**
     * Build error message
     * 
     * @param string|array $data
     * @param int $code
     * @return \Illuminate\Http\Response
     */
    public function errorMessage($data, $code = Response::HTTP_OK)
    {
        // Return a plain response with error data
        return response($data, $code)->header('Content-Type', 'application/json');
    }
}

