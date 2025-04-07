<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
    * Creates a standard response structure for message requests.
    *
    * @param string $status Response status (success/error).
    * @param string $message Message to the user.
    * @param mixed $data Additional details for return.
    * @param int $statusCode HTTP status code.
    * @return JsonResponse
    */
    public static function createResponseWithMessage(string $status, string $message, $data = null, int $statusCode = 200): JsonResponse
    {
        $response = [
            'status' => $status,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode);
    }

    /**
    * Generates a response without a message (for GET requests).
    *
    * @param string $status Response status (success/error).
    * @param mixed $data Additional details for return.
    * @param int $statusCode HTTP status code.
    * @return JsonResponse
    */
    public static function createResponseWithoutMessage(string $status, $data = null, int $statusCode = 200): JsonResponse
    {
        $response = [
            'status' => $status,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Answer for a successful message operation.
    */
    public static function successWithMessage(string $message, $data = null): JsonResponse
    {
        return self::createResponseWithMessage('success', $message, $data, 200);
    }

    /**
     * Response for a successful operation without a message (for GET requests).
    */
    public static function successWithoutMessage($data = null): JsonResponse
    {
        return self::createResponseWithoutMessage('success', $data, 200);
    }

    /**
     * The answer is for the error with the message.
    */
    public static function errorWithMessage(string $message, $data = null, int $statusCode = 400): JsonResponse
    {
        return self::createResponseWithMessage('error', $message, $data, $statusCode);
    }

    /**
     * The answer is for the error without notification.
    */
    public static function errorWithoutMessage($data = null, int $statusCode = 400): JsonResponse
    {
        return self::createResponseWithoutMessage('error', $data, $statusCode);
    }

    /**
     * Standard-answers
    */
    public static function invalidApiKey(): JsonResponse
    {
        return self::errorWithMessage('Invalid or missing API Key', null, 401);
    }

    public static function accessDenied(): JsonResponse
    {
        return self::errorWithMessage('Access is denied', null, 403);
    }

    public static function notFound(): JsonResponse
    {
        return self::errorWithMessage('Not Found', null, 404);
    }
    public static function noChangesDetected(): JsonResponse
    {
        return self::successWithMessage('No changes detected', null);
    }
    public static function noDataToUpdate(): JsonResponse
    {
        return self::errorWithMessage('There is no data to update', null, 400);
    }
}
