<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    {{-- Glider.js Min Css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/glider-js/1.7.7/glider.min.css"
        integrity="sha512-YM6sLXVMZqkCspZoZeIPGXrhD9wxlxEF7MzniuvegURqrTGV2xTfqq1v9FJnczH+5OGFl5V78RgHZGaK34ylVg=="
        crossorigin="anonymous" />

    @livewireStyles

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    {{-- Glider-js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/glider-js/1.7.7/glider.min.js"
        integrity="sha512-tHimK/KZS+o34ZpPNOvb/bTHZb6ocWFXCtdGqAlWYUcz+BGHbNbHMKvEHUyFxgJhQcEO87yg5YqaJvyQgAEEtA=="
        crossorigin="anonymous"></script>
</head>

<body class="font-sans antialiased">
    <x-jet-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation')


        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts

    <script>
        function dropdown() {
            return {
                open: false,
                show() {
                    if (this.open) {
                        this.open = false;
                        document.getElementsByTagName('html')[0].style.overflow = 'auto'
                    } else {
                        this.open = true;
                        document.getElementsByTagName('html')[0].style.overflow = 'hidden'
                    }
                },
                close() {
                    this.open = false;
                    document.getElementsByTagName('html')[0].style.overflow = 'auto'
                }
            }
        }

    </script>

    @stack('script')
</body>

</html>
