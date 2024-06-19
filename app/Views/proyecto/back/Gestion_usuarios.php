<?php if (session()->getFlashdata('exito')): ?>
            <div class="alert alert-success text-center fs-6">
                <?= session()->getFlashdata('exito') ?>
            </div>
        <?php endif;?>
<section class="container mt-5 py-1" style="backdrop-filter: blur(10px); background-color: rgb(255, 255, 255, 0.2);">
    <div class="d-flex justify-content-center my-2 "><h2 class="mb-4 btn btn-lg btn-outline-warning disabled bg-black" >Gestion Usuarios</h2></div>
    <table class="table table-striped table-bordered">
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
                <tr>
                    <?php $id = $usuario['id_usuario']; ?>
                    <td><?php echo $usuario['nombre']; ?></td>
                    <td><?php echo $usuario['apellido']; ?></td>
                    <td><?php echo $usuario['usuario']; ?></td>
                    <td><?php echo $usuario['email']; ?></td>
                    <td><?php echo $usuario['baja']; ?></td>
                    <td>
                        <div class="btn-group justify-content-center d-flex">
                            <?php if($usuario['baja'] == 'NO'): ?>
                                <a href="<?php echo base_url('editar', $id); ?>"><button type="button" class="btn btn-outline-success">Editar</button></a>
                                <a href="<?php echo base_url('borrar', $id); ?>"><button type="button" class="btn btn-outline-danger">Borrar</button></a>
                            <?php else: ?>
                                <a href="<?php echo base_url('editar', $id); ?>"><button type="button" class="btn btn-outline-success">Editar</button></a>
                                <a href="<?php echo base_url('borrar', $id); ?>"><button type="button" class="btn btn-outline-primary">Activar</button></a>
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