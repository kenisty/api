<?php declare(strict_types=1);

namespace App\Services\Transfer;

use App\Attributes\TransferEntity;
use App\Jobs\TransferToCMS;
use App\Normalizers\DefaultNormalizerInterface;
use App\Services\AttributeReader;
use Illuminate\Database\Eloquent\Model;
use LogicException;
use ReflectionException;

readonly class TransferToCMSService
{
    /**
     * @throws ReflectionException
     */
    public function transfer(Model $model, string $mode): void
    {
        $normalizer = $this->getNormalizerInstance($model::class);

        assert($normalizer instanceof DefaultNormalizerInterface);

        $data = $normalizer->normalize($model)->toArray();
        $normalizedModel['meta']['mode'] = $mode;
        $normalizedModel['meta']['model'] = AttributeReader::getArgumentValue($model::class, TransferEntity::class, 'model');
        $normalizedModel['data'] = $data;

        TransferToCMS::dispatch($normalizedModel);
    }

    /**
     * @param class-string $classname
     * @throws ReflectionException
     */
    private function getNormalizerInstance(string $classname): object
    {
        $normalizer = AttributeReader::getArgumentValue($classname, TransferEntity::class, 'normalizer');

        if ($normalizer === null) {
            throw new LogicException('No normalizer for mode found');
        }

        return new $normalizer;
    }
}
