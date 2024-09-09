<?php
$session = session();
$nombre = $session->get('nombre');
$perfil = $session->get('perfil_id');

// Obtener la URL actual
$currentUrl = current_url();
?>
<section class="">
    <div class="">
        <div class="">
            <div class="border-1 border-primary">
                <nav class="navbar navbar-expand-lg bg-black my-0">
                    <button class="navbar-toggler btn btn-outline-danger active" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-1">
                            <li class="nav-item">
                                <a class="nav-toggler btn btn-outline-warning mx-2 my-1 <?= strpos($currentUrl, 'gestion_usuarios') !== false ? 'active' : '' ?>" href="<?= base_url('gestion_usuarios'); ?>">Gestion usuarios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-toggler btn btn-outline-success mx-2 my-1 <?= strpos($currentUrl, 'gestion_productos') !== false ? 'active' : '' ?>" href="<?= base_url('gestion_productos'); ?>">Gestion productos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-toggler btn btn-outline-warning mx-2 my-1 <?= strpos($currentUrl, 'ver_ventas') !== false ? 'active' : '' ?>" href="<?= base_url('ver_ventas'); ?>">Ventas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-toggler btn btn-outline-success mx-2 my-1 <?= strpos($currentUrl, 'gestion_consultas') !== false ? 'active' : '' ?>" href="<?= base_url('gestion_consultas'); ?>">Gestion consultas</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-toggler btn btn-outline-warning mx-2 my-1 <?= strpos($currentUrl, 'facturacion') !== false ? 'active' : '' ?>" href="<?= base_url('facturacion'); ?>">Facturaciones</a>
                            </li>
                        </ul>
                        <div class="col d-flex justify-content-end">
                            <div class="d-flex">
                                <li class="nav-item btn-group">
                                    <a class="nav-toggler btn btn-sm btn-outline-primary my-1" href="<?= base_url('/'); ?>">Inicio</a>
                                    <a class="nav-toggler btn btn-sm btn-outline-danger my-1" href="<?= base_url('logout'); ?>">Logout</a>
                                </li>
                                <button type="button" class="btn btn-outline-success btn-sm nav-toggler my-1 mx-3">
                                    <a><span style="color: white;">USUARIO:</span> <?= $nombre; ?></a>
                                </button>
                            </div>
                        </div>
                </nav>
            </div>

        </div>
    </div>
</section>