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

    <section class="worker-profile">

        <div class="worker-profile-card">

            <div class="worker-photo">

                <?php if($trabajador->foto): ?>

                    <img src="<?php echo e(asset('storage/' . $trabajador->foto)); ?>" alt="Foto">

                <?php else: ?>

                    <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($trabajador->name)); ?>" alt="Foto">

                <?php endif; ?>

            </div>

            <div class="worker-info">

                <h1>
                    <?php echo e($trabajador->name); ?>

                    <?php echo e($trabajador->apellido); ?>

                </h1>

                <span class="worker-specialty">
                    <?php echo e($trabajador->especialidad); ?>

                </span>

                <p>
                    📍 <?php echo e($trabajador->distrito); ?>

                </p>

                <p>
                    💼 <?php echo e($trabajador->experiencia); ?>

                </p>

                <div class="worker-description">

                    <h3>Sobre mí</h3>

                    <p>
                        <?php echo e($trabajador->descripcion); ?>

                    </p>

                </div>

                <a href="<?php echo e(route('contrataciones.create', $trabajador->id)); ?>" class="hire-btn">
                    Contratar trabajador
                </a>

            </div>

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
<?php endif; ?><?php /**PATH C:\xampp\htdocs\NewAllin\allin-ruway\resources\views/trabajadores/show.blade.php ENDPATH**/ ?>