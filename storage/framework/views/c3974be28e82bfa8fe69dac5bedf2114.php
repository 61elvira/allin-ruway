<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body class="login-page">

    <a href="/" class="back-home">
        Volver al inicio
    </a>

    <div class="login-overlay"></div>

    <div class="login-wrapper">

        <div class="login-image">
            <img src="<?php echo e(asset('imagenes/imgLogin4.webp')); ?>" alt="Allin Ruway">
        </div>

        <div class="login-card">

            <h1 class="login-title">
                ALLIN RUWAY
            </h1>

            <?php echo e($slot); ?>


        </div>

    </div>

</body>

</html><?php /**PATH C:\xampp\htdocs\NewAllin\allin-ruway\resources\views/layouts/guest.blade.php ENDPATH**/ ?>