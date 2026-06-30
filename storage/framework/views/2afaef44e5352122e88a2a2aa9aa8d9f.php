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
    <div class="requests-container">
        <h1 class="requests-title">Mis trabajos</h1>

        <?php $__empty_1 = true; $__currentLoopData = $contrataciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contratacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="request-card">
                <div class="request-header">
                    <h2><?php echo e($contratacion->cliente->name); ?> <?php echo e($contratacion->cliente->apellido); ?></h2>
                    <span class="request-status">Aceptado</span>
                </div>
                <div class="request-body">
                    <p><strong>Servicio:</strong> <?php echo e($contratacion->servicio->nombre); ?></p>
                    <p><strong>Fecha:</strong> <?php echo e($contratacion->fecha); ?></p>
                    <p><strong>Dirección:</strong> <?php echo e($contratacion->direccion); ?></p>
                    <p><strong>Descripción:</strong> <?php echo e($contratacion->descripcion); ?></p>
                    <div class="request-actions">
                        <form action="<?php echo e(route('contrataciones.finalizar', $contratacion->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button class="finish-btn">Marcar como terminado</button>
                        </form>
                    </div>

                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty-requests">
                <h2>No tienes trabajos aceptados.</h2>
            </div>
        <?php endif; ?>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\NewAllin\allin-ruway\resources\views/contrataciones/mis-trabajos.blade.php ENDPATH**/ ?>