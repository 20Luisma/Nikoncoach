<?php

declare(strict_types=1);

namespace NikonCoach\Infrastructure\Observability;

use NikonCoach\Infrastructure\Config;
use Throwable;

/**
 * Logger estructurado fail-safe con soporte opcional de Sentry DSN.
 * Nunca debe interrumpir el flujo de la aplicación si falla el disco o la red.
 */
final class ErrorLogger
{
    private string $logFile;
    private string $sentryDsn;
    private string $environment;

    public function __construct(?string $logFile = null, ?string $sentryDsn = null, ?string $environment = null)
    {
        $defaultDir = dirname(__DIR__, 3) . '/storage/logs';
        $this->logFile = $logFile ?? ($defaultDir . '/app.log');
        $this->sentryDsn = $sentryDsn ?? (string) Config::get('SENTRY_DSN', '');
        $this->environment = $environment ?? (string) Config::get('APP_ENV', 'development');
    }

    /**
     * Registra los handlers globales de excepciones y errores fatales.
     */
    public function register(): void
    {
        set_exception_handler(function (Throwable $exception): void {
            $this->captureException($exception);

            if (!headers_sent()) {
                http_response_code(500);
                header('Content-Type: application/json; charset=utf-8');
                header('X-Content-Type-Options: nosniff');
            }

            echo json_encode([
                'success' => false,
                'error' => 'Ocurrió un error interno inesperado. Revisá los logs del servidor.',
            ], JSON_UNESCAPED_UNICODE);
        });
    }

    /**
     * Registra una excepción en formato JSON estructurado.
     *
     * @param array<string, mixed> $context
     */
    public function captureException(Throwable $exception, array $context = []): void
    {
        $this->log('error', $exception->getMessage(), array_merge($context, [
            'exception_class' => $exception::class,
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'sentry_enabled' => $this->sentryDsn !== '',
        ]));
    }

    /**
     * Escribe una entrada JSON estructurada en el archivo de logs (fail-safe).
     *
     * @param array<string, mixed> $context
     */
    public function log(string $level, string $message, array $context = []): void
    {
        try {
            $dir = dirname($this->logFile);
            if (!is_dir($dir)) {
                @mkdir($dir, 0755, true);
            }

            $entry = [
                'timestamp' => gmdate('c'),
                'level' => strtolower($level),
                'env' => $this->environment,
                'message' => $message,
                'context' => $context,
            ];

            $encoded = json_encode($entry, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            if ($encoded !== false) {
                @file_put_contents($this->logFile, $encoded . PHP_EOL, FILE_APPEND | LOCK_EX);
            }
        } catch (Throwable) {
            // Fail-safe: nunca propagar errores del logger a la aplicación.
        }
    }

    public function hasSentryDsn(): bool
    {
        return $this->sentryDsn !== '';
    }

    public function getLogFile(): string
    {
        return $this->logFile;
    }
}
