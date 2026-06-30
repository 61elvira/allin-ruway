<?php $__env->startSection('content'); ?>

    <section id="inicio" class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">


            <h1>
                Encuentra trabajadores de confianza
            </h1>

            <p>
                Conectamos clientes con profesionales
                de manera rápida y segura.
            </p>

            <a href="<?php echo e(route('login')); ?>" class="hero-btn">
                Comenzar
            </a>
        </div>

    </section>


    <section id="servicios" class="section">

        <h2 class="section-title">
            Servicios Disponibles
        </h2>

        <div class="cards">

            <div class="card">
                <img src="<?php echo e(asset('imagenes/trabajo1.png')); ?>" alt="Albañilería">
                <div class="service-content">
                    <h3>Albañilería</h3>
                    <p>
                        Construcción, remodelación
                        y mantenimiento de estructuras.
                    </p>
                </div>
            </div>

            <div class="card">

                <img src="<?php echo e(asset('imagenes/trabajo2.jpg')); ?>" alt="">

                <div class="service-content">

                    <h3>Electricista</h3>

                    <p>
                        Instalaciones eléctricas,
                        mantenimiento y reparación.
                    </p>

                </div>

            </div>

            <div class="card">
                <img src="<?php echo e(asset('imagenes/trabajo3.jpg')); ?>" alt="Carpintería">
                <div class="service-content">

                    <h3>Carpintería</h3>

                    <p>
                        Fabricación y reparación
                        de muebles de madera.
                    </p>

                </div>
            </div>

            <div class="card">
                <img src="<?php echo e(asset('imagenes/trabajo4.jpg')); ?>" alt="Pintura">
                <div class="service-content">

                    <h3>Pintura</h3>

                    <p>
                        Pintado de interiores,
                        exteriores y acabados.
                    </p>

                </div>
            </div>

            <div class="card">
                <img src="<?php echo e(asset('imagenes/trabajo5.jpg')); ?>" alt="Gasfitería">
                <div class="service-content">

                    <h3>Gasfitería</h3>

                    <p>
                        Reparación de tuberías,
                        fugas e instalaciones sanitarias.
                    </p>

                </div>
            </div>

            <div class="card">
                <img src="<?php echo e(asset('imagenes/trabajo6.jpg')); ?>" alt="MultiServicios">
                <div class="service-content">

                    <h3>MultiServicios</h3>

                    <p>
                        Servicios variados
                        para hogares y negocios.
                    </p>

                </div>
            </div>

        </div>

    </section>

    <section id="beneficios" class="beneficios-section">

        <div class="beneficios-container">

            <div class="beneficios-content">

                <h2 class="section-title">
                    ¿Por qué elegir Allin Ruway?
                </h2>

                <div class="beneficio-item">

                    <span>✓</span>

                    <div>
                        <h3>Seguridad Garantizada</h3>
                        <p>
                            Trabajadores previamente evaluados y verificados.
                        </p>
                    </div>

                </div>

                <div class="beneficio-item">

                    <span>✓</span>

                    <div>
                        <h3>Atención Rápida</h3>
                        <p>
                            Encuentra ayuda profesional en pocos minutos.
                        </p>
                    </div>

                </div>

                <div class="beneficio-item">

                    <span>✓</span>

                    <div>
                        <h3>Calidad de Servicio</h3>
                        <p>
                            Profesionales con experiencia y buenas valoraciones.
                        </p>
                    </div>

                </div>

                <div class="beneficio-item">

                    <span>✓</span>

                    <div>
                        <h3>Trabajadores Verificados</h3>
                        <p>
                            Mayor confianza para cada contratación.
                        </p>
                    </div>

                </div>

            </div>

            <div class="beneficios-image">

                <img src="<?php echo e(asset('imagenes/Beneficios.webp')); ?>" alt="Beneficios">

            </div>

        </div>

    </section>

    <section id="soporte" class="section">

        <h2>Soporte</h2>

        <form class="support-form">

            <input type="text" placeholder="Nombre">

            <input type="email" placeholder="Correo">

            <textarea placeholder="Mensaje"></textarea>

            <button type="submit">
                Enviar
            </button>

        </form>

    </section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\NewAllin\allin-ruway\resources\views/casa.blade.php ENDPATH**/ ?>