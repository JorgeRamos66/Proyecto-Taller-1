<?php if (session()->getFlashdata('exito')): ?>
            <div class="alert alert-success text-center fs-6">
                <?= session()->getFlashdata('exito') ?>
            </div>
        <?php endif;?>
<section class="container mt-5" style="backdrop-filter: blur(10px); background-color: rgb(255, 255, 255, 0.2);">
    <h2 class="mb-4" style=" text-align: center;">Productos</h2>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Categoria</th>
                <th>Precio</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?php echo $producto['nombre_producto']; ?></td>
                    <td><?php echo $producto['imagen_producto']; ?></td>
                    <td><?php echo $producto['id_categoria']; ?></td>
                    <td><?php echo $producto['precio_producto']; ?></td>
                    <td><?php echo $producto['stock_producto']; ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (!empty($productos)): ?>
                
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No hay productos disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

