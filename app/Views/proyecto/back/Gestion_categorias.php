<?php if (session()->getFlashdata('agregado')): ?>
    <div class="container col-4 alert alert-success text-center fs-6 alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('agregado') ?>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('activado')): ?>
    <div class="container col-4 alert alert-success text-center fs-6 alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('activado') ?>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('eliminado')): ?>
    <div class="container col-4 alert alert-dark text-center fs-6 alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('eliminado') ?>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<section class="container mt-5 py-1" style="backdrop-filter: blur(10px); background-color: rgba(255, 255, 255, 0.2); border-radius: 10px;">
    <div class="d-flex justify-content-center my-2">
        <h2 class="mb-4 btn btn-lg btn-outline-success disabled bg-black">ABM Categoria</h2>
    </div>

    <!-- Formulario de Búsqueda -->
    <div class="d-flex justify-content-center mb-2">
        <form class="d-flex justify-content-end col-2 mb-3" method="get" action="<?= base_url('gestion_categorias'); ?>">
            <input type="text" name="search" class="form-control form-control-sm me-2 bg-light border-success" placeholder="Buscar categoría" value="<?= isset($search) ? esc($search) : ''; ?>" />
            <button type="submit" class="btn btn-sm btn-outline-success">Buscar</button>
        </form>
        <a href="<?= base_url('gestion_categorias'); ?>"><button type="button" class="btn btn-sm btn-outline-dark">Borrar</button></a>
    </div>

    <table class="table table-success table-hover table-striped table-bordered align-middle text-center">
        <thead class="thead-dark">
            <tr class="align-middle">
                <th>Nombre</th>
                <th>Activo</th>
                <th class="text-center">
                    <a href="<?= base_url('form-categoria'); ?>">
                        <button type="button" class="btn btn-sm btn-outline-success">Agregar categoría</button>
                    </a>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($categorias)): ?>
                <?php foreach ($categorias as $categoria): ?>
                    <tr class="<?= $categoria['activo_categoria'] == 0 ? 'table-dark' : '' ?>">
                        <td><?= esc($categoria['descripcion_categoria']); ?></td>
                        <td><?= $categoria['activo_categoria'] == 1 ? 'Sí' : 'No'; ?></td>
                        <td class="align-middle">
                        <div class="btn-group">
                            <?php if ($categoria['activo_categoria'] == 1): ?>
                                <a href="<?= base_url('editar-categoria/' . $categoria['id_categoria']); ?>" class="btn btn-sm btn-outline-light">Editar</a>
                                <a href="<?= base_url('eliminar-categoria/' . $categoria['id_categoria']); ?>" class="btn btn-sm btn-outline-dark">Eliminar</a>
                            <?php else: ?>
                                <a href="<?= base_url('editar-categoria/' . $categoria['id_categoria']); ?>" class="btn btn-sm btn-outline-light">Editar</a>
                                <a href="<?= base_url('activar-categoria/' . $categoria['id_categoria']); ?>" class="btn btn-sm btn-outline-success">Activar</a>
                            <?php endif; ?>
                        </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">No hay categorías disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Paginación -->
    <div class="d-flex justify-content-center mt-3">
        <?= $pager->links('categorias', 'bootstrap5_full'); ?>
    </div>
</section>