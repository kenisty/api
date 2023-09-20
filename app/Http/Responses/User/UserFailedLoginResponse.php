<?php declare(strict_types=1);

namespace App\Http\Responses\User;

use App\DTOs\DefaultDTOInterface;
use App\Enum\ResponseCode;
use App\Http\Responses\Abstract\AbstractResponse;

class UserFailedLoginResponse extends AbstractResponse
{
    protected ?string $messageTranslationKey = 'login.response.fail.message';

    protected ?ResponseCode $responseCode = ResponseCode::BAD_REQUEST;

    protected ?DefaultDTOInterface $dto = null;
}
