<section class="container mt-5 py-1" style="backdrop-filter: blur(10px); background-color: rgba(255, 255, 255, 0.2); border-radius: 10px;">
    <div class="d-flex justify-content-center my-2">
        <h2 class="mb-4 btn btn-lg btn-outline-success disabled bg-black">Gestion Consultas</h2>
    </div>
    <div class="btn-group container d-flex justify-content-center align-items-center col-2">
        <input type="radio" class="btn-check btn-sm" name="options-outlined" id="success-outlined" autocomplete="off" checked>
        <label class="btn btn-outline-dark btn-sm" for="success-outlined">Todos</label>

        <input type="radio" class="btn-check btn-sm" name="options-outlined" id="danger-outlined" autocomplete="off">
        <label class="btn btn-outline-dark btn-sm" for="danger-outlined">No leidos</label>

        <input type="radio" class="btn-check btn-sm" name="options-outlined" id="dark-outlined" autocomplete="off">
        <label class="btn btn-outline-dark btn-sm" for="dark-outlined">Leidos</label>
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
                            <form action="<?= base_url('leer-consulta/'.$id); ?>" method="post">
                                <button type="submit" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#consultaModal">
                                    Leer
                                </button>
                                <!-- Hidden input to pass message if needed --> 
                                <input type="hidden" name="consulta_mensaje" value="<?= htmlspecialchars($consulta['consulta_mensaje']); ?>">
                            </form>
                        </div>
                    </td>
                    <td><?php echo $consulta['consulta_registrado']; ?></td>
                    <td><?php echo $consulta['consulta_leido']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<!-- Bootstrap Modal -->
<div class="modal fade" id="consultaModal" tabindex="-1" aria-labelledby="consultaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="consultaModalLabel">Mensaje de Consulta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="consultaModalBody">
                <!-- Message will be loaded here dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const consultaModal = document.getElementById('consultaModal');
    const consultaModalBody = document.getElementById('consultaModalBody');

    consultaModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const message = button.getAttribute('data-message'); // Extract info from data-* attributes
        consultaModalBody.textContent = message; // Update the modal's content
    });

    const radioButtons = document.querySelectorAll('input[name="options-outlined"]');
    const tableRows = document.querySelectorAll('tbody tr');

    function filterRows() {
        const selectedOption = document.querySelector('input[name="options-outlined"]:checked').id;
        tableRows.forEach(row => {
            if (selectedOption === 'success-outlined') { // Show all
                row.style.display = '';
            } else if (selectedOption === 'danger-outlined' && row.getAttribute('data-leido') === 'NO') { // Show only unread
                row.style.display = '';
            } else if (selectedOption === 'dark-outlined' && row.getAttribute('data-leido') === 'SI') { // Show only read
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    radioButtons.forEach(radio => {
        radio.addEventListener('change', filterRows);
    });

    // Initial filter
    filterRows();
});
</script>