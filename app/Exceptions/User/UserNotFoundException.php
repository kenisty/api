<?php

namespace App\Exceptions\User;

use Exception;

class UserNotFoundException extends Exception
{
    protected $code = '404';
    protected $message = 'The user with the provided credentials was not found. Please check the information you entered and try again or contact support for assistance.';
}
