<?php declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\Languages;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class Localization
{
    private const KEY_FALLBACK_LOCALE = 'en';

    public function handle(Request $request, Closure $next): Response
    {
        $acceptedLanguages = $request->getLanguages();
        $supportedLanguages = $this->getSupportedLanguages();

        foreach ($acceptedLanguages as $acceptedLanguage) {
            if (!in_array($acceptedLanguage, $supportedLanguages, true)) {
                continue;
            }

            App::setLocale($acceptedLanguage);

            return $next($request);
        }

        App::setLocale(self::KEY_FALLBACK_LOCALE);

        return $next($request);
    }

    /**
     * @return array<int, string>
     */
    private function getSupportedLanguages(): array
    {
        return [
            Languages::English->value,
            Languages::German->value,
        ];
    }
}
