<?php if (session()->getFlashdata('activado')): ?>
    <div class="container col-4 alert alert-warning text-center fs-6 alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('activado') ?>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif;?>
<?php if (session()->getFlashdata('eliminado')): ?>
    <div class="container col-4 alert alert-dark text-center fs-6 alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('eliminado') ?>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif;?>
<section class="container mt-5 py-1" style="backdrop-filter: blur(10px); background-color: rgb(255, 255, 255, 0.2);">
    <div class="d-flex justify-content-center my-2 "><h2 class="mb-4 btn btn-lg btn-outline-warning disabled bg-black" >Gestion Usuarios</h2></div>
    <table class="table table-warning table-hover table-striped table-bordered align-middle text-center">
        <thead class="thead-dark">
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Baja</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr class="<?= $usuario['baja'] == 'SI' ? 'table-dark' : '' ?> <?= $usuario['perfil_id'] == 1 ? 'table-info' : '' ?>">
                    <?php $id = $usuario['id_usuario']; ?>
                    <td><?php echo $usuario['nombre']; ?></td>
                    <td><?php echo $usuario['apellido']; ?></td>
                    <td><?php echo $usuario['usuario']; ?></td>
                    <td><?php echo $usuario['email']; ?></td>
                    <td><?php echo $usuario['baja']; ?></td>
                    <td>
                        <div class="btn-group justify-content-center d-flex">
                            <?php if($usuario['perfil_id'] == 1): ?>
                                <a href="<?php echo base_url('editar-usuario/'.$id); ?>" class="btn btn-sm btn-outline-success disabled">Borrar</a>
                            <?php elseif($usuario['baja'] == 'NO'): ?>
                                <a href="<?php echo base_url('eliminar-usuario/'. $id); ?>" class="btn btn-sm btn-outline-dark">Borrar</a>
                                
                            <?php else: ?>
                                <a href="<?php echo base_url('activar-usuario/'. $id); ?>" class="btn btn-sm btn-outline-warning">Activar</a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (!empty($usuarios)): ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No hay usuarios registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>