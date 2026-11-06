<?php

declare(strict_types=1);

/**
 * @var string $pageTitle
 * @var string $content
 */
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="NikonCoach — Mentor y Asesor Fotográfico Personal de Martín para Nikon D5500, 18-55mm VR II y 18-200mm VR I.">
    <title><?= htmlspecialchars($pageTitle ?? 'NikonCoach — Mentor Fotográfico Personal') ?></title>
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
