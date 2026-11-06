# AGENTS.md — NikonCoach

## Identidad del Proyecto
**NikonCoach** — Mentor y Asesor Fotográfico Personal de Martín.  
Convierte a Martín en un experto de la fotografía con su cámara real (**Nikon D5500**) y sus dos lentes específicos (**18-55mm VR II** y **18-200mm VR I**), enseñándole técnica, composición y ajustes botón a botón sin jerga inútil.

---

## Hardware Profile de Martín (Cámara y Lentes Reales)

### 1. Cámara: Nikon D5500
- **Sensor:** Formato DX (APS-C) de 24.2 Megapíxeles, sin filtro de paso bajo (máxima nitidez).
- **Factor de recorte:** 1.5x (18mm = 27mm equivalente / 200mm = 300mm equivalente).
- **ISO nativo:** 100 a 25.600 (ideal mantener < 1600 para ruido bajo, máx 3200 si es necesario).
- **Controles físicos clave:**
  - Rueda de modos: **A** (Prioridad apertura), **S** (Prioridad velocidad), **M** (Manual).
  - Pantalla táctil abatible con botón **[i]** para cambiar ajustes rápidos.
  - Botón de compensación de exposición **[+/-]** junto al disparador.

### 2. Lente 1: AF-S DX NIKKOR 18-55mm f/3.5-5.6G VR II
- **Tipo:** Zoom estándar ultra-compacto retráctil (con botón de bloqueo en el anillo).
- **Peso:** Solo **195 gramos** (ideal para ir ligero, fotos de calle, viajes donde se camina mucho).
- **Distancia mínima de enfoque:** **25 cm** (¡ideal para fotos de platos de comida, flores o detalles de cerca!).
- **Filtro:** 52 mm.

### 3. Lente 2: AF-S DX VR Zoom-Nikkor 18-200mm f/3.5-5.6G IF-ED (VR I)
- **Tipo:** Superzoom todoterreno de 11 aumentos con ventanita de escala de distancias (letras VR rojas).
- **Peso:** **560 gramos** (pesa el triple, pero cubre todo).
- **Alcance:** De 18mm a 200mm (equivalente a 300mm en paso universal).
- **Controles laterales:** Selector `M/A - M` y `VR Normal / Active`.
- **Distancia mínima de enfoque:** **50 cm** (no enfoca tan cerca como el 18-55).
- **Filtro:** 72 mm.

---

## Stack Tecnológico
- **Backend:** PHP 8.4+ estricto — Clean Architecture (Domain / Application / Infrastructure / Presentation) sin frameworks
- **Frontend:** HTML5 semántico + CSS3 (Design Tokens, Dark Mode, Acento Amarillo/Dorado Nikon `#FFE600` / `#F59E0B`) + Vanilla JS
- **IA:** Google Gemini 3.8 Flash para el mentor conversacional (`responseMimeType: application/json` y streaming/chat)
- **Despliegue:** Hostinger (`contenido.creawebes.com/NikonCoach/`) vía `bin/deploy.sh` blindado

---

## Reglas de Negocio Fotográficas

1. **Recomendación de Mochila Honesta:**
   - Si la escena no requiere más de 55mm (callejear, monumentos amplios, comida, fotos familiares cotidianas), recomendar el **18-55mm** para evitar cargar medio kilo innecesario.
   - Si requiere alcance (deportes, animales, robados lejanos, compresión de fondos en montaña), recomendar el **18-200mm**.
   - Si requiere fotos de cerca (platos de comida, flores, detalles), alertar que el 18-55mm enfoca a 25 cm mientras que el 18-200mm necesita medio metro mínimo.

2. **Cálculo Físico de Disparo (Cero Fotos Borrosas):**
   - **Regla de la focal inversa:** La velocidad mínima segura a pulso debe ser:
     $$\text{Velocidad mínima} = \frac{1}{\text{Focal} \times 1.5}$$
     (ej: a 200mm en sensor DX, mínimo 1/300s, o 1/80s con VR activado).
   - **Punto dulce (Sweet Spot):** Para paisajes con ambos lentes, recomendar $f/8$ (máxima nitidez de borde a borde).
   - **Compresión de planos:** Enseñar el truco de alejarse y usar 100-135mm en el 18-200mm para fondos borrosos sin necesidad de comprar otro lente.

3. **Tono del Mentor:**
   - Hablar en español rioplatense (uruguayo/cercano).
   - Indicar qué botones físicos tocar en la Nikon D5500.
   - Prohibido la jerga innecesaria sin explicar su sentido práctico.

---

## Comandos de Verificación
```bash
# Lint PHP
find src public templates -name "*.php" -exec php -l {} \;

# Verificar HTTP post-deploy
curl -s -o /dev/null -w "%{http_code}" https://contenido.creawebes.com/NikonCoach/
```

