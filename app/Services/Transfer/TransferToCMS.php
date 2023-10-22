<?php declare(strict_types=1);

namespace App\Services\Transfer;

use App\Attributes\TransferEntity;
use App\Clients\CMSClient;
use App\Normalizers\DefaultNormalizerInterface;
use App\Services\AttributeReader;
use Illuminate\Database\Eloquent\Model;
use LogicException;
use Psr\Log\LoggerInterface;
use ReflectionException;
use Throwable;

readonly class TransferToCMS
{
    public function __construct(
        private ?CMSClient $client = null,
        private ?LoggerInterface $logger = null,
    ) { }

    /**
     * @throws ReflectionException
     */
    public function transfer(Model $model, string $mode): void
    {
        $normalizer = $this->getNormalizerInstance($model::class);

        assert($normalizer instanceof DefaultNormalizerInterface);

        $data = $normalizer->normalize($model)->toArray();
        $normalizedModel['meta']['mode'] = $mode;
        $normalizedModel['data'] = $data;

        try {
            $this->client?->post($normalizedModel);
        } catch (Throwable $throwable) {
            $this->logger?->error($throwable);
        }
    }

    /**
     * @param class-string $classname
     * @throws ReflectionException
     */
    public function getNormalizerInstance(string $classname): object
    {
        $attributes = AttributeReader::readAttributes($classname);

        foreach ($attributes as $attribute) {
            if ($attribute->getName() !== TransferEntity::class) {
                continue;
            }

            return new ($attribute->getArguments()['normalizer']);
        }

        throw new LogicException('No normalizer for mode found');
    }
}
