# 📷 NikonCoach

> **Mentor y Asesor Fotográfico Personal** para **Nikon D5500** + **18-55mm VR II** & **18-200mm VR I**.

🌐 **En producción:** [https://contenido.creawebes.com/NikonCoach/](https://contenido.creawebes.com/NikonCoach/) *(En despliegue)*  
📦 **Repositorio:** `20Luisma/NikonCoach`

---

## 🎯 ¿Qué es NikonCoach?

**NikonCoach** es el mentor fotográfico personal de Martín diseñado específicamente a la medida de su cámara y sus ópticas reales:
- **Cámara:** Nikon D5500 (Sensor DX 24.2 MP, 1.5x)
- **Lente 1:** AF-S DX NIKKOR 18-55mm f/3.5-5.6G VR II (Retráctil, 195g)
- **Lente 2:** AF-S DX VR Zoom-Nikkor 18-200mm f/3.5-5.6G IF-ED (Superzoom VR I, 560g)

En lugar de cursos teóricos genéricos, la app le enseña técnica fotográfica directamente sobre los botones y diales de su cámara:
1. **Asesor de Mochila (*"¿Cuál saco hoy?"*):** Evalúa el plan (paisaje, calle, comida, deportes, retrato) y recomienda qué lente montar para no cargar peso innecesario o quedarse corto de alcance.
2. **Receta de Disparo Exacta:** Indica qué modo de rueda usar (A, S, M), diafragma, velocidad e ISO para garantizar fotos nítidas sin trepidación.
3. **Misiones Prácticas de Campo:** Retos guiados para dominar el fondo desenfocado (bokeh), congelar movimiento, paisajes ultra nítidos y fotos con poca luz.
4. **Mentor IA Interactivo:** Asistente conversacional con **Google Gemini 3.8 Flash** que responde dudas en criollo sin tecnicismos innecesarios.

---

## 🛠️ Stack Tecnológico

- **Backend:** PHP 8.4+ estricto — Clean Architecture (sin frameworks)
- **Frontend:** HTML5 semántico + CSS3 (Design Tokens, Dark Mode Nikon con acento dorado) + Vanilla JS
- **Inteligencia Artificial:** Google Gemini 3.8 Flash (`responseMimeType: application/json`, `thinkingBudget: 0`)
- **Despliegue:** Hostinger VPS vía `bin/deploy.sh` blindado

---

## 🚀 Cómo Arrancar en Local

```bash
# 1. Clonar el repositorio
git clone https://github.com/20Luisma/NikonCoach.git
cd NikonCoach

# 2. Configurar entorno
cp .env.example .env

# 3. Levantar servidor local PHP
php -S localhost:8088 -t public/
```
Abrir `http://localhost:8088` en el navegador.

---

## ⚖️ Licencia y Créditos
Desarrollado con rigor técnico por **Martín** © 2026.
