<?php

declare(strict_types=1);

/**
 * @var array<NikonCoach\Domain\Entities\Mission> $missions
 */
?>
<section class="page-container">
    <div class="page-header">
        <span class="section-tag">APRENDER HACIENDO • DESAFÍOS REALES</span>
        <h2>Misiones de Campo con tu Equipo</h2>
        <p>Retos fotográficos prácticos diseñados específicamente para tu <strong>Nikon D5500</strong>. Marcalas a medida que salgas a la calle a disparar para subir de nivel.</p>
    </div>

    <div class="missions-tracker panel-box">
        <div class="tracker-header">
            <div>
                <h3>Tu Progreso Fotográfico</h3>
                <p id="tracker-summary">0 de <?= count($missions) ?> misiones completadas</p>
            </div>
            <div class="tracker-badge" id="tracker-status-badge">📸 Aspirante a Pro</div>
        </div>
        <div class="progress-bar-container">
            <div id="missions-progress-bar" class="progress-bar-fill"></div>
        </div>
    </div>

    <div class="missions-grid">
        <?php foreach ($missions as $m): ?>
            <article class="mission-card" data-mission-id="<?= htmlspecialchars($m->id) ?>">
                <div class="mission-header">
                    <div class="mission-top">
                        <span class="mission-icon"><?= $m->badgeIcon ?></span>
                        <span class="mission-diff"><?= htmlspecialchars($m->difficulty) ?></span>
                    </div>
                    <h3><?= htmlspecialchars($m->title) ?></h3>
                    <p class="mission-desc"><?= htmlspecialchars($m->description) ?></p>
                </div>

                <div class="mission-gear-strip">
                    <span class="gear-tag">🎒 <?= htmlspecialchars($m->targetLensName) ?></span>
                    <span class="focal-tag">🔭 <?= htmlspecialchars($m->recommendedFocal) ?></span>
                </div>

                <div class="mission-badges-grid">
                    <div class="m-badge">
                        <span class="mb-lbl">Modo</span>
                        <span class="mb-val"><?= htmlspecialchars($m->cameraMode) ?></span>
                    </div>
                    <div class="m-badge">
                        <span class="mb-lbl">Apertura</span>
                        <span class="mb-val"><?= htmlspecialchars($m->targetAperture) ?></span>
                    </div>
                    <div class="m-badge">
                        <span class="mb-lbl">Velocidad</span>
                        <span class="mb-val"><?= htmlspecialchars($m->targetShutter) ?></span>
                    </div>
                    <div class="m-badge">
                        <span class="mb-lbl">ISO</span>
                        <span class="mb-val"><?= $m->targetIso ?></span>
                    </div>
                </div>

                <div class="mission-steps">
                    <strong>Pasos en la D5500:</strong>
                    <ul>
                        <?php foreach ($m->d5500Steps as $step): ?>
                            <li><?= htmlspecialchars($step) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="mission-challenge-box">
                    <strong>🎯 Reto de campo:</strong>
                    <p><?= htmlspecialchars($m->fieldChallenge) ?></p>
                </div>

                <div class="mission-footer">
                    <button type="button" class="btn btn-toggle-mission" data-mission-id="<?= htmlspecialchars($m->id) ?>">
                        <span class="check-box-icon">⬜</span>
                        <span class="btn-mission-text">Marcar como Completada</span>
                    </button>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
