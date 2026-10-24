<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff">
    <title>{{ isset($title) && $title !== '' ? $title.' | ' : '' }}{{ config('app.name') }}</title>
    @isset($description)
        <meta name="description" content="{{ $description }}">
    @endisset

    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/site.webmanifest') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Noto+Sans:wght@300;400;500&family=Red+Hat+Display:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body @class(['home' => request()->routeIs('home'), $bodyClass ?? ''])>
    <x-site.spinner />

    <div class="page block w-full overflow-hidden transition-all duration-1000 ease-in-out" style="opacity: 0">
        <x-site.header />

        <main>
            {{ $slot }}
        </main>

        <x-site.footer />
        <x-site.mobile-nav />
    </div>

    <script src="{{ asset('js/legacy/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/legacy/slick.min.js') }}"></script>
    <script src="{{ asset('js/legacy/aos.js') }}"></script>
    <script src="{{ asset('js/legacy/jquery.mmenu.all.min.js') }}"></script>
    <script src="{{ asset('js/legacy/custom.js') }}"></script>
    <script>
        function cambiarUrl(url) {
            window.location.href = url;
        }

        document.addEventListener('livewire:init', () => {
            Livewire.on('scrollTop', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
            Livewire.on('spinner', ([on]) => {
                document.querySelector('.spinner').style.display = on ? 'block' : 'none';
                document.querySelector('main').style.opacity = on ? '0.5' : '1';
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
