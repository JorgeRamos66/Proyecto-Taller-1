<section class="container mt-5 py-1" style="backdrop-filter: blur(10px); background-color: rgba(255, 255, 255, 0.2); border-radius: 10px;">
    <div class="d-flex justify-content-center my-2">
    <div class="d-flex justify-content-center my-2 "><h2 class="mb-4 btn btn-lg btn-outline-warning disabled bg-black" >Ventas</h2></div>
    </div>

    <!-- Formulario de Búsqueda y Filtrado por Rango de Fechas -->
    <div class="container mb-3 d-flex justify-content-center">
        <form class="bg-light p-1 rounded bg-opacity-50 row row-cols-2 text-center align-items-center" method="get" action="<?= base_url('ver_ventas'); ?>">
            <!-- Campo de Búsqueda -->
            <div class="col-auto">
                <input type="text" name="search" class="form-control form-control-sm border-warning" 
                    placeholder="Buscar ventas" value="<?= isset($search) ? esc($search) : ''; ?>" />
            </div>
            
            <!-- Botones de Buscar y Borrar -->
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-outline-warning text-white">Buscar</button>
            </div>
            

            <!-- Campo de Fecha Inicio -->
            <div class="col-auto">
                <label for="startDate" class="form-label mb-0">Fecha Inicio:</label>
                <input type="date" id="startDate" name="startDate" 
                    class="form-control form-control-sm border-warning" 
                    value="<?= isset($_GET['startDate']) ? esc($_GET['startDate']) : ''; ?>">
            </div>

            <!-- Campo de Fecha Fin -->
            <div class="col-auto">
                <label for="endDate" class="form-label mb-0">Fecha Fin:</label>
                <input type="date" id="endDate" name="endDate" 
                    class="form-control form-control-sm border-warning" 
                    value="<?= isset($_GET['endDate']) ? esc($_GET['endDate']) : ''; ?>">
            </div>

            <!-- Botón de Filtrar -->
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-outline-warning text-white">Filtrar</button>
            </div>

            <div class="col-auto">
                <a href="<?= base_url('ver_ventas'); ?>" class="btn btn-sm btn-outline-dark">Borrar</a>
            </div>
        </form>
    </div>

    <table class="table table-success table-hover table-striped table-bordered align-middle text-center">
        <thead class="thead-dark">
            <tr>
                <th>ID Venta</th>
                <th>Nombre Usuario</th>
                <th>Total</th>
                <th>Fecha
                </th>
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