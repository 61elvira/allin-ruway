<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Allin Ruway</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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

            if (menuBtn && navLinks) {
                menuBtn.addEventListener('click', function () {
                    navLinks.classList.toggle('active');
                    menuBtn.innerHTML = navLinks.classList.contains('active') ? '✕' : '☰';
                });
            }

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('section-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.section-hidden').forEach(el => observer.observe(el));
        });

    </script>
</body>

</html>