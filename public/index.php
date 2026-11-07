<?php

declare(strict_types=1);

// Registrar autoloader simple PSR-4 para NikonCoach\
spl_autoload_register(function (string $class) {
    $prefix = 'NikonCoach\\';
    $baseDir = __DIR__ . '/../src/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

use NikonCoach\Application\UseCases\AskMentorUseCase;
use NikonCoach\Application\UseCases\CalculateExposureUseCase;
use NikonCoach\Application\UseCases\RecommendLensUseCase;
use NikonCoach\Infrastructure\AI\GeminiClient;
use NikonCoach\Infrastructure\Config;
use NikonCoach\Infrastructure\Repositories\EquipmentRepository;
use NikonCoach\Infrastructure\Repositories\MissionRepository;
use NikonCoach\Presentation\Controllers\ApiController;
use NikonCoach\Presentation\Controllers\HomeController;

// Cargar variables de entorno
Config::load(__DIR__ . '/..');

// Inyección de dependencias
$equipmentRepo = new EquipmentRepository();
$missionRepo = new MissionRepository();
$recommendLensUseCase = new RecommendLensUseCase($equipmentRepo);
$calculateExposureUseCase = new CalculateExposureUseCase($equipmentRepo);
$geminiClient = new GeminiClient();
$askMentorUseCase = new AskMentorUseCase($geminiClient);

$homeController = new HomeController($equipmentRepo, $missionRepo);
$apiController = new ApiController(
    $recommendLensUseCase,
    $calculateExposureUseCase,
    $askMentorUseCase
);

// Manejo de URL base (soporte local y subcarpeta en Hostinger: /NikonCoach/)
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($requestUri, PHP_URL_PATH) ?? '/';

// Normalizar quitando prefijos de subcarpeta como /NikonCoach o /NikonCoach/public
$path = preg_replace('#^/NikonCoach(/public)?#i', '', $path);
$path = '/' . trim($path, '/');

// Enrutador
switch ($path) {
    case '/':
    case '/index.php':
        $homeController->index();
        break;

    case '/api/recommend-lens':
        $apiController->recommendLens();
        break;

    case '/api/calculate-exposure':
        $apiController->calculateExposure();
        break;

    case '/api/mentor-chat':
        $apiController->mentorChat();
        break;

    default:
        http_response_code(404);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'error' => 'Ruta no encontrada',
            'requested_path' => $path
        ], JSON_UNESCAPED_UNICODE);
        break;
}

