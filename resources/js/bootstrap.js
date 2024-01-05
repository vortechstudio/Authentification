/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    forceTLS: true,
});

window.Echo.join('social')
    .joining((user) => {
        $.ajax({
            url: "/api/user/status",
            method: 'PUT',
            data: {
                status: 'online',
                user_uuid: user.uuid
            },
            success: data => {
                console.log(data);
            }
        })
    })
    .leaving((user) => {
        $.ajax({
            url: "/api/user/status",
            method: 'PUT',
            data: {
                status: 'offline',
                user_uuid: user.uuid
            },
            success: data => {
                console.log(data);
            }
        })
    }).listen('UserChangeStatus', (e) => {
    console.log(e);
});
