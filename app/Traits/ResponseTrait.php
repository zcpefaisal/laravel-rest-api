<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseTrait{

    /**
     * Success response
     *
     * @param array|object $data
     * @param string $message
     *
     * @return JsonResponse
     */
    public function responseSuccess($data, $message = "Successful") : JsonResponse{
        return response()->json([
            'status' => true,
            'message'=> $message,
            'data' => $data,
            'errors' => null,
        ]);
    }


    /**
     * Error response
     *
     * @param array|object $errors
     * @param string $message
     *
     * @return JsonResponse
     */
    public function responseError($errors, $message = "Data is invalid") : JsonResponse{
        return response()->json([
            'status' => true,
            'message'=> $message,
            'data' => null,
            'errors' => $errors,
        ]);
    }



}


