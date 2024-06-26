<section class="container mt-5 py-1" style="backdrop-filter: blur(10px); background-color: rgba(255, 255, 255, 0.2); border-radius: 10px;">
    <div class="d-flex justify-content-center my-2">
        <h2 class="mb-4 btn btn-lg btn-outline-success disabled bg-black">Gestion Ventas</h2>
    </div>

    <!-- Formulario de Búsqueda -->
    <div class="d-flex justify-content-center mb-2">
        <form class="d-flex justify-content-end col-2 mb-3" method="get" action="<?= base_url('gestion_ventas'); ?>">
            <input type="text" name="search" class="form-control form-control-sm me-2 bg-light border-success" placeholder="Buscar ventas" value="<?= isset($search) ? esc($search) : ''; ?>" />
            <button type="submit" class="btn btn-sm btn-outline-success">Buscar</button>
        </form>
        <a href="<?= base_url('gestion_ventas'); ?>"><button type="button" class="btn btn-sm btn-outline-dark">Borrar</button></a>
    </div>

    <table class="table table-success table-hover table-striped table-bordered align-middle text-center">
        <thead class="thead-dark">
            <tr>
                <th>ID Venta</th>
                <th>Usuario ID</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($ventas as $venta): ?>
                <tr>
                    <td><?php echo $venta['id_venta']; ?></td>
                    <td><?php echo $venta['usuario_id']; ?></td>
                    <td>$<?php echo number_format($venta['total_venta'], 2); ?></td>
                    <td><?php echo date('d/m/Y H:i:s', strtotime($venta['fecha'])); ?></td>
                    <td>
                        <a href="<?= base_url('ver_factura/' . $venta['id_venta']); ?>" class="btn btn-sm btn-outline-success">Ver Factura</a>
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
        <?= $pager->links('ventas', 'bootstrap5_full'); ?>
    </div>
</section>