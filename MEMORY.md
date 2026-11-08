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
- [x] Soporte PWA completo (`manifest.json`, `sw.js`, `assets/icon-192.png`, `assets/icon-512.png`, `assets/icon.svg` y botón "📲 Instalar App") para instalar en Chrome/Android/iOS como app nativa
- [x] Subida a GitHub (`https://github.com/20Luisma/Nikoncoach`)
- [x] Despliegue a Hostinger (`https://contenido.creawebes.com/NikonCoach/`) con verificación HTTP 200 y endpoints probados en vivo
- [x] Tag Git creado y sincronizado (`v-estable-2026-11-07`)

---

## 🚀 Próximos Pasos Prioritarios

1. Soporte Offline PWA (Service Worker) para consultar recetas y asesor de mochila en el campo sin cobertura móvil.
2. Diagrama interactivo SVG de los botones físicos de la Nikon D5500.
3. Guardar favoritos de recetas de disparo frecuentes.

---

## 🕰️ Historial de Sesiones

### 2026-11-08 / 2026-11-07 (Sesión 3 — Misiones, Simulador DX, Fix IA Gemini 3.8 Flash y 100% Responsive Móvil)
- Corrección de la API de IA: migración a `gemini-3.8-flash` con `thinkingBudget: 0`, restableciendo respuestas live instantáneas en producción.
- Incorporación del Simulador Visual de Focal DX: muestra el encuadre óptico y desenfoque del fondo de 18mm a 200mm.
- Implementación de 5 Misiones de Campo con checklist y guardado de progreso en `localStorage`.
- Blindaje responsive para teléfonos: cero auto-zoom en iOS Safari, botones de 48px y navegación fluida.
- Despliegue a Hostinger validado con HTTP 200 y sincronizado en GitHub.

### 2026-11-07 (Sesión 2 — Construcción del Core y MVP Completo)
- Modelado del dominio fotográfico estricto en PHP 8.4: cámara Nikon D5500, lentes 18-55mm y 18-200mm.
- Implementación de la física fotográfica real: factor DX 1.5x, regla inversa focal, limitación física de 50cm de enfoque en el 18-200mm y sweet spot óptico $f/8$.
- Despliegue inicial a Hostinger.

### 2026-11-06 / 2026-11-07 (Sesión 1 — Bootstrap y Concepción)
- Concepción del proyecto y bootstrap con AGENTS.md.
