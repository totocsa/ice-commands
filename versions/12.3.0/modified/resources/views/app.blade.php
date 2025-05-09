<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead

    <!-- Basic icons -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('icons/Ice-16x16.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('icons/Ice-32x32.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('icons/Ice-48x48.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('icons/Ice-64x64.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('icons/Ice-128x128.png') }}">

    <!-- Apple icon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('icons/Ice-180x180.png') }}">

    <!-- Android and PWA icons -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('icons/Ice-192x192.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('icons/Ice-512x512.png') }}">
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>
