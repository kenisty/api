<?php declare(strict_types=1);

namespace App\Attributes;

use Attribute;

#[Attribute]
class TransferEntity
{
    public function __construct(
        public string $model,
        public string $normalizer,
    ) { }
}
