<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Titre de la page' }}</title>
    <link rel="stylesheet" href="@vite(['resources/css/app.css'])">
    @livewireStyles
</head>
<body>
    {{ $slot }}
    @vite(['resources/js/app.js'])
    <script src="https://www.google.com/recaptcha/api.js"></script>
    @livewireScripts
</body>
</html>
