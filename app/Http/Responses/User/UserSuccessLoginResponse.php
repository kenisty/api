<?php

namespace App\Http\Responses\User;

use App\DTOs\DefaultDTOInterface;
use App\Enum\ResponseCode;
use App\Http\Responses\Abstract\AbstractResponse;

class UserSuccessLoginResponse extends AbstractResponse
{
    protected ?string $messageTranslationKey = 'login.response.success.message';
    protected ?ResponseCode $responseCode = ResponseCode::ACCEPTED;
    protected ?DefaultDTOInterface $dto = null;
}
