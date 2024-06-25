
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
<section class="container mt-5 py-1" style="backdrop-filter: blur(10px); background-color: rgb(255, 255, 255, 0.2);border-radius: 10px;">
    <div class="d-flex justify-content-center my-2 "><h2 class="mb-4 btn btn-lg btn-outline-success disabled bg-black" >Gestion Productos</h2></div>
    <div class="d-flex justify-content-center mb-2"><a href="<?php echo base_url('form-producto'); ?>"><button type="button" class="btn btn-sm btn-outline-success bg-black">Agregar producto</button></a></div>
    
    <table class="table table-success table-hover table-striped table-bordered align-middle text-center">
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
                
                <tr class="<?= $producto['eliminado_producto'] == 'SI' ? 'table-dark' : '' ?>">
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
                    <td class="<?= $producto['stock_producto'] == 0 && $producto['eliminado_producto'] == 'NO' ? 'table-light' : '' ?>">
                        <?php if ($producto['stock_producto'] == 1): ?>
                            <?php echo $producto['stock_producto']; ?>
                            unidad
                        <?php elseif ($producto['stock_producto'] == 0): ?>
                            Sin stock!
                        <?php else: ?>
                            <?php echo $producto['stock_producto']; ?>
                            unidades
                        <?php endif; ?>
                    </td>
                    <td><?php echo $producto['eliminado_producto']; ?></td>
                    <td class="align-middle">
                        <div class="">
                            <div class="btn-group">
                                <?php if($producto['eliminado_producto'] == 'NO'): ?>
                                    <a href="<?php echo base_url('editar-producto/'.$id); ?>" class="btn btn-sm btn-outline-light">Editar</a>
                                    <a href="<?php echo base_url('eliminar-producto/'.$id); ?>" class="btn btn-sm btn-outline-dark">Borrar</a>
                                <?php else: ?>
                                    <a href="<?php echo base_url('editar-producto/'.$id); ?>" class="btn btn-sm btn-outline-light">Editar</a>
                                    <a href="<?php echo base_url('activar-producto/'.$id); ?>" class="btn btn-sm btn-outline-success">Activar</a>
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

