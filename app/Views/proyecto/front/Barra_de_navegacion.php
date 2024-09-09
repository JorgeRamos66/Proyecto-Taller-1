<?php
$session = session();
$nombre = $session->get('nombre');
$perfil = $session->get('perfil_id');
$id = $session->get('id_usuario');

// Obtener la URL actual
$currentUrl = current_url();
?>
<section>
    <div>
        <div class="border-1 border-primary">
            <nav class="navbar navbar-expand-lg bg-black my-0">
                <button class="navbar-toggler btn btn-outline-danger active" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-1">
                        <li class="nav-item">
                            <a class="nav-toggler btn btn-outline-danger mx-2 my-1 <?= strpos($currentUrl, 'quienes_somos') !== false ? 'active' : '' ?>" href="<?= base_url('quienes_somos'); ?>">Quienes somos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-toggler btn btn-outline-primary mx-2 my-1 <?= strpos($currentUrl, 'comercializacion') !== false ? 'active' : '' ?>" href="<?= base_url('comercializacion'); ?>">Comercializacion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-toggler btn btn-outline-danger mx-2 my-1 <?= strpos($currentUrl, 'informacion_de_contacto') !== false ? 'active' : '' ?>" href="<?= base_url('informacion_de_contacto'); ?>">Informacion de contacto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-toggler btn btn-outline-primary mx-2 my-1 <?= strpos($currentUrl, 'terminos_y_usos') !== false ? 'active' : '' ?>" href="<?= base_url('terminos_y_usos'); ?>">Terminos y usos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-toggler btn btn-outline-danger mx-2 my-1 <?= strpos($currentUrl, 'catalogoDeProductos') !== false ? 'active' : '' ?>" href="<?= base_url('catalogoDeProductos'); ?>">Productos</a>
                        </li>
                    </ul>

                    <div class="col d-flex justify-content-end">
                        <div class="row d-flex">
                            <?php if (!session()->has('loggedIn')): ?>
                                <li class="nav-item btn-group">
                                    <a class="nav-toggler btn btn-sm btn-outline-primary my-1" href="<?= base_url('login'); ?>">Login</a>
                                    <a class="nav-toggler btn btn-sm btn-outline-danger my-1" href="<?= base_url('form-registro'); ?>">Registro</a>
                                </li>
                            <?php elseif (session()->has('loggedIn') && !session()->get('es_admin')): ?>
                                <li class="nav-item btn-group">
                                    <a class="nav-toggler btn btn-sm btn-outline-info my-1 <?= strpos($currentUrl, 'perfil-usuario') !== false ? 'active' : '' ?>" href="<?= base_url('perfil-usuario/' . base64_encode($id)); ?>">Perfil</a>
                                    <a class="nav-toggler btn btn-sm btn-outline-danger my-1" href="<?= base_url('logout'); ?>">Logout</a>
                                </li>
                            <?php else: ?>
                                <li class="nav-item btn-group">
                                    <a class="nav-toggler btn btn-sm btn-outline-warning my-1 <?= strpos($currentUrl, 'panel_admin') !== false ? 'active' : '' ?>" href="<?= base_url('panel_admin'); ?>">Panel Admin</a>
                                    <a class="nav-toggler btn btn-sm btn-outline-danger my-1" href="<?= base_url('logout'); ?>">Logout</a>
                                </li>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex">
                            <?php if (session()->has('loggedIn')): ?>
                                <?php if ($perfil == 1): ?>
                                    <button type="button" class="btn btn-outline-success btn-sm nav-toggler my-1 mx-3">
                                        <a><span style="color: white;">USUARIO:</span> <?= $nombre; ?> </a>
                                    </button>
                                <?php else: ?>
                                    <button type="button" class="btn btn-outline-primary btn-sm nav-toggler my-1 mx-3">
                                        <a><span style="color: white;">CLIENTE:</span> <?= $nombre; ?> </a>
                                    </button>
                                <?php endif; ?>
                                <!-- Botón de Carrito de Compras -->
                                <?php if ($perfil == 1): ?>
                                    <a href="<?= base_url('ver_carrito'); ?>" class="disabled btn btn-sm btn-outline-light my-1 mx-2">
                                        <i class="fas fa-shopping-cart"></i> Carrito
                                    </a>
                                <?php else: ?>
                                    <a href="<?= base_url('ver_carrito'); ?>" class="btn btn-sm btn-outline-light my-1 mx-2">
                                        <i class="fas fa-shopping-cart"></i> Carrito
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</section>
