<?php

namespace App\Http\Responses\User;

use App\Enum\ResponseCode;
use App\Http\Responses\Abstract\AbstractResponse;

class UserFailedLoginResponse extends AbstractResponse
{
    private string $messageTranslationKey = 'login.response.fail.message';
    private ResponseCode $responseCode = ResponseCode::BAD_REQUEST;

    protected function setResponseCode(ResponseCode $responseCode): self
    {
        $this->responseCode = $responseCode;

        return $this;
    }

    protected function getResponseCode(): ResponseCode
    {
        return $this->responseCode;
    }

    protected function setMessageTranslationKey(string $key): self
    {
        $this->messageTranslationKey = $key;

        return $this;
    }

    protected function getMessageTranslationKey(): ?string
    {
        return $this->messageTranslationKey;
    }
}