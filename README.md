# 📷 NikonCoach

[![CI — NikonCoach (ITV 7/7)](https://github.com/20Luisma/Nikoncoach/actions/workflows/ci.yml/badge.svg)](https://github.com/20Luisma/Nikoncoach/actions/workflows/ci.yml)

> **Mentor y Asesor Fotográfico Personal** para **Nikon D5500** + **18-55mm VR II** & **18-200mm VR I**.

🌐 **En producción:** [https://contenido.creawebes.com/NikonCoach/](https://contenido.creawebes.com/NikonCoach/)  
📦 **Repositorio:** [https://github.com/20Luisma/Nikoncoach](https://github.com/20Luisma/Nikoncoach)

---

## 🎯 ¿Qué es NikonCoach?

**NikonCoach** es el mentor fotográfico personal de Martín diseñado específicamente a la medida de su cámara y sus ópticas reales:
- **Cámara:** Nikon D5500 (Sensor DX 24.2 MP sin OLPF, 1.5x crop, pantalla abatible táctil con botón `[i]`)
- **Lente 1:** AF-S DX NIKKOR 18-55mm f/3.5-5.6G VR II (Retráctil, 195g, enfoque mínimo de **25 cm**)
- **Lente 2:** AF-S DX VR Zoom-Nikkor 18-200mm f/3.5-5.6G IF-ED (Superzoom 11x VR I rojo, 560g, enfoque mínimo de **50 cm**)

---

## 🚀 Funcionalidades Principales

1. **📸 Escáner de Escena IA (Vision Multimodal):**
   - Sacale una foto con el móvil al lugar o escena antes de disparar con la réflex.
   - La IA analiza la luz y el tipo de sujeto en vivo y te devuelve la receta exacta para tu **Nikon D5500**, qué lente montar y 3 ideas de encuadre creativo.
2. **🧭 Asesor de Mochila Inteligente (*"¿Cuál saco hoy?"*):**
   - Evalúa el plan (paisaje, calle, comida, deportes, retrato).
   - Considera la física del enfoque: alerta visual si el sujeto está a menos de 50 cm (anulación física del 18-200mm).
   - Calcula el ahorro de peso (hasta 365 gramos de diferencia al cuello en caminatas largas).
3. **⚙️ Calculadora de Disparo y Física DX:**
   - Modo de dial recomendado (**A**, **S** o **M**).
   - Punto dulce óptico ($f/8$ para máxima nitidez en paisaje; apertura abierta a 105-135mm para bokeh con compresión tele).
   - Regla de la inversa de la focal DX con amortiguación de pasos por estabilizador VR.
   - **Instrucciones botón a botón** en la D5500: dial trasero, botón táctil `[i]`, switch de VR en lente.
4. **🔭 Simulador Visual de Focal DX:**
   - Vista interactiva de ángulo de visión, compresión de planos y bokeh de 18mm a 200mm (equivalente a 27mm–300mm en FX).
5. **🎯 Misiones de Campo:**
   - Desafíos fotográficos prácticos con checklist y guardado en `localStorage`.
6. **🧠 Mentor IA Interactivo (Gemini 3.8 Flash):**
   - Asistente conversacional con **Google Gemini** en español rioplatense (uruguayo).
   - Acceso rápido a preguntas frecuentes en 1 clic y respuestas botón a botón.
7. **📱 PWA Instalable y Diseño Multi-Página:**
   - Cada herramienta en su propia vista dedicada con barra de pestañas desktop y **Mobile Bottom Tab Bar** estilo app nativa iOS/Android.
   - Soporte PWA instalable en Chrome/Safari y Service Worker v2 offline-ready.

---

## 🏗️ Arquitectura Técnica

Clean Architecture estricta en **PHP 8.4+** sin frameworks pesados (producción corre 100% sin `vendor/` ni `node_modules/`):
```
NikonCoach/
├── src/
│   ├── Domain/
│   │   ├── Entities/         # CameraProfile, Lens, PhotoScene, ShootingRecommendation, Mission
│   │   └── Repositories/     # EquipmentRepositoryInterface, MissionRepositoryInterface
│   ├── Application/
│   │   └── UseCases/         # RecommendLens, CalculateExposure, AskMentor, AnalyzeScenePhoto, GetMissions
│   ├── Infrastructure/
│   │   ├── AI/               # GeminiClient (REST API con fallback determinista)
│   │   ├── Observability/    # ErrorLogger fail-safe (JSON local + SENTRY_DSN opcional)
│   │   ├── Repositories/     # EquipmentRepository, MissionRepository
│   │   └── Config.php        # Carga limpia de .env
│   └── Presentation/
│       └── Controllers/      # HomeController, ApiController
├── templates/
│   ├── layout.php            # Layout base + navegación desktop/móvil
│   ├── home.php              # Wrapper DRY que delega en templates/pages/
│   └── pages/                # Vistas dedicadas (scanner, backpack, recipe, simulator, missions, mentor, gear)
├── public/
│   ├── css/style.css         # Design Tokens, Dark Mode Nikon (#FFE600), micro-animaciones
│   ├── js/app.js             # Entrypoint ES Module (<35 líneas)
│   ├── js/modules/           # 8 módulos ES desacoplados (scanner, backpack, exposure, simulator, missions, mentor, pwa, formatters)
│   ├── index.php             # Front Controller PSR-4 + ErrorLogger
│   └── router.php            # Router local para `php -S` y Playwright
├── tests/
│   ├── Unit/                 # Suite PHPUnit aislada (25 tests, 83.86% cobertura Xdebug)
│   └── e2e/                  # Suite Playwright en Chromium (6 escenarios + 404/API negativa)
├── docs/adr/                 # Decisiones de arquitectura (ADRs)
├── composer.json / package.json  # Herramientas dev (PHPStan, PHPUnit, TypeScript, Playwright)
└── bin/deploy.sh             # Script de despliegue a Hostinger (excluye vendor/, node_modules/ y tests/)
```

---

## ⚡ Requisitos, Instalación y Calidad ITV 7/7 en Local

**Requisitos en Mac/Local:** PHP 8.4+ (con Xdebug para cobertura), Composer 2+ y Node.js 20+.  
> **Nota:** `vendor/` y `node_modules/` son exclusivamente para desarrollo, tipado y testing local; están en `.gitignore` y `bin/deploy.sh` los excluye al subir a Hostinger.

```bash
# 1. Instalar herramientas de desarrollo (PHPStan, PHPUnit, TypeScript, Playwright)
composer install && npm install

# 2. Descargar Chromium para Playwright (solo la primera vez)
npx playwright install chromium

# 3. Análisis estático de tipos (PHPStan nivel 5 + tsc --noEmit)
composer analyse && npm run typecheck

# 4. Tests unitarios PHP con cobertura real (Xdebug >= 75%)
npm test

# 5. Pruebas E2E en navegador real (Playwright + Chromium)
npm run test:e2e

# 6. Levantar el servidor local con router limpio
php -S 127.0.0.1:8088 -t public public/router.php
```
Abrir `http://127.0.0.1:8088` en el navegador.

---

## 🚀 Despliegue a Producción

```bash
# Despliegue automatizado hacia Hostinger
bash bin/deploy.sh
```

---

## ⚖️ Licencia y Créditos
Diseñado con rigor técnico para **Martín** © 2026.
