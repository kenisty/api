<?php

declare(strict_types=1);

namespace App\Exceptions\User;

use Exception;

class InvalidPasswordException extends Exception
{
    protected $code = 422;
    protected $message = 'The password you entered is incorrect. Please ensure you\'ve typed it accurately and try again.';
}
