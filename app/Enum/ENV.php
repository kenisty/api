<?php

declare(strict_types=1);

namespace App\Enum;

enum ENV: string
{
    case DEV = 'local';
    case PROD = 'production';
}
