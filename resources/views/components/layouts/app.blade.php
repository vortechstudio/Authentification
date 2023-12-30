<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @laravelPWA
        <title>{{ $title ?? 'Titre de la page' }}</title>
        <link rel="stylesheet" href="{{ asset('/plugins/global/plugins.bundle.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/style.bundle.css') }}">
        @vite(['resources/css/app.css'])
        @livewireStyles
    </head>
    <body>
        <script>
            let defaultThemeMode = "light";
            let themeMode;
            if (document.documentElement) {
                if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                    themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
                } else {
                    if (localStorage.getItem("data-bs-theme") !== null) {
                        themeMode = localStorage.getItem("data-bs-theme");
                    } else {
                        themeMode = defaultThemeMode;
                    }
                }
                if (themeMode === "system") {
                    themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
                }
                document.documentElement.setAttribute("data-bs-theme", themeMode);
            }
        </script>
        <div class="d-flex flex-column flex-root" id="kt_app_root">
            <livewire:layout.header />
            <x-base.background-animated />
            {{ $slot }}
            <livewire:layout.footer />
        </div>
        <script src="{{ asset('/plugins/global/plugins.bundle.js') }}"></script>
        <script src="{{ asset('/js/scripts.bundle.js') }}"></script>
        @vite(['resources/js/app.js'])
        @livewireScripts
        @auth
            <script src="{{ asset('js/enable-push.js') }}" defer></script>
        @endauth
    </body>
</html>
