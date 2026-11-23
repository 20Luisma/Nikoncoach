<?php

declare(strict_types=1);

/**
 * Vista agregada legacy — delega en los partials dedicados de templates/pages/
 * para mantener DRY y cero duplicación con la arquitectura multi-página.
 */
$pagePartials = [
    'scanner',
    'gear',
    'backpack',
    'recipe',
    'simulator',
    'missions',
    'mentor',
];

foreach ($pagePartials as $partial) {
    require __DIR__ . '/pages/' . $partial . '.php';
}
