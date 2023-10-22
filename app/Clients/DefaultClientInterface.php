<?php declare(strict_types=1);

namespace App\Clients;

interface DefaultClientInterface
{
    /**
     * @param array<string, mixed> $data
     */
    public function post(array $data): void;
}
