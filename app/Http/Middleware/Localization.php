<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpFoundation\Response;

class Localization
{
    private const KEY_FALLBACK_LOCALE = 'en';

    public function handle(Request $request, Closure $next): Response
    {
        $acceptedLanguages = $request->getLanguages();
        $supportedLanguages = $this->getSupportedLanguages();

        foreach ($acceptedLanguages as $acceptedLanguage) {
            if (!$supportedLanguages->contains($acceptedLanguage)) {
                continue;
            }

            App::setLocale($acceptedLanguage);

            return $next($request);
        }

        App::setLocale(self::KEY_FALLBACK_LOCALE);

        return $next($request);
    }

    private function getSupportedLanguages(): Collection
    {
        $langPath = lang_path();

        if (!File::isDirectory($langPath)) {
            throw new DirectoryNotFoundException();
        }

        return collect(File::files($langPath))->map(function (SplFileInfo $file) {
            $dirStrArray = explode('.json', $file->getFileInfo()->getFilename());

            return $dirStrArray[0];
        });
    }
}
