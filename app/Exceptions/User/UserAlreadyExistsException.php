<?php

namespace App\Exceptions\User;

use Exception;

class UserAlreadyExistsException extends Exception
{
    protected $code = '400';
    protected $message = 'A user exists with the same entry';
}
