<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>Allin Ruway</title>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
</head>

<body>

    <?php echo $__env->make('components.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php echo $__env->make('components.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

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

</html><?php /**PATH C:\xampp\htdocs\NewAllin\allin-ruway\resources\views/layouts/public.blade.php ENDPATH**/ ?>