<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{--<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">--}}

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    @if (!env('VITE_DISABLED'))
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @endif
</head>
<body>
<div id="app" class="d-flex flex-column vh-100">
    @include('layouts.partials.header')

    <main class="flex-grow-1 d-flex flex-column">
        <div class="container flex-grow-1">
            @include('layouts.partials.error-toast')
            @include('layouts.partials.success-toast')

            <div class="d-flex align-items-center py-4">
                <div class="w-50 m-auto">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>

    @include('layouts.partials.footer')
</div>
</body>
</html>
