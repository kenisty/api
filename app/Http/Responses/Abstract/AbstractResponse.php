<?php

namespace App\Http\Responses\Abstract;

use App\DTOs\DefaultDTOInterface;
use App\Enum\ResponseCode;
use Exception;
use Illuminate\Http\JsonResponse;

abstract class AbstractResponse
{
    protected const KEY_MESSAGE = 'message';
    protected const KEY_DATA = 'data';

    abstract protected function getResponseCode(): ResponseCode;
    abstract protected function getMessageTranslationKey(): ?string;

    /**
     * @throws Exception
     */
    public function getResponse(DefaultDTOInterface $dto): JsonResponse
    {
        return response()->json([
            self::KEY_MESSAGE => trans($this->getMessageTranslationKey()),
            self::KEY_DATA => $dto->toArray(),
        ], $this->getResponseCode()->value);
    }
}
