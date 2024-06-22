<?php if (session()->getFlashdata('agregado')): ?>
    <div class="alert alert-success text-center fs-6 alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('agregado') ?>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif;?>
<?php if (session()->getFlashdata('activado')): ?>
    <div class="alert alert-primary text-center fs-6 alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('activado') ?>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif;?>
<?php if (session()->getFlashdata('eliminado')): ?>
    <div class="alert alert-danger text-center fs-6 alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('eliminado') ?>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif;?>
<section class="container mt-5 py-1" style="backdrop-filter: blur(10px); background-color: rgb(255, 255, 255, 0.2);border-radius: 10px;">
    <div class="d-flex justify-content-center my-2 "><h2 class="mb-4 btn btn-lg btn-outline-success disabled bg-black" >Gestion Productos</h2></div>
    <div class="d-flex justify-content-center mb-2"><a href="<?php echo base_url('form-producto'); ?>"><button type="button" class="btn btn-sm btn-outline-primary">Agregar producto</button></a></div>
    
    <table class="table table-dark table-striped table-bordered align-middle text-center">
        <thead class="thead-dark">
            <tr>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Categoria</th>
                <th>Precio</th>
                <th>Marca</th>
                <th>Descripcion</th>
                <th>Stock</th>
                <th>Eliminado?</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>
                <tr class="<?= $producto['eliminado_producto'] == 'SI' ? 'table-danger' : '' ?>">
                    <?php $imagen = $producto['imagen_producto']; ?>
                    <?php $id = $producto['id_producto']; ?>

                    <td><?php echo $producto['nombre_producto']; ?></td>
                    <td>
                        <img height="70px" width="85px" src=" <?=base_url()?>assets/uploads/<?=$imagen?> " alt="">
                    </td>
                    <?php $cat = $producto['id_categoria'] -1 ?>
                    <td><?php echo $categorias[$cat]['descripcion_categoria'] ?></td>
                    <td>$<?php echo $producto['precio_producto']; ?></td>
                    <td><?php echo $producto['marca_producto']; ?></td>
                    <td><?php echo $producto['descripcion_producto']; ?></td>
                    <td>
                        <?php echo $producto['stock_producto']; ?>
                            <?php if ($producto['stock_producto'] == 1): ?>
                                unidad
                            <?php else: ?>
                                unidades
                        <?php endif; ?>
                    </td>
                    <td><?php echo $producto['eliminado_producto']; ?></td>
                    <td class="align-middle">
                        <div class="">
                            <div class="btn-group">
                                <?php if($producto['eliminado_producto'] == 'NO'): ?>
                                    <a href="<?php echo base_url('editar-producto/'.$id); ?>"><button type="button" class="btn btn-sm btn-outline-success">Editar</button></a>
                                    <a href="<?php echo base_url('eliminar-producto/'.$id); ?>"><button type="button" class="btn btn-sm btn-outline-danger">Borrar</button></a>
                                <?php else: ?>
                                    <a href="<?php echo base_url('editar-producto/'.$id); ?>"><button type="button" class="btn btn-sm btn-outline-success">Editar</button></a>
                                    <a href="<?php echo base_url('activar-producto/'.$id); ?>"><button type="button" class="btn btn-sm btn-outline-primary">Activar</button></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
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

