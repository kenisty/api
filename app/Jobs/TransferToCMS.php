<?php declare(strict_types=1);

namespace App\Jobs;

use App\Clients\CMSClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TransferToCMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @param array<string, mixed> $normalizedModel
     */
    public function __construct(
        private readonly array $normalizedModel,
    ) { }

    public function handle(CMSClient $client): void
    {
        $client->post($this->normalizedModel);
    }
}
