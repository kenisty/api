<?php declare(strict_types=1);

namespace App\Models\Traits;

use App\Services\Transfer\TransferToCMSService;
use Illuminate\Database\Eloquent\Model;
use ReflectionException;

trait RequestTransferEntityTrait
{
    /**
     * @throws ReflectionException
     */
    protected static function boot():  void
    {
        parent::boot();
        static::created(static fn (Model $model) => (new TransferToCMSService())->transfer($model, 'create'));
        static::updated(static fn (Model $model) => (new TransferToCMSService())->transfer($model, 'update'));
        static::deleted(static fn (Model $model) => (new TransferToCMSService())->transfer($model, 'delete'));
    }
}
