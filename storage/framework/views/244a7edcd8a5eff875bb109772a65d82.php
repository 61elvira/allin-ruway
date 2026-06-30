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

    <div class="max-w-3xl mx-auto py-10">

        <h1 class="text-2xl font-bold mb-6">
            Solicitar contratación
        </h1>

        <form method="POST" action="<?php echo e(route('contrataciones.store')); ?>" class="space-y-4">
            <?php echo csrf_field(); ?>

            <!-- Trabajador -->
            <input type="hidden" name="trabajador_id" value="<?php echo e($trabajador->id); ?>">

            <div>
                <label>Trabajador</label>
                <input type="text"
                       value="<?php echo e($trabajador->name); ?> <?php echo e($trabajador->apellido); ?>"
                       disabled
                       class="w-full border rounded p-2">
            </div>

            <!-- Servicio -->
            <div>
                <label>Servicio</label>
                <select name="servicio_id" class="w-full border rounded p-2" required>
                    <option value="">Selecciona un servicio</option>

                    <?php $__currentLoopData = $servicios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $servicio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($servicio->id); ?>">
                            <?php echo e($servicio->nombre); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </select>
            </div>

            <!-- Fecha -->
            <div>
                <label>Fecha del servicio</label>
                <input type="date" name="fecha" class="w-full border rounded p-2" required>
            </div>

            <!-- Dirección -->
            <div>
                <label>Dirección</label>
                <input type="text" name="direccion" class="w-full border rounded p-2" required>
            </div>

            <!-- Descripción -->
            <div>
                <label>Descripción (opcional)</label>
                <textarea name="descripcion" class="w-full border rounded p-2"></textarea>
            </div>

            <button class="bg-red-600 text-white px-4 py-2 rounded">
                Enviar solicitud
            </button>

        </form>

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
<?php endif; ?><?php /**PATH C:\xampp\htdocs\NewAllin\allin-ruway\resources\views/contrataciones/create.blade.php ENDPATH**/ ?>