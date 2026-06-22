<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Allin Ruway</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{asset('css/style.css') }}">
</head>

<body>

    @include('components.navbar')

    <main>
        @yield('content')
    </main>

    @include('components.footer')

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const menuBtn = document.getElementById('menuToggle');

            const navLinks = document.getElementById('navLinks');

            menuBtn.addEventListener('click', function () {

                navLinks.classList.toggle('active');

                if (navLinks.classList.contains('active')) {

                    menuBtn.innerHTML = '✕';

                } else {

                    menuBtn.innerHTML = '☰';

                }

            });

        });

    </script>
</body>

</html>