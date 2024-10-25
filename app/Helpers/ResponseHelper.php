<?php

use Illuminate\Http\JsonResponse;

if (!function_exists('response_json')) {
    /**
     * Create a standardized JSON response.
     *
     * @param bool $isSuccess
     * @param string $message
     * @param $data
     * @param int $statusCode
     * @return JsonResponse
     */
    function response_json(bool $isSuccess, $data, string $message = '', int $statusCode = 200): JsonResponse
    {
        $response = [
            'message' => $message,
            'data' => $data,
            'isSuccess' => $isSuccess,
        ];

        return response()->json($response, $statusCode);
    }
}
