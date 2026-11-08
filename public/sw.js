const CACHE_NAME = 'nikoncoach-v3';
const STATIC_ASSETS = [
  './',
  'mochila',
  'receta',
  'simulador',
  'misiones',
  'mentor',
  'equipo',
  'css/style.css',
  'js/app.js',
  'manifest.json',
  'assets/icon-192.png',
  'assets/icon-512.png',
  'assets/icon.svg',
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => cache.addAll(STATIC_ASSETS))
  );
  self.skipWaiting();
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((keys) =>
      Promise.all(
        keys.map((key) => {
          if (key !== CACHE_NAME) return caches.delete(key);
        })
      )
    )
  );
  self.clients.claim();
});

// Network-first con fallback a caché para garantizar recetas offline en el campo
self.addEventListener('fetch', (event) => {
  const url = new URL(event.request.url);

  // Las llamadas a la API de IA o cálculo dinámico van directo a la red
  if (url.pathname.includes('/api/')) {
    event.respondWith(
      fetch(event.request).catch(() => {
        return new Response(
          JSON.stringify({
            success: false,
            reply: 'Sin conexión a internet. Conectate a una red o usá el conocimiento offline de tu lente.'
          }),
          { headers: { 'Content-Type': 'application/json' } }
        );
      })
    );
    return;
  }

  // App shell y estáticos
  event.respondWith(
    fetch(event.request)
      .then((res) => {
        const copy = res.clone();
        caches.open(CACHE_NAME).then((cache) => cache.put(event.request, copy));
        return res;
      })
      .catch(() => caches.match(event.request))
  );
});

