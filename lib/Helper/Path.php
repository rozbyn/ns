<?php

namespace RozbynDev\Helper;

class Path
{
    public static function getPathUrl(string $path): string
    {
        if (str_starts_with($path, $_SERVER['DOCUMENT_ROOT'])) {
            $path = substr($path, strlen($_SERVER['DOCUMENT_ROOT']));
        }
        $httpPrfx = self::isHttpsOn() ? 'https' : 'http';
        return "$httpPrfx://{$_SERVER['SERVER_NAME']}$path";
    }


    public static function isHttpsOn(): bool
    {
        return
            $_SERVER['HTTP_HTTPS'] === 'on'
            || $_SERVER['SERVER_PORT'] === '443'
            || $_SERVER['HTTP_X_FORWARDED_PORT'] === '443'
            || $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https'
            || $_SERVER['HTTP_X_SECURITY'] === 'on'
        ;
    }
}
