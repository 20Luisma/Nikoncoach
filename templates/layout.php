<?php

declare(strict_types=1);

/**
 * @var string $pageTitle
 * @var string $content
 * @var string $currentPage
 */
$basePath = str_contains($_SERVER['REQUEST_URI'] ?? '', '/NikonCoach') ? '/NikonCoach' : '';
$currentPage = $currentPage ?? 'escaner';

$navItems = [
    'escaner' => ['url' => $basePath . '/', 'icon' => '📸', 'label' => 'Escáner IA'],
    'mochila' => ['url' => $basePath . '/mochila', 'icon' => '🧭', 'label' => 'Mochila'],
    'receta' => ['url' => $basePath . '/receta', 'icon' => '⚙️', 'label' => 'Receta D5500'],
    'simulador' => ['url' => $basePath . '/simulador', 'icon' => '🔭', 'label' => 'Simulador DX'],
    'misiones' => ['url' => $basePath . '/misiones', 'icon' => '🎯', 'label' => 'Misiones'],
    'mentor' => ['url' => $basePath . '/mentor', 'icon' => '🧠', 'label' => 'Mentor IA'],
    'equipo' => ['url' => $basePath . '/equipo', 'icon' => '🎒', 'label' => 'Tu Equipo'],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title><?= htmlspecialchars($pageTitle ?? 'NikonCoach — Mentor Fotográfico Personal') ?></title>
    <meta name="description" content="NikonCoach — Mentor y Asesor Fotográfico Personal de Martín para Nikon D5500, 18-55mm VR II y 18-200mm VR I.">
    
    <!-- PWA & Mobile Web App Meta Tags -->
    <meta name="theme-color" content="#0B0E14">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="NikonCoach">
    
    <link rel="icon" type="image/svg+xml" href="<?= $basePath ?>/assets/icon.svg">
    <link rel="apple-touch-icon" href="<?= $basePath ?>/assets/icon-192.png">
    <link rel="manifest" href="<?= $basePath ?>/manifest.json">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $basePath ?>/css/style.css">
</head>
<body data-base-path="<?= htmlspecialchars($basePath) ?>" data-page="<?= htmlspecialchars($currentPage) ?>">
    <div class="app-container">
        <!-- Header Principal -->
        <header class="app-header">
            <div class="brand">
                <a href="<?= $basePath ?>/" class="brand-link">
                    <div class="brand-badge">
                        <span class="nikon-stripe"></span>
                        <span class="nikon-stripe red"></span>
                        <span class="brand-text">NIKON COACH</span>
                    </div>
                    <h1 class="main-title">Mentor y Asesor de Martín</h1>
                </a>
            </div>

            <div class="header-actions">
                <button type="button" id="btn-install-app" class="btn-install-pwa hidden">
                    <span>📲</span> Instalar App
                </button>
                <div class="camera-pill">
                    <span class="pill-dot"></span>
                    <span class="pill-text">Nikon D5500 DX • 1.5x</span>
                </div>
            </div>
        </header>

        <!-- Barra de Navegación Desktop y Tablets -->
        <nav class="desktop-nav" aria-label="Navegación principal">
            <?php foreach ($navItems as $key => $item): ?>
                <a href="<?= htmlspecialchars($item['url']) ?>" 
                   class="nav-tab-item <?= $currentPage === $key ? 'active' : '' ?>">
                    <span class="tab-icon"><?= $item['icon'] ?></span>
                    <span class="tab-label"><?= htmlspecialchars($item['label']) ?></span>
                </a>
            <?php endforeach; ?>
        </nav>

        <!-- Contenido de la página activa -->
        <main class="page-content-wrapper">
            <?= $content ?>
        </main>

        <!-- Footer -->
        <footer class="app-footer">
            <div class="footer-content">
                <div class="footer-brand">
                    <span class="nikon-stripe-sm"></span>
                    <strong>NikonCoach</strong> — Diseñado para Martín (Esparreguera, Barcelona)
                </div>
                <div class="footer-meta">
                    <span>Nikon D5500 + 18-55mm VR II + 18-200mm VR I</span>
                    <span>PHP 8.4 Clean Architecture • Google Gemini 3.8 Flash</span>
                </div>
            </div>
        </footer>
    </div>

    <!-- Barra de Navegación Inferior Móvil (Mobile Bottom Tab Bar) -->
    <nav class="mobile-bottom-bar" aria-label="Navegación móvil">
        <div class="bottom-bar-inner">
            <?php foreach ($navItems as $key => $item): ?>
                <a href="<?= htmlspecialchars($item['url']) ?>" 
                   class="bottom-nav-item <?= $currentPage === $key ? 'active' : '' ?>">
                    <span class="b-icon"><?= $item['icon'] ?></span>
                    <span class="b-label"><?= htmlspecialchars($item['label']) ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </nav>

    <script src="<?= $basePath ?>/js/app.js"></script>
</body>
</html>
