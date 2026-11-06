<?php

declare(strict_types=1);

namespace NikonCoach\Domain\Entities;

/**
 * Representa el tipo de situación o escena que Martín quiere fotografiar.
 */
final readonly class PhotoScene
{
    public function __construct(
        public string $type, // 'street', 'landscape', 'portrait', 'food_macro', 'action_sports', 'night_city', 'family'
        public string $title,
        public string $description,
        public int $subjectDistanceCm,
        public string $subjectMovement, // 'static', 'slow', 'fast'
        public string $lightLevel, // 'bright_sun', 'overcast_golden', 'indoor', 'twilight', 'night'
        public string $bokehGoal, // 'maximum_bokeh', 'balanced', 'sharp_everywhere'
        public bool $isWalkingLongDistance = false
    ) {}
}

