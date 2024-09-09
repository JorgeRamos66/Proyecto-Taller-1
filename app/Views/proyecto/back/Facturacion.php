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
                <th>Nombre Usuario</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($ventas as $venta): ?>
                <tr>
                    <td><?php echo $venta['id_ventas_cabecera']; ?></td>
                    <td><?php echo $venta['usuario']; ?></td>
                    <td>$<?php echo number_format($venta['total_venta'], 2); ?></td>
                    <td><?php echo date('d/m/Y H:i:s', strtotime($venta['fecha'])); ?></td>
                    <td>
                        <a href="#" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#facturaModal" data-venta-id="<?= $venta['id_ventas_cabecera']; ?>">Ver Factura</a>
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
<!-- Bootstrap Modal -->
<div class="modal fade" id="facturaModal" tabindex="-1" aria-labelledby="facturaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="facturaModalLabel">Detalles de la Factura</h5>
            </div>
            <div class="modal-body" id="facturaModalBody">
                <!-- Los detalles de la factura se cargarán aquí -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const facturaModal = document.getElementById('facturaModal');
    const facturaModalBody = document.getElementById('facturaModalBody');

    facturaModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Botón que activó el modal
        const ventaId = button.getAttribute('data-venta-id'); // Extraer el ID de la venta

        // Hacer una solicitud AJAX para obtener los detalles de la factura
        fetch(`<?= base_url('obtener_detalle_venta/') ?>${ventaId}`)
            .then(response => response.json())
            .then(data => {
                // Construir el contenido del modal
                let content = '<table class="table table-bordered">';
                content += '<thead><tr><th>Nombre del Producto</th><th>Cantidad</th><th>Precio Unitario</th><th>Total</th></tr></thead>';
                content += '<tbody>';

                data.detalles.forEach(detalle => {
                    content += `<tr>
                        <td>${detalle.nombre_producto}</td>
                        <td>${detalle.cantidad}</td>
                        <td>$${detalle.precio_unitario}</td>
                        <td>$${detalle.total}</td>
                    </tr>`;
                });

                content += '</tbody></table>';
                facturaModalBody.innerHTML = content;
            })
            .catch(error => console.error('Error al cargar los detalles de la factura:', error));
    });
});
</script>