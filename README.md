# 📷 NikonCoach

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

Clean Architecture estricta en **PHP 8.4+** sin frameworks pesados:
```
NikonCoach/
├── src/
│   ├── Domain/
│   │   ├── Entities/         # CameraProfile, Lens, PhotoScene, ShootingRecommendation
│   │   └── Repositories/     # EquipmentRepositoryInterface
│   ├── Application/
│   │   └── UseCases/         # RecommendLensUseCase, CalculateExposureUseCase, AskMentorUseCase
│   ├── Infrastructure/
│   │   ├── AI/               # GeminiClient (REST API con fallback offline)
│   │   ├── Repositories/     # EquipmentRepository (Hardware real de Martín)
│   │   └── Config.php        # Carga limpia de .env
│   └── Presentation/
│       └── Controllers/      # HomeController, ApiController
├── templates/                # HTML5 semántico (home.php, layout.php)
├── public/
│   ├── css/style.css         # Design Tokens, Dark Mode Nikon (#FFE600), micro-animaciones
│   ├── js/app.js             # Vanilla JS modular desacoplado
│   └── index.php             # Front Controller y Router PSR-4
└── bin/deploy.sh             # Script de despliegue a Hostinger
```

---

## ⚡ Verificación Rápida en Local

```bash
# 1. Lint de sintaxis PHP
find src public templates -name "*.php" -exec php -l {} \;

# 2. Levantar el servidor local
php -S localhost:8088 -t public/
```
Abrir `http://localhost:8088` en el navegador.

---

## 🚀 Despliegue a Producción

```bash
# Despliegue automatizado hacia Hostinger
bash bin/deploy.sh
```

---

## ⚖️ Licencia y Créditos
Diseñado con rigor técnico para **Martín** © 2026.
