{{-- Pusher Client-Side Config --}}
<meta
    name="current-pusher-key"
    content="{{ config('broadcasting.connections.pusher.key') }}"
/>
<meta
    name="current-pusher-cluster"
    content="{{ config('broadcasting.connections.pusher.frontend_options.cluster') }}"
/>
<meta
    name="current-pusher-wsHost"
    content="{{ config('broadcasting.connections.pusher.frontend_options.host') }}"
/>
<meta
    name="current-pusher-wsPort"
    content="{{ config('broadcasting.connections.pusher.frontend_options.port') }}"
/>
<meta
    name="current-pusher-forceTLS"
    content="{{ json_encode(boolval(config('broadcasting.connections.pusher.frontend_options.forceTLS'))) }}"
/>

@auth
    <meta
        name="current-identity-id"
        content="{{ Auth::user()->id }}"
    />
    <meta
        name="current-identity-name"
        content="{{ Auth::user()->name }}"
    />
@endauth
