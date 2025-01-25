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
            @auth
                @include('layouts.partials.error-toast')
                @include('layouts.partials.success-toast')

                <div class="row h-100">
                    <aside class="col-md-3">
                        <div class="p-3 border rounded-3">
                            @include('layouts.partials.sidebars.app-sidebar')
                        </div>
                    </aside>
                    <div class="col-md-9 content ">
                        @yield('content')
                    </div>
                </div>
            @else
                <div class="px-4 py-5 my-5 text-center">
                    <h1 class="display-5 fw-bold text-body-emphasis">
                        Authorization
                    </h1>
                    <div class="col-lg-6 mx-auto">
                        <p class="lead mb-4">
                            You need to
                            <a href="{{ route('register') }}">register an account</a>
                            or if you already have one try to
                            <a href="{{ route('login') }}">login</a>
                        </p>
                    </div>
                </div>
            @endauth
        </div>
    </main>

    @include('layouts.partials.footer')
</div>
</body>
</html>
