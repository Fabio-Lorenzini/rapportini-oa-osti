const CACHE = 'oaosti-app-v6';
const FILES = ['./', './index.html', './manifest.webmanifest', './logo-oa-osti.png', './icon-192.png', './icon-512.png'];

// Installa la nuova versione e attivala subito, senza aspettare la chiusura di tutte le schede.
self.addEventListener('install', event => {
  event.waitUntil(caches.open(CACHE).then(cache => cache.addAll(FILES)).then(() => self.skipWaiting()));
});

// La nuova versione prende il controllo e rimuove le cache delle versioni precedenti.
self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys()
      .then(keys => Promise.all(keys.filter(key => key.startsWith('oaosti-app-') && key !== CACHE).map(key => caches.delete(key))))
      .then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', event => {
  if (event.request.method !== 'GET' || new URL(event.request.url).origin !== self.location.origin) return;

  // Per la pagina principale prova prima la rete: così le pubblicazioni su GitHub Pages
  // vengono viste al successivo avvio; se offline, usa la copia in cache.
  const isPage = event.request.mode === 'navigate' || new URL(event.request.url).pathname.endsWith('/index.html') || new URL(event.request.url).pathname.endsWith('/');
  if (isPage) {
    event.respondWith(fetch(event.request).then(response => {
      if (response && response.ok) caches.open(CACHE).then(cache => cache.put(event.request, response.clone()));
      return response;
    }).catch(() => caches.match(event.request).then(cached => cached || caches.match('./index.html'))));
    return;
  }

  // Per logo, icone e manifest usa la cache per velocità, aggiornandola quando possibile.
  event.respondWith(caches.match(event.request).then(cached => {
    const network = fetch(event.request).then(response => {
      if (response && response.ok) caches.open(CACHE).then(cache => cache.put(event.request, response.clone()));
      return response;
    });
    return cached || network.catch(() => caches.match('./index.html'));
  }));
});
