# Allin Ruway

Marketplace de servicios generales que conecta clientes con trabajadores especializados en oficios como electricidad, carpinteria, gasfiteria, pintura, albanileria y jardineria.

---

## Roles del sistema

La plataforma cuenta con tres roles: administrador, trabajador y cliente. Cada rol tiene acceso a un conjunto especifico de modulos dentro de un unico panel unificado.

### Administrador

Panel de gestion ubicado en la ruta `/admin`.

| Modulo | Acciones disponibles |
|---|---|
| Dashboard | Visualizacion de metricas generales: total de usuarios, contrataciones, calificacion promedio, servicios registrados. Graficos de contrataciones por mes, usuarios por rol e ingresos por mes. Tabla de ultimos usuarios registrados, ultimas contrataciones, distritos con mas trabajadores y top 5 trabajadores mejor calificados. Accesos rapidos a gestion de usuarios y servicios. |
| Usuarios | Listado paginado con filtros por nombre, apellido, email y rol. Cambio de rol entre admin, trabajador y cliente. Eliminacion de usuarios (no permite autoeliminacion). Exportacion a CSV con los filtros aplicados. |
| Contrataciones | Listado paginado con filtros por estado y rango de fechas. Vista de detalle con informacion completa del cliente, trabajador, servicio, fecha, direccion y calificacion. Cambio manual del estado de la contratacion. Exportacion a CSV. |
| Servicios | Listado con contador de contrataciones por servicio. Creacion, edicion y eliminacion de servicios mediante modal. Exportacion a CSV. |

### Trabajador

Modulos de gestion personal ubicados en la ruta `/trabajador`.

| Modulo | Acciones disponibles |
|---|---|
| Dashboard | Vista general con estadisticas personalizadas: solicitudes pendientes, trabajos activos, trabajos finalizados, promedio de calificacion, total ganado, servicios ofrecidos y grafico de contrataciones por mes. |
| Mis Servicios | Gestion de los servicios que el trabajador ofrece, con precio por servicio. Creacion de nuevo servicio vinculado a las categorias disponibles, edicion de precio y eliminacion. |
| Disponibilidad | Configuracion de horarios por dia de la semana. Creacion de bloques horarios (dia, hora inicio, hora fin), activacion/desactivacion y eliminacion. |
| Solicitudes | Listado de contrataciones pendientes recibidas. Visualizacion de datos del cliente, servicio solicitado, fecha, direccion y descripcion. Botones para aceptar o rechazar la solicitud. |
| Mis Trabajos | Listado de trabajos aceptados y en curso. Visualizacion de datos del cliente y servicio. Boton para marcar como terminado. |
| Ganancias | Vista de ingresos generados con filtro por rango de fechas y periodo (hoy, esta semana, este mes, este ano). Total de ganancias, monto pendiente y monto pagado. |
| Resenas | Listado de calificaciones recibidas de clientes, con puntuacion, comentario, nombre del cliente y fecha. Promedio general de calificacion. |
| Historial | Listado de contrataciones finalizadas con datos del cliente, servicio y fechas. |

### Cliente

| Modulo | Acciones disponibles |
|---|---|
| Dashboard | Vista general con contrataciones activas, pendientes y finalizadas. Grafico de contrataciones por mes. Listado de servicios disponibles. |
| Trabajadores | Listado de trabajadores disponibles con busqueda por nombre, distrito y especialidad. Pagina de perfil individual con informacion del trabajador, calificacion promedio, opiniones de clientes, servicios ofrecidos con precios y disponibilidad semanal. Boton para contratar. |
| Contratar | Formulario de contratacion con seleccion de servicio, fecha, direccion y descripcion del trabajo requerido. |
| Mis Contrataciones | Listado de todas las contrataciones realizadas con estado, datos del trabajador, servicio, fecha y calificacion si existe. |
| Calificar | Formulario de calificacion para contrataciones finalizadas, con puntuacion de 1 a 5 y comentario opcional. |

### Modulos compartidos

| Modulo | Acciones disponibles |
|---|---|
| Mi Perfil | Edicion de datos personales: nombre, apellido, email, telefono, distrito y contraseña. Eliminacion de cuenta. |

---

## Tecnologias utilizadas

| Componente | Tecnologia |
|---|---|
| Backend | PHP 8.2, Laravel 12 |
| Base de datos | MySQL 8.0 |
| Frontend | HTML, CSS, JavaScript vanilla, Chart.js 4.4.1 |
| Diseño responsive | CSS Grid, Flexbox, media queries |
| Contenedores | Docker, docker-compose (PHP-FPM, Nginx, MySQL, Redis) |
| Compilacion de assets | Vite |
| Testing | Pest PHP, PHPUnit, SQLite (in-memory para tests) |
| Control de versiones | Git |

---

## Seguridad

- **Contraseñas**: Almacenadas con algoritmo de hashing `bcrypt` mediante la implementacion nativa de Laravel (`Hash::make` / `Hash::check`). No se almacenan contraseñas en texto plano.
- **Autenticacion**: Sesiones manejadas por Laravel con cookie segura y token CSRF en cada formulario.
- **Autorizacion**: Middleware `CheckRole` que valida el rol del usuario (admin, trabajador, cliente) antes de permitir el acceso a rutas protegidas.
- **Verificacion de email**: Columna `email_verified_at` implementada; el middleware `verified` esta disponible para rutas que requieran confirmacion de correo.
- **Proteccion CSRF**: Todas las rutas POST, PATCH y DELETE requieren un token CSRF valido, manejado automaticamente por Laravel.
- **SQL Injection**: Prevenido mediante Eloquent ORM y consultas parametrizadas.

---

## Instalacion y ejecucion (XAMPP en Windows)

### Requisitos

- [XAMPP](https://www.apachefriends.org/) con PHP 8.2 o superior, Apache y MySQL
- [Composer](https://getcomposer.org/) (instalador para Windows)
- [Node.js](https://nodejs.org/) (para compilar assets con Vite)

### Pasos

1. Iniciar Apache y MySQL desde el panel de control de XAMPP.

2. Abrir phpMyAdmin (`http://localhost/phpmyadmin`) y crear una base de datos llamada `allin_ruway`.

3. Clonar el repositorio dentro de la carpeta `htdocs` de XAMPP:

```
C:\xampp\htdocs>
git clone <url-del-repositorio> allin-ruway
cd allin-ruway
```

4. Copiar el archivo de entorno y configurar la base de datos:

```
copy .env.example .env
```

5. Editar el archivo `.env` y ajustar estos valores:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=allin_ruway
DB_USERNAME=root
DB_PASSWORD=
```

Si tu MySQL tiene contraseña, colocala en `DB_PASSWORD`. Si usas un puerto distinto al 3306, ajusta `DB_PORT`.

6. Instalar dependencias del proyecto:

```
composer install
npm install
npm run build
```

7. Generar la clave de la aplicacion:

```
php artisan key:generate
```

8. Ejecutar migraciones y seeders para crear las tablas y los datos demo:

```
php artisan migrate:fresh --seed
```

9. Iniciar el servidor de desarrollo de Laravel:

```
php artisan serve
```

La aplicacion estara disponible en `http://127.0.0.1:8000`.

Si deseas usar Apache en lugar de `php artisan serve`, configura un VirtualHost en XAMPP apuntando a la carpeta `public` del proyecto.

### Solucion de problemas con MySQL

**Error "SQLSTATE[HY000] [1045] Access denied for user"**: Verifica que `DB_USERNAME` y `DB_PASSWORD` en `.env` coincidan con las credenciales de tu MySQL en XAMPP. Por defecto XAMPP usa `root` sin contraseña.

**Error "SQLSTATE[HY000] [2002] Connection refused"**: Asegurate de que MySQL este corriendo en el panel de control de XAMPP y que el puerto `DB_PORT` sea correcto (por defecto 3306).

**Error "Target database is already in use"**: Ejecuta `php artisan migrate:fresh` para reconstruir todas las tablas desde cero.

### Usuarios demo

| Rol | Email | Contraseña |
|---|---|---|
| Administrador | admin@allinruway.com | admin123 |
| Trabajador | trabajador@test.com | 12345678 |
| Cliente | cliente@test.com | 12345678 |

### Ejecutar tests

Los tests usan SQLite en memoria, por lo que no requieren conexion a MySQL:

```
php artisan test
```
