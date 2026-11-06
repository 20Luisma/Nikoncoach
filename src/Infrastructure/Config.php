<?php

declare(strict_types=1);

namespace NikonCoach\Infrastructure;

final class Config
{
    private static ?array $envData = null;

    public static function load(string $rootPath): void
    {
        if (self::$envData !== null) {
            return;
        }

        self::$envData = [];
        $envFile = rtrim($rootPath, '/') . '/.env';

        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line === '' || str_starts_with($line, '#')) {
                    continue;
                }
                if (str_contains($line, '=')) {
                    [$key, $value] = explode('=', $line, 2);
                    $key = trim($key);
                    $value = trim($value);
                    $value = trim($value, '"\'');
                    self::$envData[$key] = $value;
                    if (!isset($_ENV[$key])) {
                        $_ENV[$key] = $value;
                    }
                }
            }
        }
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        if (isset(self::$envData[$key])) {
            return self::$envData[$key];
        }
        if (isset($_ENV[$key])) {
            return $_ENV[$key];
        }
        $val = getenv($key);
        if ($val !== false) {
            return $val;
        }
        return $default;
    }
}
