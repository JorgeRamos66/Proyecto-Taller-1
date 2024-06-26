<?php
$session = session();
$nombre = $session->get('nombre');
$perfil = $session->get('perfil_id');
$id = $session->get('id_usuario');
?>
<?php if (session()->getFlashdata('msj')): ?>
    <div class="container col-4 alert alert-success text-center fs-6 alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('msj') ?>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif;?>
<section class="container mt-5 py-1" style="backdrop-filter: blur(10px); background-color: rgba(255, 255, 255, 0.2); border-radius: 10px;">
    <div class="d-flex justify-content-center my-2">
        <h2 class="mb-4 btn btn-lg btn-outline-danger disabled bg-black">Catálogo de Productos</h2>
    </div>
    
    <div class="d-flex justify-content-between mb-3">
    <!-- Formulario de Búsqueda -->
    <form class="col-9" method="get" action="<?= base_url('catalogoDeProductos'); ?>">
        <button type="submit" class="m-auto btn btn-sm btn-outline-danger" style="display: inline-block;">Buscar</button>
        <a href="<?= base_url('catalogoDeProductos'); ?>"><button type="button" class="btn btn-sm btn-outline-light" style="display: inline-block;">Borrar</button></a>
        <input type="text" name="search" class="form-control form-control-sm me-2 bg-light border-danger col-3" placeholder="Buscar producto" value="<?= isset($search) ? esc($search) : ''; ?>" />
    </form>
    

    <!-- Selector para el número de productos por página -->
    <form method="get" action="<?= base_url('catalogoDeProductos'); ?>" class="d-flex align-items-center">
        <div class="input-group">
            <label class="input-group-text" for="itemsPerPage">Mostrar</label>
            <select name="itemsPerPage" id="itemsPerPage" class="form-select" onchange="this.form.submit()">
                <option value="5" <?= $itemsPerPage == 5 ? 'selected' : ''; ?>>5</option>
                <option value="10" <?= $itemsPerPage == 10 ? 'selected' : ''; ?>>10</option>
                <option value="15" <?= $itemsPerPage == 15 ? 'selected' : ''; ?>>15</option>
            </select>
            <span class="input-group-text">productos</span>
        </div>
    </form>
</div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-5 row-cols-md-4 g-3">
        <?php foreach ($productos as $producto): ?>
            <div class="col">
                <div class="card h-100 text-center" style="backdrop-filter: blur(5px); background-color: rgba(255, 255, 255, 0.8); height: 300px;">
                    <img src="<?= base_url('assets/uploads/'.$producto['imagen_producto']); ?>" class="card-img-top" alt="<?= $producto['nombre_producto']; ?>" style="height: 150px; object-fit:scale-down;">
                    <div class="card-body">
                        <h6 class="card-title" style="font-size: 0.9rem;"><?= $producto['nombre_producto']; ?></h6>
                        <p class="card-text" style="font-size: 0.8rem;">Precio: $<?= number_format($producto['precio_producto'], 2); ?></p>
                        <form action="<?= base_url('comprar-producto/'.$producto['id_producto']); ?>" method="post">
                            <?php if (session()->has('loggedIn')): ?>
                                <button type="button" class="btn btn-outline-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#compraModal"
                                data-id="<?= $producto['id_producto']; ?>"
                                data-nombre="<?= $producto['nombre_producto']; ?>"
                                data-marca="<?= $producto['marca_producto']; ?>"
                                data-descripcion="<?= $producto['descripcion_producto']; ?>"
                                data-precio="<?= $producto['precio_producto']; ?>"
                                data-stock="<?= $producto['stock_producto']; ?>"
                                data-imagen="<?= base_url('assets/uploads/'.$producto['imagen_producto']); ?>">
                            Comprar
                        </button>
                            <?php else: ?>
                                <button type="submit" class="btn btn-outline-danger" disabled>Comprar</button>
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
<!-- Modal -->
<div class="modal fade" id="compraModal" tabindex="-1" aria-labelledby="compraModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="compraModalLabel">Comprar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 text-center">
                        <img id="productoImagen" src="" alt="Imagen del Producto" class="img-fluid rounded" style="max-height: 300px;">
                    </div>
                    <div class="col-md-6">
                        <h5 id="productoNombre"></h5>
                        <p><strong>Marca:</strong> <span id="productoMarca"></span></p>
                        <p><strong>Descripción:</strong> <span id="productoDescripcion"></span></p>
                        <p><strong>Precio:</strong> $<span id="productoPrecio"></span></p>
                        <p><strong>Stock:</strong> <span id="productoStock"></span></p>
                        <form id="formComprar" action="<?= base_url('agregar_carrito'); ?>" method="post">
                            <input type="hidden" name="id_producto" id="productoId">
                            <input type="hidden" name="precio" id="hiddenProductoPrecio">
                            <input type="hidden" name="nombre_producto" id="hiddenProductoNombre">
                            <div class="mb-3">
                                <label for="productoCantidad" class="form-label">Cantidad:</label>
                                <input type="number" name="cantidad" id="productoCantidad" class="form-control" min="1" required>
                            </div>
                            <button type="submit" class="btn btn-outline-success">Agregar al Carrito</button>
                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var compraModal = document.getElementById('compraModal');
    compraModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var nombre = button.getAttribute('data-nombre');
        var marca = button.getAttribute('data-marca');
        var descripcion = button.getAttribute('data-descripcion');
        var precio = button.getAttribute('data-precio');
        var stock = button.getAttribute('data-stock');
        var imagen = button.getAttribute('data-imagen');

        var modalTitle = compraModal.querySelector('.modal-title');
        modalTitle.textContent = 'Comprar ' + nombre;

        var productoImagen = compraModal.querySelector('#productoImagen');
        productoImagen.src = imagen;

        var productoNombre = compraModal.querySelector('#productoNombre');
        productoNombre.textContent = nombre;

        var productoMarca = compraModal.querySelector('#productoMarca');
        productoMarca.textContent = marca;

        var productoDescripcion = compraModal.querySelector('#productoDescripcion');
        productoDescripcion.textContent = descripcion;

        var productoPrecio = compraModal.querySelector('#productoPrecio');
        productoPrecio.textContent = parseFloat(precio).toFixed(2);

        var productoStock = compraModal.querySelector('#productoStock');
        productoStock.textContent = stock;

        var productoCantidad = compraModal.querySelector('#productoCantidad');
        productoCantidad.setAttribute('max', stock);

        // Update hidden fields in the form
        var productoId = compraModal.querySelector('#productoId');
        productoId.value = id;

        var hiddenProductoPrecio = compraModal.querySelector('#hiddenProductoPrecio');
        hiddenProductoPrecio.value = parseFloat(precio).toFixed(2);

        var hiddenProductoNombre = compraModal.querySelector('#hiddenProductoNombre');
        hiddenProductoNombre.value = nombre;
    });
});
</script>