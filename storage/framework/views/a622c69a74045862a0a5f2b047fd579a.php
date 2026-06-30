<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <?php echo $__env->make('layouts.dashboard-navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div class="dashboard-layout">
            <button id="toggleSidebar" class="sidebar-toggle">➔</button>
            <aside id="sidebar" class="dashboard-sidebar">

                <div class="sidebar-logo">
                    <h2>MENÚ</h2>
                </div>
                <nav>
                    <a href="<?php echo e(route('dashboard')); ?>"
                        class="<?php echo e(request()->routeIs('dashboard') ? 'active-menu' : ''); ?>">
                        Inicio
                    </a>
                    <a href="<?php echo e(route('profile.edit')); ?>"
                        class="<?php echo e(request()->routeIs('profile.edit') ? 'active-menu' : ''); ?>">
                        Mi Perfil
                    </a>

                    <?php if(auth()->user()->rol == 'trabajador'): ?>
                        <a href="<?php echo e(route('contrataciones.index')); ?>"
                            class="<?php echo e(request()->routeIs('contrataciones.index') ? 'active-menu' : ''); ?>">
                            Solicitudes
                        </a>
                        <a href="<?php echo e(route('contrataciones.misTrabajos')); ?>"
                            class="<?php echo e(request()->routeIs('contrataciones.misTrabajos') ? 'active-menu' : ''); ?>">
                            Mis Trabajos
                        </a>
                        <a href="<?php echo e(route('contrataciones.historial')); ?>"
                            class="<?php echo e(request()->routeIs('contrataciones.historial') ? 'active-menu' : ''); ?>">
                            Historial
                        </a>
                    <?php endif; ?>

                    <?php if(auth()->user()->rol == 'cliente'): ?>
                        <a href="<?php echo e(route('contrataciones.misContrataciones')); ?>"
                            class="<?php echo e(request()->routeIs('contrataciones.misContrataciones') ? 'active-menu' : ''); ?>">
                            Mis Contrataciones
                        </a>
                    <?php endif; ?>
                </nav>

            </aside>

            <main class="dashboard-content">
                <?php if(isset($header)): ?>
                    <header class="dashboard-header"><?php echo e($header); ?></header>
                <?php endif; ?>
                <?php echo e($slot); ?>

            </main>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const boton = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            boton.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
            });
        });
    </script>
</body>


</html><?php /**PATH C:\xampp\htdocs\NewAllin\allin-ruway\resources\views/layouts/app.blade.php ENDPATH**/ ?>