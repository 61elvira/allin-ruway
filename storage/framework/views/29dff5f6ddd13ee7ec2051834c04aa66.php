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
    <section class="dashboard-hero">
        <div class="hero-content">
            <h1>ALLIN RUWAY</h1>
            <p>Encuentra trabajadores confiables para cualquier proyecto.</p>
            <form id="filtroDashboard" action="<?php echo e(route('dashboard')); ?>" method="GET" class="hero-search">
                <input type="text" name="buscar" placeholder="¿Qué servicio buscas?" value="<?php echo e(request('buscar')); ?>">
                <button type="submit" class="search-btn">Buscar</button>
                <button type="button" id="toggleFilters" class="filter-btn">Filtros</button>
            </form>
            <div id="filtersPanel" class="filters-panel">
                <select name="especialidad" form="filtroDashboard">
                    <option value="">Especialidad</option>
                    <?php $__currentLoopData = $servicios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $servicio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($servicio->nombre); ?>" <?php echo e(request('especialidad') == $servicio->nombre ? 'selected' : ''); ?>><?php echo e($servicio->nombre); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <select name="distrito" form="filtroDashboard">
                    <option value="">Distrito</option>
                    <?php $__currentLoopData = config('allinruway.distritos'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $distrito): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($distrito); ?>" <?php echo e(request('distrito') == $distrito ? 'selected' : ''); ?>><?php echo e($distrito); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <select name="experiencia" form="filtroDashboard">
                    <option value="">Experiencia</option>
                    <?php $__currentLoopData = config('allinruway.experiencias'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valor => $texto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($valor); ?>" <?php echo e(request('experiencia') == $valor ? 'selected' : ''); ?>><?php echo e($texto); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
    </section>

    <?php if(!$filtrosActivos): ?>
        <section class="categories-section">
            <h2>Categorías disponibles</h2>
            <div class="categories-grid">
                <?php $__currentLoopData = $servicios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $servicio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('trabajadores.index', ['servicio' => $servicio->id])); ?>" class="category-card">
                        <div class="category-icon">
                            <?php switch($servicio->nombre):
                                case ('Electricista'): ?> ⚡ <?php break; ?>
                                <?php case ('Carpintero'): ?> 🪚 <?php break; ?>
                                <?php case ('Gasfitero'): ?> 🚰 <?php break; ?>
                                <?php default: ?> 🛠️
                            <?php endswitch; ?>
                        </div>
                        <h3><?php echo e($servicio->nombre); ?></h3>
                        <p><?php echo e($servicio->descripcion); ?></p>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </section>
    <?php endif; ?>

    <section class="workers">
        <?php if($filtrosActivos): ?>
            <h3>Se encontraron <?php echo e($trabajadores->total()); ?> resultado(s) para "<?php echo e(request('buscar')); ?>"</h3>
        <?php else: ?>
            <h3>Trabajadores destacados</h3>
        <?php endif; ?>
        <div class="workers-grid">
            <?php $__empty_1 = true; $__currentLoopData = $trabajadores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trabajador): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="worker-card">
                    <div class="worker-avatar">
                        <?php if($trabajador->foto): ?>
                            <img src="<?php echo e(asset('storage/' . $trabajador->foto)); ?>" alt="Foto de <?php echo e($trabajador->name); ?>">
                        <?php else: ?>
                            <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($trabajador->name)); ?>" alt="Avatar de <?php echo e($trabajador->name); ?>">
                        <?php endif; ?>
                    </div>
                    <h4><?php echo e($trabajador->name); ?> <?php echo e($trabajador->apellido); ?></h4>
                    <p><?php echo e($trabajador->especialidad ?? 'Sin especialidad'); ?></p>
                    <p><?php echo e($trabajador->distrito ?? 'Distrito no registrado'); ?></p>
                    <a href="<?php echo e(route('trabajadores.show', $trabajador->id)); ?>">Ver perfil</a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p>No hay trabajadores registrados todavía.</p>
            <?php endif; ?>
        </div>
        <div class="pagination-container">
            <?php echo e($trabajadores->links()); ?>

        </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', () => {

        const boton = document.getElementById('toggleFilters');
        const panel = document.getElementById('filtersPanel');

        boton.addEventListener('click', () => {
            panel.classList.toggle('active');
        });

        <?php if($filtrosActivos): ?>

        document.querySelector('.workers').scrollIntoView({
            behavior: 'smooth'
        });

        <?php endif; ?>

    });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\NewAllin\allin-ruway\resources\views/dashboard/index.blade.php ENDPATH**/ ?>