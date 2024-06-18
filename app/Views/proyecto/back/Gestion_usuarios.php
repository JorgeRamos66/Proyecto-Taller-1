<?php if (session()->getFlashdata('exito')): ?>
            <div class="alert alert-success text-center fs-6">
                <?= session()->getFlashdata('exito') ?>
            </div>
        <?php endif;?>
<section class="container mt-5" style="backdrop-filter: blur(10px); background-color: rgb(255, 255, 255, 0.2);">
    <h2 class="mb-4" style=" text-align: center;">Gestion Usuarios</h2>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Baja</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo $usuario['nombre']; ?></td>
                    <td><?php echo $usuario['apellido']; ?></td>
                    <td><?php echo $usuario['usuario']; ?></td>
                    <td><?php echo $usuario['email']; ?></td>
                    <td><?php echo $usuario['baja']; ?></td>
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