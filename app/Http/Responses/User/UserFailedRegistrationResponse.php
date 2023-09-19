<?php

namespace App\Http\Responses\User;

use App\DTOs\DefaultDTOInterface;
use App\Enum\ResponseCode;
use App\Http\Responses\Abstract\AbstractResponse;

class UserFailedRegistrationResponse extends AbstractResponse
{
    protected ?string $messageTranslationKey = 'register.response.fail.message';
    protected ?ResponseCode $responseCode = ResponseCode::BAD_REQUEST;
    protected ?DefaultDTOInterface $dto = null;
}
