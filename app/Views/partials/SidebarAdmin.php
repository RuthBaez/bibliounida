<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Colapsable</title>
    <!-- Carga de Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Carga de Font Awesome para los íconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        /* Estilo para los enlaces de los submenús */
        .components a {
            color: white !important; /* Color blanco */
            text-decoration: none !important; /* Elimina el subrayado */
        }

        /* Opcional: Cambiar color al pasar el ratón (hover) */
        .components a:hover {
            color: #007bff; /* Color de texto cuando se pasa el ratón */
            text-decoration: none; /* Asegura que no haya subrayado en hover */
        }

        /* Estilo para los íconos, si es necesario */
        .dropdown-toggle i {
            color: white; /* Color blanco para los íconos */
        }
    </style>
</head>

<body class="bg-dark">
    <div class="container mt-5">
        <!-- Menú con submenús colapsables -->
        <ul class="list-unstyled components px-3">
            <!-- Submenú 1: Registros -->
            <li>
                <a href="#homeSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle d-flex justify-content-between">
                    <span>Registros</span>
                    <span class="fal fa-plus"></span> <!-- Se mantiene el ícono original -->
                </a>
                <ul class="collapse list-unstyled mt-1" id="homeSubmenu">
                    <li><a href="<?php echo $helpers->generateUrl('solicitante', 'register') ?>">Solicitante</a></li>
                    <li><a href="<?php echo $helpers->generateUrl('libro', 'register') ?>">Libro</a></li>
                </ul>
            </li>

            <!-- Submenú 2: Procesos -->
            <li>
                <a href="#procesosSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle d-flex justify-content-between">
                    <span>Procesos</span>
                    <span class="fal fa-plus"></span> <!-- Se mantiene el ícono original -->
                </a>
                <ul class="collapse list-unstyled mt-1" id="procesosSubmenu">
                    <li><a href="<?php echo $helpers->generateUrl('prestamos', 'generateprestamo') ?>">Préstamo de libros</a></li>
                    <li><a href="<?php echo $helpers->generateUrl('prestamos', 'returnprestamo') ?>">Devolución de libros</a></li>
                </ul>
            </li>

            <!-- Submenú 3: Consultas -->
            <li>
                <a href="#consultasSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle d-flex justify-content-between">
                    <span>Consultas</span>
                    <span class="fal fa-plus"></span> <!-- Se mantiene el ícono original -->
                </a>
                <ul class="collapse list-unstyled mt-1" id="consultasSubmenu">
                    <li><a href="<?php echo $helpers->generateUrl('solicitante', 'index') ?>">Solicitantes</a></li>
                    <li><a href="<?php echo $helpers->generateUrl('libro', 'index') ?>">Libros</a></li>
                    <li><a href="<?php echo $helpers->generateUrl('prestamos', 'index') ?>">Préstamos</a></li>
                </ul>
            </li>

            <!-- Submenú 4: Configuración -->
            <li>
                <a href="#pageSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle d-flex justify-content-between">
                    <span>Configuración</span>
                    <span class="fal fa-plus"></span> <!-- Se mantiene el ícono original -->
                </a>
                <ul class="collapse list-unstyled mt-1" id="pageSubmenu">
                    <li><a href="<?php echo $helpers->generateUrl('user') ?>">Usuarios</a></li>
                    <li><a href="<?php echo $helpers->generateUrl('category') ?>">Categorías</a></li>
                    <li><a href="<?php echo $helpers->generateUrl('user', 'details', ['id' => $session_user->id]) ?>">Perfil</a></li>
                </ul>
            </li>

                <a href="<?php echo $helpers->generateUrl('auth', 'logout') ?>">
                    <span class="fas fa-sign-out-alt"></span> Cerrar sesión
                </a>
            </li>
        </ul>
    </div>

    <!-- Carga de Bootstrap JS y Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
