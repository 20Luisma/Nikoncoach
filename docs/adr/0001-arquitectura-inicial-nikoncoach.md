# ADR 0001: Arquitectura Inicial — NikonCoach

## Estado
Aceptado

## Contexto
Martín necesita una aplicación web rápida, interactiva y desacoplada que actúe como su mentor y asesor fotográfico personal para su cámara Nikon D5500 y sus dos objetivos reales (AF-S DX 18-55mm VR II y AF-S DX 18-200mm VR I).

## Decisión
1. **Sin Frameworks:** Usar PHP 8.4 estricto bajo Clean Architecture (Domain, Application, Infrastructure, Presentation) y Vanilla JS. Misma base probada y robusta de GastosMartin y LuminaAdvisor.
2. **Cálculo Fotométrico Determinista:** Lógica física estricta para la regla de la inversa de la focal en sensor DX (1.5x), aperturas variables según zoom, y pesos de transporte.
3. **Mentoría con IA (Gemini 3.8 Flash):** Para la explicación en lenguaje terrenal, los retos y la traducción a los botones táctiles y físicos de la Nikon D5500.
4. **Despliegue:** La Santísima Trinidad (Local Mac ➔ GitHub ➔ Hostinger VPS).

## Consecuencias
- Cero dependencias volátiles de terceros.
- Tiempos de respuesta inferiores a 200ms.
- Reproducibilidad 1:1 en local y producción.

