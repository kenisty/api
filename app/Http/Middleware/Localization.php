<?php declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
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

    private function getSupportedLanguages(): array
    {
        return collect(File::directories(lang_path()))->map(static fn ($directory) => explode(lang_path() . '\\', $directory)[1])->toArray();
    }
}
