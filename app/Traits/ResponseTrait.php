<?php

namespace App\Traits;

use App\Enum\ResponseCode;
use App\Enum\ResponseStatus;
use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    private const KEY_STATUS = 'status';
    private const KEY_MESSAGE = 'message';
    private const KEY_DATA = 'data';

    private function successResponse(ResponseStatus $status, ResponseCode $code, string $msg, mixed $data): JsonResponse
    {
        return response()->json([
            self::KEY_STATUS => $status,
            self::KEY_MESSAGE => $msg,
            self::KEY_DATA => $data,
        ], $code->value);
    }

    private function failResponse(ResponseStatus $status, ResponseCode $code, string $msg, mixed $data): JsonResponse
    {
        return response()->json([
            self::KEY_STATUS => $status,
            self::KEY_MESSAGE => $msg,
            self::KEY_DATA => $data,
        ], $code->value);
    }
}
