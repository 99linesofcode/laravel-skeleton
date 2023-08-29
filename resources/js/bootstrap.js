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

import { current } from 'libs/current';
window.current = current;

import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: current.pusher.key,
    cluster: current.pusher.cluster,
    wsHost: current.pusher.wsHost,
    wsPort: current.pusher.wsPort ?? 80,
    wssPort: current.pusher.wssPort ?? 443,
    forceTLS: (current.pusher.forceTLS ?? 'false') == true,
    enabledTransports: ['ws', 'wss'],
});
