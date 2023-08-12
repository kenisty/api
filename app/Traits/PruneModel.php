<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Prunable;

trait PruneModel
{
    use Prunable;

    public const DAYS = 30;

    public function prunable(): Builder
    {
        return static::where('deleted_at', '<=', now()->subDays(self::DAYS));
    }

    protected function pruning(): void
    {
        // Move models to a different database (warehouse)
    }
}
