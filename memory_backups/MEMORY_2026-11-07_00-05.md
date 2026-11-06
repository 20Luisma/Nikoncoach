# 🧠 MEMORY.md — NikonCoach

## 🌍 Contexto General del Proyecto

**NikonCoach** es el mentor y asesor fotográfico personal de Martín para su cámara **Nikon D5500** y sus dos lentes:
- **AF-S DX NIKKOR 18-55mm f/3.5-5.6G VR II** (Retráctil, 195g)
- **AF-S DX VR Zoom-Nikkor 18-200mm f/3.5-5.6G IF-ED** (Superzoom VR I rojo, 560g)

**Misión:** Convertir a Martín en un fotógrafo experto con su propio equipo a través de la práctica real, resolviendo dudas de campo ("¿cuál lente llevo?", "¿cómo configuro para esta foto?") y dándole misiones y feedback constructivo en lenguaje claro.

**Propietario:** Martín (Esparreguera, Barcelona)  
**Hostinger:** `contenido.creawebes.com/NikonCoach/`  
**GitHub:** A crear en `20Luisma/NikonCoach`

---

## 🏗️ Arquitectura Técnica

- **Backend:** PHP 8.4+ estricto — Clean Architecture (Domain / Application / Infrastructure / Presentation)
- **Frontend:** HTML5 semántico + CSS3 (Design Tokens, Dark Mode Nikon con acento amarillo/dorado) + Vanilla JS modular
- **IA:** Google Gemini 3.8 Flash (Asesor y Mentor fotográfico interactivo con memoria de equipo)
- **Servidor:** Hostinger VPS vía `bin/deploy.sh`
- **Sin frameworks PHP ni JS** (misma filosofía probada de LuminaAdvisor y GastosMartin)

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
| **Filtro** | - | 52 mm | 72 mm |
| **Estabilizador** | - | VR II (~4 pasos) | VR I (~3 pasos, modo Active) |

---

## 📌 Estado Actual del Proyecto

- [x] Bootstrap completo del proyecto (estructura, AGENTS.md, MEMORY.md, .gitignore)
- [ ] Definir entidades de dominio: `CameraProfile.php`, `Lens.php`, `PhotoScene.php`
- [ ] Implementar caso de uso: `RecommendLensUseCase.php` (lógica de peso vs focal vs distancia de enfoque)
- [ ] Implementar caso de uso: `CalculateExposureUseCase.php` (receta de parámetros A/S/M, diafragma, velocidad e ISO)
- [ ] Integrar mentor IA con Gemini 3.8 Flash: consejos de campo, misiones y botón a botón de la D5500
- [ ] Diseñar UI Dark Mode Nikon con selector de lentes y simulador de parámetros
- [ ] Crear repositorio GitHub y primer commit
- [ ] Deploy a Hostinger (`contenido.creawebes.com/NikonCoach/`)

---

## 🚀 Próximos Pasos Prioritarios

1. Crear entidades de dominio (`Lens.php`, `CameraProfile.php`, `ShootingRecommendation.php`)
2. Implementar los dos casos de uso core (Recomendación de lente + Cálculo de exposición)
3. Diseñar UI con tarjetas visuales de los lentes de Martín
4. Integrar el chat del Mentor IA con Gemini 3.8 Flash
5. Subir a GitHub y desplegar a Hostinger

---

## 🕰️ Historial de Sesiones

### 2026-11-06 / 2026-11-07 (Sesión 1 — Bootstrap y Concepción)
- Concepción del proyecto: Mentor y Asesor Fotográfico Personal para Martín.
- Análisis visual de las fotos reales del equipo: Nikon D5500 + 18-55mm VR II retráctil (195g) + 18-200mm VR I rojo (560g).
- Casos de uso definidos:
  1. Asesor de mochila ("¿cuál llevo hoy?").
  2. Receta de disparo exacta para la D5500 (rueda de modo, diafragma, velocidad, ISO).
  3. Desafíos e ideas para salir a fotografiar ("aprender haciendo").
  4. Mentor interactivo con Gemini en criollo.
- Bootstrap ejecutado (Regla 22 God-Mode).
