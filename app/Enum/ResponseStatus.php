<?php

namespace App\Enum;

enum ResponseStatus: string
{
    case SUCCESS = 'success';
    case CREATED = 'created';
    case VALIDATION_FAILED = 'validation_failed';
    case RESOURCE_CREATION_FAILED = 'resource_creation_failed';
}
