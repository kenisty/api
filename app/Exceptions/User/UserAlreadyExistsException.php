<?php declare(strict_types=1);

namespace App\Exceptions\User;

use Exception;

class UserAlreadyExistsException extends Exception
{
    /** @var int $code */
    protected $code = 400;

    /** @var string $message */
    protected $message = 'A user exists with the same entry.';
}
