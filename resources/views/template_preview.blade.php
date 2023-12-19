<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('/plugins/global/plugins.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/style.bundle.css') }}">
    @vite(['resources/css/app.css'])
</head>
<body>
    @yield("content")
<script src="{{ asset('/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('/js/scripts.bundle.js') }}"></script>
@vite(['resources/js/app.js'])
</body>
</html>
