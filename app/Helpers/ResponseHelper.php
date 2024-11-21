<?php

use Illuminate\Http\JsonResponse;

if (!function_exists('response_json')) {
    /**
     * Create a standardized JSON response.
     *
     * @param bool $isSuccess
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @param array|null $pagination Optional pagination metadata.
     * @return JsonResponse
     */
    function response_json(bool $isSuccess, $data, string $message = '', int $statusCode = 200, array $pagination = null): JsonResponse
    {
        $response = [
            'message' => $message,
            'data' => $data,
            'isSuccess' => $isSuccess,
        ];

        if ($pagination) {
            $response = array_merge($response, $pagination);
        }

        return response()->json($response, $statusCode);
    }
}
