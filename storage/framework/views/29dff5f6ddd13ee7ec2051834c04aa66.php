<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <header class="dashboard-header">
        <div class="logo">
            <h1>ALLIN RUWAY</h1>
        </div>

        <div class="profile-menu">
            <a href="<?php echo e(route('profile.edit')); ?>">
                Mi Perfil
            </a>
        </div>
    </header>
    <section class="dashboard-hero">

        <div class="hero-content">

            <h1>ALLIN RUWAY</h1>

            <p>
                Encuentra trabajadores confiables para cualquier proyecto.
            </p>

            <form class="hero-search">

                <input type="text" placeholder="¿Qué servicio buscas?">

                <button type="submit">
                    Buscar
                </button>

            </form>

        </div>

    </section>
    <section class="categories-section">

        <h2>
            Categorías disponibles
        </h2>

        <div class="categories-grid">

            <?php $__currentLoopData = $servicios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $servicio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <div class="category-card">

                    <?php echo e($servicio->nombre); ?>


                </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>

    </section>
    <section class="workers">

        <h3>Trabajadores destacados</h3>

        <div class="workers-grid">

            <?php $__empty_1 = true; $__currentLoopData = $trabajadores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trabajador): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                <div class="worker-card">

                    <div class="worker-avatar">

                        <?php if($trabajador->foto): ?>

                            <img src="<?php echo e(asset('storage/' . $trabajador->foto)); ?>" alt="Foto">

                        <?php else: ?>

                            <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($trabajador->name)); ?>" alt="Foto">

                        <?php endif; ?>

                    </div>

                    <h4>
                        <?php echo e($trabajador->name); ?>

                        <?php echo e($trabajador->apellido); ?>

                    </h4>

                    <p>
                        <?php echo e($trabajador->especialidad ?? 'Sin especialidad'); ?>

                    </p>

                    <p>
                        <?php echo e($trabajador->distrito ?? 'Distrito no registrado'); ?>

                    </p>

                    <a href="<?php echo e(route('trabajadores.show', $trabajador->id)); ?>">
                        Ver perfil
                    </a>

                </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <p>
                    No hay trabajadores registrados todavía.
                </p>

            <?php endif; ?>

        </div>

    </section>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\NewAllin\allin-ruway\resources\views/dashboard/index.blade.php ENDPATH**/ ?>