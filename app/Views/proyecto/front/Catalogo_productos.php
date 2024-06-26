<?php
$session = session();
$nombre = $session->get('nombre');
$perfil = $session->get('perfil_id');
$id = $session->get('id_usuario');
?>

<section class="container mt-5 py-1" style="backdrop-filter: blur(10px); background-color: rgba(255, 255, 255, 0.2); border-radius: 10px;">
    <div class="d-flex justify-content-center my-2">
        <h2 class="mb-4 btn btn-lg btn-outline-success disabled bg-black">Catálogo de Productos</h2>
    </div>
    
    <!-- Selector para el número de productos por página -->
    <div class="d-flex justify-content-end mb-3">
        <form method="get" action="<?= base_url('listar-productos'); ?>">
            <div class="input-group">
                <label class="input-group-text" for="itemsPerPage">Mostrar</label>
                <select name="itemsPerPage" id="itemsPerPage" class="form-select" onchange="this.form.submit()">
                    <option value="4" <?= $itemsPerPage == 4 ? 'selected' : ''; ?>>4</option>
                    <option value="8" <?= $itemsPerPage == 8 ? 'selected' : ''; ?>>8</option>
                    <option value="12" <?= $itemsPerPage == 12 ? 'selected' : ''; ?>>12</option>
                </select>
                <span class="input-group-text">productos</span>
            </div>
        </form>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
        <?php foreach ($productos as $producto): ?>
            <div class="col">
                <div class="card h-100 text-center" style="backdrop-filter: blur(5px); background-color: rgba(255, 255, 255, 0.8); height: 300px;">
                    <img src="<?= base_url('assets/uploads/'.$producto['imagen_producto']); ?>" class="card-img-top" alt="<?= $producto['nombre_producto']; ?>" style="height: 150px; object-fit: cover;">
                    <div class="card-body">
                        <h6 class="card-title" style="font-size: 0.9rem;"><?= $producto['nombre_producto']; ?></h6>
                        <p class="card-text" style="font-size: 0.8rem;">$<?= number_format($producto['precio_producto'], 2); ?></p>
                        <form action="<?= base_url('comprar-producto/'.$producto['id_producto']); ?>" method="post">
                            <?php if (session()->has('loggedIn')): ?>
                                <button type="submit" class="btn btn-outline-primary">Comprar</button>
                            <?php else: ?>
                                <button type="submit" class="btn btn-outline-primary" disabled>Comprar</button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Sistema de paginación -->
    <!-- Sistema de paginación -->
<div class="d-flex justify-content-center mt-3">
    <?php
        $pager->setPath('listar-productos'); // Establecer la ruta base

        // Obtener la URL actual sin la paginación
        $currentUrl = current_url() . '?' . http_build_query($_GET);

        // Cambiar el parámetro de la página en la URL
        echo str_replace('&amp;page=', '&page=', $pager->links('productos', 'bootstrap5_full'));
    ?>
</div>
</section>