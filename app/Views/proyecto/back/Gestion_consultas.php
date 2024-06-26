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
                <tr class="<?= $consulta['consulta_leido'] == 'SI' ? 'table-dark' : '' ?>" data-leido="<?= $consulta['consulta_leido']; ?>">
                    <?php $id = $consulta['id_consulta']; ?>
                    <td><?php echo $consulta['consulta_nombre']; ?></td>
                    <td><?php echo $consulta['consulta_apellido']; ?></td>
                    <td><?php echo $consulta['consulta_email']; ?></td>
                    <td>
                        <div class="btn-group">
                            <!-- Updated 'Leer' button to include 'data-id' -->
                            <a href="#" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#consultaModal"
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
    // Función para configurar el modal y sus eventos
    function setupModal() {
        const consultaModal = document.getElementById('consultaModal');
        const consultaModalBody = document.getElementById('consultaModalBody');
        const markAsReadForm = document.getElementById('markAsReadForm');
        const consultaIdInput = document.getElementById('consultaIdInput');

        // Inicialización del modal con opciones para evitar el cierre al hacer clic fuera o al presionar Esc
        const bootstrapModal = new bootstrap.Modal(consultaModal, {
            backdrop: 'static',
            keyboard: false
        });

        // Evento al mostrar el modal
        consultaModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Botón que activó el modal
            const message = button.getAttribute('data-message'); // Extraer información de los atributos data-*
            const id = button.getAttribute('data-id'); // Extraer el ID desde los atributos data-*

            // Actualizar el contenido del modal
            consultaModalBody.textContent = message; 
            // Establecer la acción del formulario dinámicamente
            markAsReadForm.action = `<?= base_url('leer-consulta/'); ?>${id}`;
            // Establecer el ID de la consulta en el input oculto
            consultaIdInput.value = id;
        });

        // Evento al cerrar el modal solo cuando se hace clic en "Cerrar"
        consultaModal.querySelector('.btn-close, .btn-secondary').addEventListener('click', function () {
            bootstrapModal.hide();
        });
    }

    // Llamar a setupModal al cargar y cada vez que se cambie de página
    setupModal();

    const radioButtons = document.querySelectorAll('input[name="options-outlined"]');
    const tableRows = document.querySelectorAll('tbody tr');

    function filterRows() {
        const selectedOption = document.querySelector('input[name="options-outlined"]:checked').id;
        tableRows.forEach(row => {
            if (selectedOption === 'success-outlined') { // Mostrar todos
                row.style.display = '';
            } else if (selectedOption === 'danger-outlined' && row.getAttribute('data-leido') === 'NO') { // Mostrar solo no leídos
                row.style.display = '';
            } else if (selectedOption === 'dark-outlined' && row.getAttribute('data-leido') === 'SI') { // Mostrar solo leídos
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    radioButtons.forEach(radio => {
        radio.addEventListener('change', filterRows);
    });

    // Filtro inicial
    filterRows();

    // Manejar la paginación
    const paginationLinks = document.querySelectorAll('.pagination a.page-link');

    paginationLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            const url = this.getAttribute('href');

            // Cargar la nueva página usando fetch o similar
            fetch(url)
                .then(response => response.text())
                .then(data => {
                    // Reemplazar el contenido de la sección de consultas
                    const parser = new DOMParser();
                    const newDocument = parser.parseFromString(data, 'text/html');
                    const newSection = newDocument.querySelector('section.container');

                    // Reemplazar la sección existente con la nueva
                    const oldSection = document.querySelector('section.container');
                    oldSection.parentNode.replaceChild(newSection, oldSection);

                    // Volver a configurar el modal después de cargar la nueva sección
                    setupModal();
                })
                .catch(error => console.error('Error al cargar la página:', error));
        });
    });
});
</script>