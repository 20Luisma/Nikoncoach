# 🧠 MEMORY.md — NikonCoach

## 🌍 Contexto General del Proyecto

**NikonCoach** es el mentor y asesor fotográfico personal de Martín para su cámara **Nikon D5500** y sus dos lentes:
- **AF-S DX NIKKOR 18-55mm f/3.5-5.6G VR II** (Retráctil, 195g, enfoque a 25 cm)
- **AF-S DX VR Zoom-Nikkor 18-200mm f/3.5-5.6G IF-ED** (Superzoom VR I rojo, 560g, enfoque mínimo a 50 cm)

**Misión:** Convertir a Martín en un fotógrafo experto con su propio equipo a través de la práctica real, resolviendo dudas de campo ("¿cuál lente llevo?", "¿cómo configuro para esta foto?") y dándole recetas botón a botón en lenguaje rioplatense claro.

**Propietario:** Martín (Esparreguera, Barcelona)  
**Hostinger:** `contenido.creawebes.com/NikonCoach/`  
**GitHub:** `https://github.com/20Luisma/Nikoncoach`

---

## 🏗️ Arquitectura Técnica

- **Backend:** PHP 8.4+ estricto — Clean Architecture (Domain / Application / Infrastructure / Presentation)
- **Frontend:** HTML5 semántico + CSS3 (Design Tokens, Dark Mode Nikon con acento amarillo `#FFE600`) + Vanilla JS modular
- **IA:** Google Gemini 3.8 Flash / 2.5 Flash con fallback de conocimiento determinista
- **Servidor:** Hostinger VPS vía `bin/deploy.sh`
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
- [x] Entidades de dominio modeladas: `CameraProfile.php`, `Lens.php`, `PhotoScene.php`, `ShootingRecommendation.php`
- [x] Repositorio de hardware con especificaciones exactas: `EquipmentRepository.php`
- [x] Caso de uso 1: `RecommendLensUseCase.php` (lógica de peso vs focal vs límite físico de 50cm)
- [x] Caso de uso 2: `CalculateExposureUseCase.php` (receta de parámetros A/S/M, f/8 sweet spot, velocidad segura DX e instrucciones botón a botón en la D5500)
- [x] Integración de mentor IA: `GeminiClient.php` y `AskMentorUseCase.php` con fallback inteligente
- [x] Controladores y Front Controller: `HomeController.php`, `ApiController.php`, `public/index.php`
- [x] UI Dark Mode Nikon: `templates/home.php`, `templates/layout.php`, `public/css/style.css`
- [x] Lógica de interacción desacoplada: `public/js/app.js` (alerta de 50cm en vivo, límites de focal dinámicos, chat)
- [x] Validación y tests del dominio: 8/8 tests aprobados
- [ ] Subida a GitHub (`20Luisma/NikonCoach`)
- [ ] Despliegue a Hostinger (`contenido.creawebes.com/NikonCoach/`)

---

## 🚀 Próximos Pasos Prioritarios

1. Hacer commit atómico del MVP en Git (`feat: core MVP NikonCoach — Clean Architecture, Dominio, Casos de Uso, Mentor IA y UI Dark Mode`).
2. Vincular y sincronizar con el repositorio remoto de GitHub (`origin`).
3. Ejecutar despliegue a Hostinger con `bin/deploy.sh` y validar HTTP 200 en vivo.
4. Generar backup inmutable de memoria en `memory_backups/`.
5. Recomendar tag de versión estable `v-estable-2026-11-07`.

---

## 🕰️ Historial de Sesiones

### 2026-11-07 (Sesión 2 — Construcción del Core y MVP Completo)
- Modelado del dominio fotográfico estricto en PHP 8.4: cámara Nikon D5500, lentes 18-55mm y 18-200mm.
- Implementación de la física fotográfica real: factor DX 1.5x, regla inversa focal, limitación física de 50cm de enfoque en el 18-200mm y sweet spot óptico $f/8$.
- Creación de la UI Dark Mode Nikon con Design Tokens, CSS modular, sliders reactivos y chat con el Mentor IA.
- Verificación de sintaxis estricta y tests de casos de uso (100% aprobados).

### 2026-11-06 / 2026-11-07 (Sesión 1 — Bootstrap y Concepción)
- Concepción del proyecto: Mentor y Asesor Fotográfico Personal para Martín.
- Análisis visual del equipo real: Nikon D5500 + 18-55mm VR II (195g) + 18-200mm VR I (560g).
- Bootstrap inicial ejecutado.
