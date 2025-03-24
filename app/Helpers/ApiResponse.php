<?php

namespace App\Helpers;

use App\Enums\ResponseType;
use GuzzleHttp\Psr7\Response;

class ApiResponse
{
    /**
     * Responds with a structured JSON response based on the given parameters.
     *
     * @param ResponseType $type The type of response (e.g., success, error, file). Default is `ResponseType::SUCCESS`.
     * @param string $message A custom message to include in the response. Default is `'Success'`.
     * @param mixed $data The data to return in the response. For `ResponseType::SUCCESS`, it will be included as `data`. For `ResponseType::ERROR`, it will be included as `error`. Default is `null`.
     * @param int $status The HTTP status code for the response. Default is `200`.
     * 
     * @return \Illuminate\Http\JsonResponse The structured JSON response.
     */
    public static function respond(ResponseType $type = ResponseType::SUCCESS, string $message = 'Success', $data = null, $status = 200)
    {
        $payload = [
            'message' => $message,
            'success' => $type === ResponseType::SUCCESS,
        ];

        if ($type === ResponseType::SUCCESS) {
            $payload['data'] = $data;
        } elseif ($type === ResponseType::ERROR) {
            $payload['error'] = $data;
        } elseif ($type === ResponseType::FILE) {
            // TODO: response type for file
            return;
        }

        return response()->json($payload, $status);
    }
}
