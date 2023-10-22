<?php declare(strict_types=1);

namespace App\Clients;

use Illuminate\Support\Facades\Http;

class CMSClient implements DefaultClientInterface
{
    public function post(array $data): void
    {
        Http::post('http://127.0.0.1:8080/api/receive', $data);
    }
}
