<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    const VALIDATION_FAILED_CODE = 400;

    public function failResponse(string $msg, mixed $data, int $code): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $msg,
            'data' => $data
        ], $code);
    }

    public function validationFailedResponse(string $msg, mixed $data): JsonResponse
    {
        return $this->failResponse($msg, $data, self::VALIDATION_FAILED_CODE);
    }
}
