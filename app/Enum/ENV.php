<?php

namespace App\Enum;

enum ENV: string
{
    case DEV = 'local';
    case PROD = 'production';
}
