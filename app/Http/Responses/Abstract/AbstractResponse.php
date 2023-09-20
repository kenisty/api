<?php declare(strict_types=1);

namespace App\Http\Responses\Abstract;

use App\DTOs\DefaultDTOInterface;
use App\Enum\ResponseCode;
use Illuminate\Http\JsonResponse;

abstract class AbstractResponse
{
    protected const KEY_MESSAGE = 'message';
    protected const KEY_DATA = 'data';

    protected ?string $messageTranslationKey = null;

    protected ?ResponseCode $responseCode = null;

    protected ?DefaultDTOInterface $dto = null;

    protected array $data = [];

    public function setResponseCode(?ResponseCode $code): self
    {
        $this->responseCode = $code;

        return $this;
    }

    protected function getResponseCode(): ?ResponseCode
    {
        return $this->responseCode;
    }

    public function setMessageTranslationKey(?string $messageKey): self
    {
        $this->messageTranslationKey = $messageKey;

        return $this;
    }

    protected function getMessageTranslationKey(): ?string
    {
        return $this->messageTranslationKey;
    }

    public function setDto(?DefaultDTOInterface $dto): self
    {
        $this->dto = $dto;

        return $this;
    }

    protected function getDto(): ?DefaultDTOInterface
    {
        return $this->dto;
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    protected function getData(): array
    {
        return $this->data;
    }

    public function getResponse(): JsonResponse
    {
        $messageTranslationKey = $this->getMessageTranslationKey();
        $data = $this->getDto()?->toArray() ?? $this->getData() ?? [];
        $responseCode = $this->getResponseCode()?->value ?? 418;

        $responseArray = [];

        if ($messageTranslationKey !== null) {
            $responseArray[self::KEY_MESSAGE] = trans($messageTranslationKey);
        }

        if (count($data) !== 0) {
            $responseArray[self::KEY_DATA] = $data;
        }

        return response()->json($responseArray, $responseCode);
    }
}
