<?php

declare(strict_types=1);

/**
 * @var string $pageTitle
 * @var string $content
 */
$basePath = str_contains($_SERVER['REQUEST_URI'] ?? '', '/NikonCoach') ? '/NikonCoach' : '';
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
<body data-base-path="<?= htmlspecialchars($basePath) ?>">
    <?= $content ?>
    <script src="<?= $basePath ?>/js/app.js"></script>
</body>
</html>
