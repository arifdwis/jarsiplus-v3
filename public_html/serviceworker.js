var staticCacheName = "jarsiplus-v" + new Date().getTime();
var filesToCache = [
    'https://cdnjs.cloudflare.com/ajax/libs/mobile-detect/1.4.4/mobile-detect.min.js',
    'https://fonts.googleapis.com/css?family=Inter:400,500,700&display=swap',
    'https://unpkg.com/ionicons@5.0.0/dist/ionicons.js',
    'https://jarsiplus.samarindakota.go.id/css/custom.css',  
    'https://jarsiplus.samarindakota.go.id/js/custom.js',
  ];



if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/serviceworker.js', { scope: '/' })
    .then(function(registration) {
      console.log('Service Worker registered with scope:', registration.scope);
    })
    .catch(function(error) {
      console.error('Service Worker registration failed:', error);
    });
}

// Cache on install
self.addEventListener("install", event => {
    this.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName)
            .then(cache => {
                return cache.addAll(filesToCache);
            })
    )
});

// Clear cache on activate
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    .filter(cacheName => (cacheName.startsWith("jarsiplus-")))
                    .filter(cacheName => (cacheName !== staticCacheName))
                    .map(cacheName => caches.delete(cacheName))
            );
        })
    )
});

// Serve from Cache
self.addEventListener("fetch", event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                return response || fetch(event.request);
            })
            .catch(() => {
                return caches.match('offline');
            })
    )
});