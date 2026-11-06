# AGENTS.md — Workspace NikonCoach

Este workspace aplica las reglas globales de Antigravity God-Mode más las directrices específicas de NikonCoach:

1. PHP 8.4+ estricto — Clean Architecture sin frameworks pesados.
2. Separación estricta de responsabilidades (HTML en templates, CSS en public/css, JS en public/js, negocio en src/).
3. Lógica física real de fotografía (sensor DX 1.5x, regla de la inversa de la focal, aperturas variables f/3.5-5.6).
4. El mentor habla en español rioplatense (uruguayo/cercano), haciendo referencia a los botones reales de la Nikon D5500.
5. La Santísima Trinidad: Local ➔ GitHub ➔ Hostinger VPS vía `bin/deploy.sh`.
6. Credenciales blindadas en `.env` (ignorado en git con chmod 600 en producción).
