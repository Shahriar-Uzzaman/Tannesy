<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponser
{
    /**
     * @param $data
     * @param string $message
     * @param int $status_code
     * @return JsonResponse
     * Return the success data
     */
    public function success(
        $data,
        string $message = "Successful",
        int $status_code = Response::HTTP_OK,
    ): JsonResponse {
        return response()->json(
            [
                "success" => true,
                "message" => $message,
                "data" => $data,
            ],
            $status_code,
        );
    }

    /**
     * @param string $message
     * @param int $status_code
     * @param array $errors
     * @return JsonResponse
     * Return the error data if there is any error
     */
    public function error(
        string $message = "Data is invalid",
        int $status_code = Response::HTTP_BAD_REQUEST,
        array $errors = [],
    ): JsonResponse {
        $response = [
            "success" => false,
            "message" => $message,
            "data" => null,
        ];

        if (!is_null($errors)) {
            $response["errors"] = $errors;
        }
        return response()->json($response, $status_code);
    }
}
