<?php if (session()->getFlashdata('agregado')): ?>
    <div class="container col-4 alert alert-success text-center fs-6 alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('agregado') ?>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif;?>

<?php if (session()->getFlashdata('activado')): ?>
    <div class="container col-4 alert alert-success text-center fs-6 alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('activado') ?>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif;?>

<?php if (session()->getFlashdata('eliminado')): ?>
    <div class="container col-4 alert alert-dark text-center fs-6 alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('eliminado') ?>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif;?>

<section class="container mt-5 py-1" style="backdrop-filter: blur(10px); background-color: rgba(255, 255, 255, 0.2); border-radius: 10px;">
    <div class="d-flex justify-content-center my-2">
        <h2 class="mb-4 btn btn-lg btn-outline-success disabled bg-black">Gestion Productos</h2>
    </div>

    

    <!-- Formulario de Búsqueda -->
    <div class="d-flex justify-content-center mb-2">
        <form class="d-flex justify-content-end col-2 mb-3" method="get" action="<?= base_url('gestion_productos'); ?>">
            <input type="text" name="search" class="form-control form-control-sm me-2 bg-light border-success" placeholder="Buscar producto" value="<?= isset($search) ? esc($search) : ''; ?>" />
            <button type="submit" class="btn btn-sm btn-outline-success">Buscar</button>
        </form>
        <a href="<?= base_url('gestion_productos'); ?>"><button type="button" class="btn btn-sm btn-outline-dark">Borrar</button>
        </a>
    </div>
    
    
    

    

    <table class="table table-success table-hover table-striped table-bordered align-middle text-center">
        <thead class="thead-dark">
            <tr class="align-middle">
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Categoria</th>
                <th>Precio</th>
                <th>Marca</th>
                <th>Descripcion</th>
                <th>Stock</th>
                <th>Eliminado?</th>
                <th class="text-center">
                    <a href="<?= base_url('form-producto'); ?>">
                        <button type="button" class="btn btn-sm btn-outline-success">Agregar producto</button>
                    </a></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>
                <tr class="<?= $producto['eliminado_producto'] == 'SI' ? 'table-dark' : '' ?>">
                    <?php $imagen = $producto['imagen_producto']; ?>
                    <?php $id = $producto['id_producto']; ?>

                    <td><?= $producto['nombre_producto']; ?></td>
                    <td>
                        <img height="70px" width="85px" src="<?= base_url('assets/uploads/'.$imagen); ?>" alt="">
                    </td>
                    <?php $cat = $producto['id_categoria'] - 1; ?>
                    <td><?= $categorias[$cat]['descripcion_categoria']; ?></td>
                    <td>$<?= number_format($producto['precio_producto'], 2); ?></td>
                    <td><?= $producto['marca_producto']; ?></td>
                    <td><?= $producto['descripcion_producto']; ?></td>
                    <td class="<?= $producto['stock_producto'] == 0 && $producto['eliminado_producto'] == 'NO' ? 'table-light' : '' ?>">
                        <?= $producto['stock_producto'] == 0 ? 'Sin stock!' : $producto['stock_producto'] . ' ' . ($producto['stock_producto'] == 1 ? 'unidad' : 'unidades'); ?>
                    </td>
                    <td><?= $producto['eliminado_producto']; ?></td>
                    <td class="align-middle">
                        <div class="btn-group">
                            <?php if ($producto['eliminado_producto'] == 'NO'): ?>
                                <a href="<?= base_url('editar-producto/'.$id); ?>" class="btn btn-sm btn-outline-light">Editar</a>
                                <a href="<?= base_url('eliminar-producto/'.$id); ?>" class="btn btn-sm btn-outline-dark">Borrar</a>
                            <?php else: ?>
                                <a href="<?= base_url('editar-producto/'.$id); ?>" class="btn btn-sm btn-outline-light">Editar</a>
                                <a href="<?= base_url('activar-producto/'.$id); ?>" class="btn btn-sm btn-outline-success">Activar</a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($productos)): ?>
                <tr>
                    <td colspan="9" class="text-center">No hay productos disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
        <?= $pager->links('productos', 'bootstrap5_full'); ?>
    </div>
</section>