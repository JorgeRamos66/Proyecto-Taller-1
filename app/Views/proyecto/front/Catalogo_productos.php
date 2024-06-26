<?php
$session = session();
$nombre = $session->get('nombre');
$perfil = $session->get('perfil_id');
$id = $session->get('id_usuario');
?>

<section class="container mt-5 py-1" style="backdrop-filter: blur(10px); background-color: rgba(255, 255, 255, 0.2); border-radius: 10px;">
    <div class="d-flex justify-content-center my-2">
        <h2 class="mb-4 btn btn-lg btn-outline-danger disabled bg-black">Catálogo de Productos</h2>
    </div>
    
    <div class="d-flex justify-content-between mb-3">
    <!-- Formulario de Búsqueda -->
    <form class="" method="get" action="<?= base_url('catalogoDeProductos'); ?>">
        <button type="submit" class="m-auto btn btn-sm btn-outline-danger" style="display: inline-block;">Buscar</button>
        <a href="<?= base_url('catalogoDeProductos'); ?>"><button type="button" class="btn btn-sm btn-outline-light" style="display: inline-block;">Borrar</button></a>
        <input type="text" name="search" class="form-control form-control-sm me-2 bg-light border-danger col-3" placeholder="Buscar producto" value="<?= isset($search) ? esc($search) : ''; ?>" />
    </form>
    

    <!-- Selector para el número de productos por página -->
    <form method="get" action="<?= base_url('catalogoDeProductos'); ?>" class="d-flex align-items-center">
        <div class="input-group">
            <label class="input-group-text" for="itemsPerPage">Mostrar</label>
            <select name="itemsPerPage" id="itemsPerPage" class="form-select" onchange="this.form.submit()">
                <option value="6" <?= $itemsPerPage == 6 ? 'selected' : ''; ?>>6</option>
                <option value="12" <?= $itemsPerPage == 12 ? 'selected' : ''; ?>>12</option>
                <option value="18" <?= $itemsPerPage == 18 ? 'selected' : ''; ?>>18</option>
            </select>
            <span class="input-group-text">productos</span>
        </div>
    </form>
</div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-6 row-cols-md-4 g-3">
        <?php foreach ($productos as $producto): ?>
            <div class="col">
                <div class="card h-100 text-center" style="backdrop-filter: blur(5px); background-color: rgba(255, 255, 255, 0.8); height: 300px;">
                    <img src="<?= base_url('assets/uploads/'.$producto['imagen_producto']); ?>" class="card-img-top" alt="<?= $producto['nombre_producto']; ?>" style="height: 150px; object-fit:scale-down;">
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
    <div class="d-flex justify-content-center mt-3">
        <?= $pager->links('productos', 'bootstrap5_full'); ?>
    </div>
</section>