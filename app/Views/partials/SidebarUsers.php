<ul class="list-unstyled components px-3">
    <?php if ((int) $session_user->role->nivel === 5): ?>
        <li>
            <a href="#procesosSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle d-flex justify-content-between">
                <span><span class="fas fa-rotate"></span> Prestamo circulante</span>
                <span class="fal fa-plus"></span>
            </a>
            <ul class="collapse list-unstyled mt-1" id="procesosSubmenu">
                <li>
                    <a href="<?php echo $helpers->generateUrl('prestamos', 'generateprestamo') ?>">Prestamo de libros</a>
                </li>
                <li>
                    <a href="<?php echo $helpers->generateUrl('prestamos', 'returnprestamo') ?>">Devolucion de libros</a>
                </li>
            </ul>
        </li>
    <?php endif; ?>

    <?php if ((int) $session_user->role->nivel === 5): ?>
        <li>
            <a href="<?php echo $helpers->generateUrl('solicitante', 'index') ?>"><span class="fas fa-book-open-reader"></span> Solicitantes</a>
        </li>
    <?php endif; ?>

    <li>
        <a href="<?php echo $helpers->generateUrl('libro', 'index') ?>"><span class="fas fa-book-open"></span> Libros</a>
    </li>

    <?php if ((int) $session_user->role->nivel === 1): ?>
        <li>
            <a href="<?php echo $helpers->generateUrl('participantes', 'index') ?>"><span class="far fa-calendar"></span> Eventos</a>
        </li>
    <?php endif; ?>

    <?php if ((int) $session_user->role->nivel === 1): ?>
        <li>
            <a href="<?php echo $helpers->generateUrl('news', 'index') ?>"><span class="far fa-newspaper"></span> Noticias</a>
        </li>
    <?php endif; ?>
    <li>
        <a href="<?php echo $helpers->generateUrl('user', 'details', [ 'id' => $session_user->id ]) ?>"><span class="far fa-user"></span> Perfil</a>
    </li>

    <?php if ((int) $session_user->role->nivel === 5): ?>
        <li>
            <a href="#pageSubmenu" data-bs-toggle="collapse"x` aria-expanded="false" class="dropdown-toggle d-flex justify-content-between">
                <span><span class="fas fa-bars"></span> Configuración</span>
                <span class="fal fa-plus"></span>
            </a>
            <ul class="collapse list-unstyled mt-1" id="pageSubmenu">
                <li>
                    <a href="<?php echo $helpers->generateUrl('category') ?>">Categorías</a>
                </li>
            </ul>
        </li>
    <?php endif; ?>

    <li>
        <a href="<?php echo $helpers->generateUrl('auth', 'profile') ?>"><span class="far fa-circle-question"></span> Ayuda</a>
    </li>
</ul>
