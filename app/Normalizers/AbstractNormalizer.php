<?php declare(strict_types=1);

namespace App\Normalizers;

use App\DTOs\DefaultDtoInterface;
use App\Enums\TransferMode;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractNormalizer
{
    protected const KEY_DATA = 'data';
    protected const KEY_META = 'meta';
    protected const KEY_MODE = 'mode';
    protected const KEY_MODEL = 'model';

    /**
     * @return array<string, mixed>
     */
    public function normalize(Model $model, self $normalizer, TransferMode $mode): array
    {
        $data = $normalizer->normalizeData($model)->toArray();
        $meta = $normalizer->normalizeMeta($mode);

        return [
            self::KEY_DATA => $data,
            self::KEY_META => $meta,
        ];
    }

    abstract protected function normalizeData(Model $model): DefaultDtoInterface;

    /**
     * @return array<string, mixed>
     */
    protected function normalizeMeta(TransferMode $mode): array
    {
        return [
            self::KEY_MODE => $mode->value,
            self::KEY_MODEL => $this->getModelName(),
        ];
    }

    abstract protected function getModelName(): string;
}
