<?php

declare(strict_types=1);

namespace App\Enum;

enum ResponseStatus: string
{
    case SUCCESS = 'success';
    case CREATED = 'created';
    case FAILED = 'failed';
    case VALIDATION_FAILED = 'validation_failed';
    case RESOURCE_CREATION_FAILED = 'resource_creation_failed';
}
