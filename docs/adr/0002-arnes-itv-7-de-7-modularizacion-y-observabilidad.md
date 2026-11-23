# ADR 0002 — Arnés de Calidad ITV 7/7, Modularización ES y Observabilidad Fail-Safe

- **Fecha:** 2026-11-23
- **Estado:** Aceptada

## Contexto
NikonCoach creció hasta incluir 7 páginas dedicadas, integración multimodal con Gemini 3.8 Flash y PWA WebAPK en Android. Al pasar la inspección local de calidad (ITV de Código), el proyecto quedaba en `APTO_CON_OBSERVACIONES` (3/7 aptas) por:
- Ausencia de análisis estático de tipos (PHPStan / TypeScript) y lockfiles auditables (`composer.lock`, `package-lock.json`).
- Ausencia de suite de tests unitarios con cobertura medible (≥ 75%) y pruebas E2E en navegador real.
- Deuda técnica en `public/js/app.js` (935 líneas / 145 ramas) y duplicación de vistas entre `templates/home.php` y `templates/pages/*.php`.
- Falta de observabilidad global fail-safe ante excepciones no capturadas en runtime.

## Decisión
1. **Dependencias solo de desarrollo (Cero bloat en producción):** incorporar `composer.json`/`composer.lock` (`phpstan/phpstan` nivel 5, `phpunit/phpunit` 11.5 con cobertura Xdebug) y `package.json`/`package-lock.json` (`typescript` con `checkJs: true`, `@playwright/test`), manteniendo `vendor/` y `node_modules/` fuera de Git y excluidos en `bin/deploy.sh`. Producción sigue ejecutándose con PHP 8.4 puro y cero dependencias externas.
2. **Modularización ES nativa del Frontend:** dividir `public/js/app.js` en un entrypoint ligero (<35 líneas) más 8 módulos ES en `public/js/modules/` (`scanner`, `backpack`, `exposure`, `simulator`, `missions`, `mentor`, `pwa`, `formatters`) cargados con `<script type="module">` sin paso de build ni bundlers.
3. **DRY en vistas:** convertir `templates/home.php` en un wrapper que delega en `templates/pages/*.php`.
4. **Observabilidad fail-safe:** crear `src/Infrastructure/Observability/ErrorLogger.php` registrado en `public/index.php` mediante `set_exception_handler`, escribiendo logs JSON estructurados locales y soportando `SENTRY_DSN` opcional desde `.env` sin romper nunca el flujo si falta configuración.

## Consecuencias
- **Positivas:** el repositorio alcanza **7/7 APTO real** en la ITV de Código (6/6 controles de seguridad al 100%, 83.86% cobertura real, 6/6 E2E en Chromium), PHPStan detectó y permitió corregir un bug real en `GeminiClient.php`, y el deploy a Hostinger mantiene el mismo peso ligero.
- **Trade-offs:** en local se requiere correr `composer install && npm install` (y `npx playwright install chromium` la primera vez) para ejecutar el arnés de calidad completo.
