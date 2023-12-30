const staticCacheName = location.protocol + "//" + location.host;
const PREFIX = "V1"
const filesToCache = [
    '/offline',
    '/css/style.bundle.css',
    '/storage/icons/icon-72x72.png',
    '/storage/icons/icon-96x96.png',
    '/storage/icons/icon-128x128.png',
    '/storage/icons/icon-152x152.png',
    '/storage/icons/icon-144x144.png',
    '/storage/icons/icon-192x192.png',
    '/storage/icons/icon-384x384.png',
    '/storage/icons/icon-512x512.png',
];

// Cache on install
self.addEventListener('install', (event) => {
    this.skipWaiting();
    event.waitUntil(
        (async () => {
            const cache = await caches.open(PREFIX);
        })()
    );
    console.log(`${PREFIX} Install`);
})

self.addEventListener("activate", (event) => {
    clients.claim();
    event.waitUntil(
        (async () => {
            const keys = await caches.keys();
            await Promise.all(
                keys.map((key) => {
                    if (!key.includes(PREFIX)) {
                        return caches.delete(key);
                    }
                })
            );
        })()
    );
    console.log(`${PREFIX} Active`);
});

self.addEventListener("fetch", (event) => {
    console.log(
        `${PREFIX} Fetching : ${event.request.url}, Mode : ${event.request.mode}`
    );
    if (event.request.mode === "navigate") {
        event.respondWith(
            (async () => {
                try {
                    const preloadResponse = await event.preloadResponse;
                    if (preloadResponse) {
                        return preloadResponse;
                    }

                    return await fetch(event.request);
                } catch (e) {
                    const cache = await caches.open(PREFIX);
                    return await cache.match("/offline");
                }
            })()
        );
    } else if (filesToCache.includes(event.request.url)) {
        event.respondWith(caches.match(event.request));
    }
});

self.addEventListener('push', function (e) {
    if (!(self.Notification && self.Notification.permission === 'granted')) {
        //notifications aren't supported or permission not granted!
        return;
    }

    if (e.data) {
        let msg = e.data.json();
        console.log(msg)
        e.waitUntil(self.registration.showNotification(msg.title, {
            body: msg.body,
            icon: msg.icon,
            actions: msg.actions
        }));
    }
});
