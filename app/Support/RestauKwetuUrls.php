<?php

namespace App\Support;

use Illuminate\Http\Request;

/**
 * URLs publiques cohérentes avec l’hôte/port de la requête (évite APP_URL erronée).
 */
final class RestauKwetuUrls
{
    public static function requestRoot(?Request $request = null): string
    {
        $request ??= request();

        if ($request !== null) {
            return rtrim($request->root(), '/');
        }

        return rtrim((string) config('app.url', 'http://localhost'), '/');
    }

    public static function publicLogoUrl(?Request $request = null): string
    {
        return self::requestRoot($request).'/assets/logo.jpg';
    }

    public static function publicStorageUrl(string $pathOnPublicDisk, ?Request $request = null): string
    {
        return self::requestRoot($request).'/storage/'.ltrim($pathOnPublicDisk, '/');
    }

    /**
     * Attribut HTML onerror : éviter json_encode("...") qui casse onerror="..." (guillemets imbriqués → erreurs JS).
     *
     * @return array<string, string>
     */
    public static function imgOnErrorFallbackToLogo(): array
    {
        $url = self::publicLogoUrl();
        $escaped = addcslashes($url, "\\'");

        return [
            'onerror' => "this.onerror=null;this.src='{$escaped}'",
        ];
    }
}
