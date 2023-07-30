<?php

namespace App\Enum;

enum ResponseCode: int
{
    case ACCEPTED_AND_CREATED_CODE = 201;
    case BAD_REQUEST_CODE = 400;
    case VALIDATION_FAILED_CODE = 422;
}
