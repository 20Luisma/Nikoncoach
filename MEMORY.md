# 🧠 MEMORY.md — NikonCoach

## 🌍 Contexto General del Proyecto

**NikonCoach** es el mentor y asesor fotográfico personal de Martín para su cámara **Nikon D5500** y sus dos lentes:
- **AF-S DX NIKKOR 18-55mm f/3.5-5.6G VR II** (Retráctil, 195g, enfoque a 25 cm)
- **AF-S DX VR Zoom-Nikkor 18-200mm f/3.5-5.6G IF-ED** (Superzoom VR I rojo, 560g, enfoque mínimo a 50 cm)

**Misión:** Convertir a Martín en un fotógrafo experto con su propio equipo a través de la práctica real, resolviendo dudas de campo ("¿cuál lente llevo?", "¿cómo configuro para esta foto?") y dándole recetas botón a botón en lenguaje rioplatense claro.

**Propietario:** Martín (Esparreguera, Barcelona)  
**Hostinger:** `https://contenido.creawebes.com/NikonCoach/`  
**GitHub:** `https://github.com/20Luisma/Nikoncoach`

---

## 🏗️ Arquitectura Técnica

- **Backend:** PHP 8.4+ estricto — Clean Architecture (Domain / Application / Infrastructure / Presentation)
- **Frontend:** HTML5 semántico + CSS3 (Design Tokens, Dark Mode Nikon con acento amarillo `#FFE600`, 100% Responsive Móvil) + Vanilla JS modular
- **PWA / WebAPK:** Manifest PWA estricto, Service Worker v11 offline, iconografía nativa Quartz 192x192 y 512x512 con cabeceras no-cache y CORS `*` para compilación WebAPK Android
- **IA:** Google Gemini 3.8 Flash (`thinkingBudget: 0`, respuestas ultra-rápidas) con fallback de conocimiento determinista
- **Servidor:** Hostinger VPS vía `bin/deploy.sh` blindado con permisos `.env` (`chmod 600`)
- **Sin dependencias externas ni frameworks pesados**

---

## 📷 Especificaciones de Hardware Integradas

| Parámetro | Nikon D5500 | 18-55mm VR II | 18-200mm VR I |
|---|---|---|---|
| **Tipo** | Cámara Réflex Digital | Zoom Estándar Retráctil | Superzoom Todoterreno |
| **Sensor** | DX (APS-C 24.2 MP, 1.5x) | - | - |
| **Rango Focal** | - | 18–55 mm (27–82.5 mm eq.) | 18–200 mm (27–300 mm eq.) |
| **Apertura** | - | $f/3.5$ a $f/5.6$ | $f/3.5$ a $f/5.6$ |
| **Peso** | 420 g (cuerpo) | 195 g | 560 g |
| **Enfoque mín.** | - | **25 cm** | **50 cm** |
| **Filtro** | 52 mm | 72 mm |
| **Estabilizador** | - | VR II (~4 pasos) | VR I (~3 pasos, modo Active) |

---

## 📌 Estado Actual del Proyecto

- [x] Bootstrap completo del proyecto (estructura, AGENTS.md, MEMORY.md, .gitignore)
- [x] Entidades de dominio modeladas: `CameraProfile.php`, `Lens.php`, `PhotoScene.php`, `ShootingRecommendation.php`, `Mission.php`
- [x] Repositorio de hardware con especificaciones exactas: `EquipmentRepository.php`
- [x] Repositorio de misiones prácticas: `MissionRepository.php` (5 retos guiados con el equipo real)
- [x] Caso de uso 1: `RecommendLensUseCase.php` (lógica de peso vs focal vs límite físico de 50cm)
- [x] Caso de uso 2: `CalculateExposureUseCase.php` (receta de parámetros A/S/M, f/8 sweet spot, velocidad segura DX e instrucciones botón a botón en la D5500)
- [x] Caso de uso 3: `GetMissionsUseCase.php` (listado y checklist interactivo)
- [x] Integración de mentor IA: `GeminiClient.php` y `AskMentorUseCase.php` con Gemini 3.8 Flash y fallback inteligente
- [x] Controladores y Front Controller: `HomeController.php`, `ApiController.php`, `public/index.php`
- [x] UI Dark Mode Nikon & Simulador Visual DX: `templates/home.php`, `templates/layout.php`, `public/css/style.css`
- [x] Optimización 100% móvil: inputs con font-size 16px (sin auto-zoom iOS), touch targets de 48px, scroll táctil horizontal
- [x] Lógica interactiva en cliente: `public/js/app.js` (alerta de 50cm, simulador de focal 18-200mm con visor óptico animado, tracker de misiones con `localStorage`, chat interactivo)
- [x] Validación y tests del dominio: 8/8 tests aprobados
- [x] Escáner de Escena con Foto del Móvil (IA Vision Multimodal con Gemini 3.8 Flash): subís una foto del lugar tomada con tu celular, la IA analiza la iluminación/distancia y te da la receta botón a botón para la D5500 + 3 ideas de encuadre + chat interactivo para repreguntar
- [x] Rediseño de arquitectura multi-página: cada sección convertida en su propia página dedicada (`/`, `/mochila`, `/receta`, `/simulador`, `/misiones`, `/mentor`, `/equipo`)
- [x] Navegación moderna dual: pills horizontales en desktop y Mobile Bottom Tab Bar fijada abajo estilo app nativa (iOS / Android) con safe-area
- [x] Simulador Visual de Focal y Compresión rediseñado: dial giratorio interactivo con slider estilo anillo de zoom Nikon, tarjetas escénicas y visor réflex OLED
- [x] PWA WebAPK en Android 100% instalable y verificado en el dispositivo móvil real de Martín (calibrado contra Vuelos Martín, con íconos dedicados `app-icon-*.png`, Service Worker v11, cabeceras anti-caché de CDN y soporte completo de Chrome WebAPK)
- [x] Subida a GitHub (`https://github.com/20Luisma/Nikoncoach`)
- [x] Despliegue a Hostinger (`https://contenido.creawebes.com/NikonCoach/`) con verificación HTTP 200
- [x] **ITV de Código 7/7 APTO en verde real** (6/6 controles de seguridad al 100%, PHPStan nivel 5 + `tsc --noEmit` 0 errores, PHPUnit 25 tests / 83.86% cobertura real, Playwright 6/6 E2E en Chromium, JS modularizado en ES Modules, `templates/home.php` DRY, observabilidad fail-safe `ErrorLogger`)

---

## 🚀 Próximos Pasos Prioritarios

1. Diagrama interactivo SVG de los botones físicos de la Nikon D5500.
2. Guardar favoritos de recetas de disparo frecuentes en `localStorage`.

---

## 🕰️ Historial de Sesiones

### 2026-11-23 (Sesión 6 — Arnés ITV 7/7 Real en Verde, Refactor Modular y Observabilidad)
- **Estación 1 y 4:** Agregados `composer.json`/`composer.lock` y `package.json`/`package-lock.json` con `0` CVEs (`composer audit` + `npm audit`) y checklist de seguridad al **100% (6/6)**. Sanitizado `.env.example` sin credenciales reales.
- **Estación 2 (Tipos):** Configurados `phpstan.neon` (nivel 5) y `tsconfig.json` (`checkJs: true`, `tsc --noEmit`). Corregido bug real detectado por PHPStan en `GeminiClient.php` (`elseif` vacío de paisaje/montaña/calle).
- **Estación 3 (Tests + Cobertura):** Suite PHPUnit aislada en `tests/Unit/` (25 tests, 120 assertions) con **83.86%** de cobertura real de líneas vía Xdebug (umbral 75%).
- **Estación 5 (Playwright E2E):** `playwright.config.js` con `webServer` PHP (`public/router.php`) y 6 escenarios E2E en `tests/e2e/nikoncoach.spec.js` (flujos reales + 404 JSON y validación negativa de API).
- **Estación 7 (Deuda + Observabilidad):** Modularizado `public/js/app.js` (935 líneas -> entrypoint de 30 líneas + 8 módulos ES en `public/js/modules/`), refactorizado `templates/home.php` a wrapper DRY (0 duplicados), y sumado `ErrorLogger` fail-safe con `set_exception_handler`, logs JSON y soporte `SENTRY_DSN`.
- **Veredicto ITV oficial:** `APTO` — 7 aptas · 0 observaciones · 0 desfavorables · 0 omitidas.
- **Despliegue y checkpoint:** Subido a Hostinger (`https://contenido.creawebes.com/NikonCoach/`, HTTP 200 verificado) y etiquetado como `v-estable-2026-11-23`.

### 2026-11-08 (Sesión 5 — Soporte WebAPK Android Calibrado con Vuelos Martín, Chat de Escáner y Simulador Refinado)
- **Motivo:** Android Chrome arrojaba "no se ha podido instalar / abrir la aplicación" tras pulsar "Instalar App".
- **Análisis Forense:**
  1. Comparación 1:1 con el repositorio exitoso `Vuelos Martin`.
  2. Detección de query string `?v=...` en `<link rel="manifest">` que confundía el servidor de WebAPK de Google.
  3. Detección de cache persistente de 7 días (`max-age=604800`) en el CDN de Hostinger (hcdn) que servía íconos rotos de 2 KB y el Service Worker obsoleto `v4`.
- **Implementación y Solución:**
  1. Manifest limpio con `"purpose": "any maskable"` sin query strings en `<link rel="manifest">`.
  2. Generación y despliegue de íconos limpios `app-icon-192.png` y `app-icon-512.png`.
  3. Bumping a Service Worker `v11` con scope explícito para romper el caché previo.
  4. Configuración estricta de cabeceras en `.htaccess` (raíz y public): `Cache-Control: max-age=0, no-cache`, `Access-Control-Allow-Origin: *`.
  5. Verificación en el móvil real de Martín: PWA WebAPK instalada y abierta exitosamente.

### 2026-11-08 (Sesión 4 — Rediseño Multi-Página, Mobile Bottom Bar & PWA Completa)
- Desacople de la SPA vertical larga en páginas separadas (`templates/pages/`).
- Mobile Bottom Tab Bar fijada con safe-area y pills desktop.
- Despliegue y verificación en Hostinger.

### 2026-11-08 / 2026-11-07 (Sesión 3 — Misiones, Simulador DX, Fix IA Gemini 3.8 Flash y 100% Responsive Móvil)
- Migración a `gemini-3.8-flash` sin thinking delay.
- Simulador visual de focales y misiones interactivas con `localStorage`.

### 2026-11-07 (Sesión 2 — Construcción del Core y MVP Completo)
- Modelado del dominio fotográfico en PHP 8.4. Lógica de hardware real.

### 2026-11-06 / 2026-11-07 (Sesión 1 — Bootstrap y Concepción)
- Creación de estructura inicial, AGENTS.md y reglas de proyecto.
