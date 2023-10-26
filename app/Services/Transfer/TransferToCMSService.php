<?php declare(strict_types=1);

namespace App\Services\Transfer;

use App\Attributes\TransferEntity;
use App\Enums\TransferMode;
use App\Jobs\TransferToCMS;
use App\Normalizers\AbstractNormalizer;
use App\Services\AttributeReader;
use Illuminate\Database\Eloquent\Model;
use LogicException;
use ReflectionException;

readonly class TransferToCMSService
{
    protected const KEY_NORMALIZER = 'normalizer';

    /**
     * @throws ReflectionException
     */
    public function transfer(Model $model, TransferMode $mode): void
    {
        $normalizer = $this->getNormalizerInstance($model);

        assert($normalizer instanceof AbstractNormalizer);

        TransferToCMS::dispatch($normalizer->normalize($model, $normalizer, $mode));
    }

    /**
     * @throws ReflectionException
     */
    private function getNormalizerInstance(Model $model): mixed
    {
        return new (AttributeReader::getArgumentValue($model::class, TransferEntity::class, self::KEY_NORMALIZER) ?? new LogicException('No normalizer for model found'));
    }
}
