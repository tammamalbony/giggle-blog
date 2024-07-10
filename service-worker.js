const CACHE_NAME = 'blog-cache-v1';
const urlsToCache = [
  '/',
  '/index.php',

	'/custom/vendor/bootstrap/css/bootstrap.min.css',
	'/custom/vendor/bootstrap-icons/bootstrap-icons.css',
	'/custom/vendor/aos/aos.css',
	'/custom/vendor/glightbox/css/glightbox.min.css',
	'/custom/vendor/swiper/swiper-bundle.min.css',

	'/custom/css/main.css',
	'/custom/css/custom.css',



	'/custom/css/custom.css',
	'/custom/css/custom.css',


  '/custom/vendor/bootstrap/js/bootstrap.bundle.min.js',
	'/custom/vendor/aos/aos.js',
	'/custom/vendor/glightbox/js/glightbox.min.js',
	'/custom/vendor/purecounter/purecounter_vanilla.js',
	'/custom/vendor/swiper/swiper-bundle.min.js',
	'/custom/vendor/php-email-form/validate.js',
	'/custom/js/main.js',


  '/custom/img/pwa/icon-48x48.png',
  '/custom/img/pwa/icon-72x72.png',
  '/custom/img/pwa/icon-96x96.png',
  '/custom/img/pwa/icon-144x144.png',
  '/custom/img/pwa/icon-192x192.png',
  '/custom/img/pwa/icon-256x256.png',
  '/custom/img/pwa/icon-384x384.png',
  '/custom/img/pwa/icon-512x512.png',
]
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        return cache.addAll(urlsToCache);
      })
  );
});

self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request)
      .then(response => {
        if (response) {
          return response;
        }
        return fetch(event.request);
      })
  );
});
