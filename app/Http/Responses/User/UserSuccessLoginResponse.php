<?php declare(strict_types=1);

namespace App\Http\Responses\User;

use App\DTOs\DefaultDTOInterface;
use App\Enum\ResponseCode;
use App\Http\Responses\Abstract\AbstractResponse;

class UserSuccessLoginResponse extends AbstractResponse
{
    protected ?string $messageTranslationKey = 'auth.login.success.response.message';

    protected ?ResponseCode $responseCode = ResponseCode::ACCEPTED;

    protected ?DefaultDTOInterface $dto = null;
}
