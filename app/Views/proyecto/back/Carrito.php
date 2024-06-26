<?php
$session = session();
$nombre = $session->get('nombre');
$perfil = $session->get('perfil_id');
$id = $session->get('id_usuario');
?>

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
                <th>Cancelar producto</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Inicializa el total del carrito
            $total_carrito = 0; 
            ?>
            <?php foreach ($carrito as $item): ?>
                <?php 
                // Calcula el subtotal por producto
                $subtotal = $item['price'] * $item['qty']; 
                // Suma el subtotal al total del carrito
                $total_carrito += $subtotal; 
                ?>
                <tr>
                    <td><?= esc($item['name']); ?></td>
                    <td>$<?= number_format($item['price'], 2); ?></td>
                    <td><?= esc($item['qty']); ?></td>
                    <td>$<?= number_format($subtotal, 2); ?></td>
                    <td>
                        <form action="<?= base_url('actualizar_carrito'); ?>" method="post" class="d-inline">
                            <input type="hidden" name="id" value="<?= esc($item['rowid']); ?>">
                            <input type="number" name="qty" value="<?= esc($item['qty']); ?>" min="1" class="form-control form-control-sm w-auto d-inline">
                            <button type="submit" class="btn btn-sm btn-outline-primary">Actualizar</button>
                        </form>
                        <form action="<?= base_url('elimina_carrito/' . esc($item['rowid'])); ?>" method="post" class="d-inline">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Borrar producto</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($carrito)): ?>
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
            <form action="<?= base_url('Ventas_controller/registrar_venta'); ?>" method="post" class="d-inline">
                <button type="submit" class="btn btn-success">Confirmar Orden</button>
            </form>
            <form action="<?= base_url('Carrito_controller/remover_del_carrito/all'); ?>" method="post" class="d-inline">
                <button type="submit" class="btn btn-danger">Borrar Carrito</button>
            </form>
            <a href="<?= base_url('catalogoDeProductos'); ?>" class="btn btn-primary">Seguir Comprando</a>
        </div>
    </div>
</div>