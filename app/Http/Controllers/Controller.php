<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Attributes\ApiVersion;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function __construct(string $classname, string $requestUri)
    {
        $class = new ReflectionClass($classname);
        $attributes = $class->getAttributes();

        foreach ($attributes as $attribute) {
            $this->checkApiVersion($attribute, $requestUri);
        }
    }

    /**
     * @throws Exception
     */
    private function checkApiVersion(ReflectionAttribute $attribute, string $requestUri): void {
        if ($attribute->getName() !== ApiVersion::class) {
            return;
        }

        $arguments = $attribute->getArguments();
        $sinceVersion = $arguments['since'];
        $untilVersion = $arguments['until'] ?? 99999;
        $currentVersion = $this->getApiVersionFromRequestUri($requestUri);

        if ($sinceVersion > $untilVersion) {
            throw new Exception('The since version can\'t be higher that the until version');
        }

        if ($sinceVersion > $currentVersion || $untilVersion < $currentVersion) {
            throw new Exception('The requested class is not compatible with the current api version');
        }
    }

    private function getApiVersionFromRequestUri(string $requestUri): int {
        $uri = array_values(array_filter(explode('http://localhost:8000/', $requestUri)))[0];
        $version = explode('/', $uri)[0];

        return intval(array_values(array_filter(explode('v', $version)))[0]);
    }
}
