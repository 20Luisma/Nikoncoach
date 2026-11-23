<?php

declare(strict_types=1);

namespace NikonCoach\Tests\Unit\Infrastructure;

use NikonCoach\Infrastructure\Config;
use NikonCoach\Infrastructure\Observability\ErrorLogger;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class ConfigAndLoggerTest extends TestCase
{
    public function testConfigReadsDefaultAndEnvironmentValues(): void
    {
        $tmpDir = sys_get_temp_dir() . '/nikoncoach_env_' . uniqid('', true);
        mkdir($tmpDir, 0755, true);
        file_put_contents($tmpDir . '/.env', "# Comentario\n\nTEST_CFG_FOO=\"bar_value\"\nTEST_CFG_NUM=42\n");

        $ref = new \ReflectionProperty(Config::class, 'envData');
        $ref->setValue(null, null);

        try {
            Config::load($tmpDir);
            Config::load($tmpDir); // Segunda llamada idempotente
            self::assertSame('bar_value', Config::get('TEST_CFG_FOO'));
            self::assertSame('42', Config::get('TEST_CFG_NUM'));
            self::assertSame('valor-defecto', Config::get('CLAVE_INEXISTENTE_TEST_999', 'valor-defecto'));

            $_ENV['NIKON_TEST_KEY'] = 'd5500-ok';
            self::assertSame('d5500-ok', Config::get('NIKON_TEST_KEY'));
            unset($_ENV['NIKON_TEST_KEY'], $_ENV['TEST_CFG_FOO'], $_ENV['TEST_CFG_NUM']);
        } finally {
            $ref->setValue(null, null);
            @unlink($tmpDir . '/.env');
            @rmdir($tmpDir);
        }
    }

    public function testErrorLoggerWritesStructuredJsonFailSafe(): void
    {
        $tmpLog = sys_get_temp_dir() . '/nikoncoach_test_' . uniqid('', true) . '.log';

        try {
            $logger = new ErrorLogger($tmpLog, 'https://public@sentry.example/1', 'testing');
            self::assertTrue($logger->hasSentryDsn());
            self::assertSame($tmpLog, $logger->getLogFile());

            $logger->captureException(new RuntimeException('Fallo simulado de obturador'), ['route' => '/api/test']);

            self::assertFileExists($tmpLog);
            $content = (string) file_get_contents($tmpLog);
            $decoded = json_decode(trim($content), true);

            self::assertIsArray($decoded);
            self::assertSame('error', $decoded['level']);
            self::assertSame('testing', $decoded['env']);
            self::assertSame('Fallo simulado de obturador', $decoded['message']);
            self::assertSame(RuntimeException::class, $decoded['context']['exception_class']);
            self::assertTrue($decoded['context']['sentry_enabled']);
        } finally {
            if (file_exists($tmpLog)) {
                @unlink($tmpLog);
            }
        }
    }
}
