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
    <div class="rating-container">
        <div class="rating-card">
            <h1>Calificar trabajador</h1>
            <h2><?php echo e($contratacion->trabajador->name); ?> <?php echo e($contratacion->trabajador->apellido); ?></h2>

            <form action="<?php echo e(route('calificaciones.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="contratacion_id" value="<?php echo e($contratacion->id); ?>">
                <input type="hidden" name="trabajador_id" value="<?php echo e($contratacion->trabajador_id); ?>">

                <div class="stars">
                    <?php for($i = 5; $i >= 1; $i--): ?>
                        <input type="radio" id="star<?php echo e($i); ?>" name="puntuacion" value="<?php echo e($i); ?>" required>
                        <label for="star<?php echo e($i); ?>">★</label>
                    <?php endfor; ?>
                </div>

                <textarea name="comentario" rows="5" placeholder="Cuéntanos cómo fue el servicio..."></textarea>
                <button class="rating-btn">Enviar calificación</button>
            </form>
        </div>
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
<?php endif; ?><?php /**PATH C:\xampp\htdocs\NewAllin\allin-ruway\resources\views/calificaciones/create.blade.php ENDPATH**/ ?>