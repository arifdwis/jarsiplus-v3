var staticCacheName = "sikerja-v" + new Date().getTime();
var filesToCache = [
    'https://cdnjs.cloudflare.com/ajax/libs/mobile-detect/1.4.4/mobile-detect.min.js',
    'https://fonts.googleapis.com/css?family=Inter:400,500,700&display=swap',
    'https://unpkg.com/ionicons@5.0.0/dist/ionicons.js',
    'https://samarindakota.go.id/template/mobilekit/js/lib/jquery-3.4.1.min.js',
    'https://samarindakota.go.id/template/mobilekit/js/lib/popper.min.js',
    'https://samarindakota.go.id/template/mobilekit/js/lib/bootstrap.min.js',
    'https://samarindakota.go.id/template/mobilekit/js/plugins/owl-carousel/owl.carousel.min.js',
    'https://samarindakota.go.id/template/mobilekit/js/base.js',
    'https://samarindakota.go.id/template/mobilekit/css/inc/owl-carousel/owl.carousel.min.css',
    'https://samarindakota.go.id/template/mobilekit/css/inc/owl-carousel/owl.theme.default.css',
    'https://samarindakota.go.id/template/mobilekit/css/inc/bootstrap/bootstrap.min.css',
    'https://samarindakota.go.id/template/mobilekit/css/style.css', 
    'https://sikerja.samarindakota.go.id/css/custom.css',  
    'https://sikerja.samarindakota.go.id/js/custom.js',
  ];


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
                    .filter(cacheName => (cacheName.startsWith("sikerja-")))
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