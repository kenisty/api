<?php declare(strict_types=1);

namespace App\Attributes;

use Attribute;

#[Attribute]
class ApiVersion
{
    public function __construct(public int $since, public int $until) { }
}
