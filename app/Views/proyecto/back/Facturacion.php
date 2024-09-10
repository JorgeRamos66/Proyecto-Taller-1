
<section class="container mt-5 py-1" style="backdrop-filter: blur(10px); background-color: rgba(255, 255, 255, 0.2); border-radius: 10px;">
    <div class="d-flex justify-content-center my-2">
        <h2 class="mb-4 btn btn-lg btn-outline-warning disabled bg-black"><?= $titulo ?></h2>
    </div>

    <!-- Formulario de Búsqueda -->
    <div class="d-flex justify-content-center mb-2">
        <form class="bg-light p-1 rounded bg-opacity-50 d-flex justify-content-end col-3 mb-3" method="get" action="<?= base_url('facturacion'); ?>">
            <input type="text" name="search" class="form-control form-control-sm me-2 bg-light border-warning" placeholder="Buscar facturas" value="<?= isset($search) ? esc($search) : ''; ?>" />
            <button type="submit" class="btn btn-sm btn-outline-warning mx-1">Buscar</button>
            <a href="<?= base_url('facturacion'); ?>"><button type="button" class="btn btn-sm btn-outline-dark">Borrar</button></a>
        </form>
    </div>
    

    <table class="table table-light table-hover table-striped table-bordered align-middle text-center">
        <thead class="thead-dark">
            <tr>
                <th>ID Factura</th>
                <th>Nombre y Apellido</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($ventas as $venta): ?>
                <tr>
                    <td><?php echo $venta['id_ventas_cabecera']; ?></td>
                    <td><?php echo $venta['nombre'] . ' ' . $venta['apellido']; ?></td>
                    <td>$<?php echo number_format($venta['total_venta'], 2); ?></td>
                    <td><?php echo date('d/m/Y H:i:s', strtotime($venta['fecha'])); ?></td>
                    <td>
                        <a href="<?= base_url('generarFactura/' . $venta['id_ventas_cabecera']); ?>" class="btn btn-sm btn-outline-danger">Generar Factura</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($ventas)): ?>
                <tr>
                    <td colspan="5" class="text-center">No hay ventas disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
        <?= $pager->links('facturacion', 'bootstrap5_full'); ?>
    </div>
</section>