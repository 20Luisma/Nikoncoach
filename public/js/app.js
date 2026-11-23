/**
 * NikonCoach — Entrypoint modular del Frontend.
 * Orquesta los módulos ES independientes según los elementos presentes en la página activa.
 */
import { initScanner } from './modules/scanner.js';
import { initBackpack } from './modules/backpack.js';
import { initExposureCalculator } from './modules/exposure.js';
import { initSimulator } from './modules/simulator.js';
import { initMissions } from './modules/missions.js';
import { initMentorChat } from './modules/mentor.js';
import { initPwa } from './modules/pwa.js';

document.addEventListener('DOMContentLoaded', () => {
    const basePath = document.body.dataset.basePath || '';

    const tabLinks = document.querySelectorAll('.tab-link');
    tabLinks.forEach((tab) => {
        tab.addEventListener('click', () => {
            tabLinks.forEach((t) => t.classList.remove('active'));
            tab.classList.add('active');
        });
    });

    initScanner(basePath);
    initBackpack(basePath);
    initExposureCalculator(basePath);
    initSimulator();
    initMissions();
    initMentorChat(basePath);
    initPwa(basePath);
});
