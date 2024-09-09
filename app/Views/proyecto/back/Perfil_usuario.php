
<?php if (session()->getFlashdata('msj')): ?>
    <div class="container col-4 alert alert-success text-center fs-6 fade show" role="alert">
        <?= session()->getFlashdata('msj') ?>
    </div>
<?php endif;?>
    <div class="container" style="max-width: 600px; margin: auto; background-color: rgb(255, 255, 255, 0.5); padding: 20px; border-radius: 20px; border-color: aqua; backdrop-filter: blur(10px);">
        <h1 class="text-bg-dark rounded-3 text-center text-info">Perfil de Usuario</h1>

        
        <div class="input-group mb-1">
            <span class="input-group-text text-info bg-dark" style="text-shadow: none;" id="basic-addon3">Nombre:</span>
            <input name="usuario" type="text" class="form-control text-dark" disabled readonly value="<?php echo esc($usuario['nombre']); ?>">
        </div>
        <div class="input-group mb-1">
            <span class="input-group-text text-info bg-dark" style="text-shadow: none;" id="basic-addon3">Apellido:</span>
            <input name="usuario" type="text" class="form-control text-dark" disabled readonly value="<?php echo esc($usuario['apellido']); ?>">
        </div>
        <div class="input-group mb-1">
            <span class="input-group-text text-info bg-dark" style="text-shadow: none;" id="basic-addon3">Usuario:</span>
            <input name="usuario" type="text" class="form-control text-dark " disabled readonly value="<?php echo esc($usuario['usuario']); ?>">
        </div>
        <div class="input-group mb-1">
            <span class="input-group-text text-info bg-dark" style="text-shadow: none;" id="basic-addon3">Email:</span>
            <input name="usuario" type="text" class="form-control text-dark" disabled readonly value="<?php echo esc($usuario['email']); ?>">
        </div>
        <?php $id = $usuario['id_usuario']?>

        <div class="container text-center">
            <a href="<?php echo base_url('editar-usuario/' . base64_encode($id)); ?>" class="btn btn-sm btn-success">Editar Perfil</a>
            <a href="<?php echo base_url('/'); ?>" class="btn btn-sm btn-primary">Atras</a>
        </div>
    </div>
