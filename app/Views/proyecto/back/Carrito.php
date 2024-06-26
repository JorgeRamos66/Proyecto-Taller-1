<?php
$session = session();
$nombre = $session->get('nombre');
$perfil = $session->get('perfil_id');
$id = $session->get('id_usuario');
?>
<?php if (session()->getFlashdata('mensaje')): ?>
    <div class="container col-4 alert alert-success text-center fs-6 alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('mensaje') ?>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif;?>
<div class="comercializacion container mt-5" style="text-shadow: none; border-radius: 10px;background-color: rgb(255, 255, 255, 0)">
    <div style="text-align: center;">
        <h1 class="my-2 badge" style="text-shadow: none;color: blue;backdrop-filter: blur(10px); background-color: rgb(255, 255, 255, 0.2);">Carrito de Compras</h1>
    </div>
    
    <table class="table table-success table-hover table-striped table-bordered align-middle text-center">
        <thead class="thead-dark">
            <tr class="align-middle">
                <th>Nombre del producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Inicializa el total del carrito
            $total_carrito = 0; 
            ?>
            <?php foreach ($cart as $index => $item): ?>
                <?php 
                // Calcula el subtotal por producto
                $subtotal = $item['price'] * $item['qty']; 
                // Suma el subtotal al total del carrito
                $total_carrito += $subtotal; 
                ?>
                <tr>
                    <td><?= esc($item['name']); ?></td>
                    <td>$<?= number_format($item['price'], 2); ?></td>
                    <td>
                        <div class="btn-group">
                            <form action="<?= base_url('incrementar_producto/' . $index); ?>" method="post" class="d-inline">
                                <button type="submit" class="btn btn-sm btn-outline-dark">+</button>
                            </form>
                            <div class="btn btn-sm btn-dark">
                                <?= esc($item['qty']); ?>
                            </div>
                            
                            <form action="<?= base_url('decrementar_producto/' . $index); ?>" method="post" class="d-inline">
                                <button type="submit" class="btn btn-sm btn-outline-dark">-</button>
                            </form>
                        </div>
                        
                    </td>
                    <td>$<?= number_format($subtotal, 2); ?></td>
                    <td>
                        <form action="<?= base_url('quitar_producto/' . $index); ?>" method="post" class="d-inline">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($cart)): ?>
                <tr>
                    <td colspan="5" class="text-center">No hay productos en el carrito.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="row">
        <div class="col-12 text-right">
            <h4 style="text-align: center;"><h1 class="my-2 badge" style="color: black;backdrop-filter: blur(10px); background-color: rgb(255, 255, 255, 0.8);">Total: $<?= number_format($total_carrito, 2); ?></h4>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12 text-center">
            <form action="<?= base_url('registrar_venta'); ?>" method="post" class="d-inline">
                <button type="submit" class="btn btn-success">Confirmar Orden</button>
            </form>
            <form action="<?= base_url('vaciar_carrito'); ?>" method="post" class="d-inline">
                <button type="submit" class="btn btn-danger">Vaciar Carrito</button>
            </form>
            <a href="<?= base_url('catalogoDeProductos'); ?>" class="btn btn-primary">Seguir Comprando</a>
        </div>
    </div>
</div>