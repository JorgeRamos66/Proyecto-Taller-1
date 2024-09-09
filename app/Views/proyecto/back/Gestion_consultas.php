<section class="container mt-5 py-1" style="backdrop-filter: blur(10px); background-color: rgba(255, 255, 255, 0.2); border-radius: 10px;">
    <div class="d-flex justify-content-center my-2">
        <h2 class="mb-4 btn btn-lg btn-outline-success disabled bg-black">Gestion Consultas</h2>
    </div>

    <!-- Formulario de Búsqueda -->
    <div class="d-flex justify-content-center mb-2">
        <form class="d-flex justify-content-end col-2 mb-3" method="get" action="<?= base_url('gestion_consultas'); ?>">
            <input type="text" name="search" class="form-control form-control-sm me-2 bg-light border-success" placeholder="Buscar consulta" value="<?= isset($search) ? esc($search) : ''; ?>" />
            <button type="submit" class="btn btn-sm btn-outline-success">Buscar</button>
        </form>
        <a href="<?= base_url('gestion_consultas'); ?>"><button type="button" class="btn btn-sm btn-outline-dark">Borrar</button></a>
    </div>

    <table class="table table-success table-hover table-striped table-bordered align-middle text-center">
        <thead class="thead-dark">
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Consulta</th>
                <th>Registrado?</th>
                <th>Leido?</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($consultas as $consulta): ?>
                <tr class="<?= $consulta['consulta_leido'] == 'SI' ? 'table-light' : 'table-success' ?>" data-leido="<?= $consulta['consulta_leido']; ?>">
                    <?php $id = $consulta['id_consulta']; ?>
                    <td><?php echo $consulta['consulta_nombre']; ?></td>
                    <td><?php echo $consulta['consulta_apellido']; ?></td>
                    <td><?php echo $consulta['consulta_email']; ?></td>
                    <td>
                        <div class="btn-group">
                            <!-- Updated 'Leer' button to include 'data-id' -->
                            <a href="#" class="btn btn-sm <?= $consulta['consulta_leido'] == 'SI' ? 'btn-outline-success' : 'btn-outline-light' ?>" data-bs-toggle="modal" data-bs-target="#consultaModal"
                             data-message="<?php echo htmlspecialchars($consulta['consulta_mensaje']); ?>" data-id="<?= $id; ?>"><?= $consulta['consulta_leido'] == 'NO' ? 'Leer' : 'Des-Leer' ?></a>
                        </div>
                    </td>
                    <td><?php echo $consulta['consulta_registrado']; ?></td>
                    <td><?php echo $consulta['consulta_leido']; ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($consultas)): ?>
                <tr>
                    <td colspan="6" class="text-center">No hay consultas disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
        <?= $pager->links('consultas', 'bootstrap5_full'); ?>
    </div>
</section>

<!-- Bootstrap Modal -->
<div class="modal fade" id="consultaModal" tabindex="-1" aria-labelledby="consultaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="consultaModalLabel">Mensaje de Consulta</h5>
            </div>
            <div class="modal-body" id="consultaModalBody">
                <!-- Message will be loaded here dynamically -->
            </div>
            <div class="modal-footer">
                <!-- Form to mark the consultation as read -->
                <form id="markAsReadForm" action="" method="post">
                    <!-- Hidden input for the consultation ID -->
                    <input type="hidden" name="consulta_id" id="consultaIdInput" value="">
                    <!-- Submit button to mark as read and close the modal -->
                    <button type="submit" class="btn btn-secondary">Cerrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    function setupModal() {
        const consultaModal = document.getElementById('consultaModal');
        const consultaModalBody = document.getElementById('consultaModalBody');
        const markAsReadForm = document.getElementById('markAsReadForm');
        const consultaIdInput = document.getElementById('consultaIdInput');

        consultaModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Botón que activó el modal
            const message = button.getAttribute('data-message');
            const id = button.getAttribute('data-id');

            consultaModalBody.textContent = message;
            markAsReadForm.action = `<?= base_url('leer-consulta/'); ?>${id}`;
            consultaIdInput.value = id;
        });
    }

    setupModal();

    function attachPaginationEvents() {
        const paginationLinks = document.querySelectorAll('.pagination a.page-link');

        paginationLinks.forEach(link => {
            link.addEventListener('click', function (event) {
                event.preventDefault();
                const url = this.getAttribute('href');

                fetch(url)
                    .then(response => response.text())
                    .then(data => {
                        const parser = new DOMParser();
                        const newDocument = parser.parseFromString(data, 'text/html');
                        const newSection = newDocument.querySelector('section.container');
                        const oldSection = document.querySelector('section.container');
                        oldSection.parentNode.replaceChild(newSection, oldSection);
                        
                        // Reaplicar configuraciones después de la carga
                        setupModal();
                        attachPaginationEvents(); // Reasociar eventos de paginación
                    })
                    .catch(error => console.error('Error al cargar la página:', error));
            });
        });
    }

    attachPaginationEvents();
});
</script>