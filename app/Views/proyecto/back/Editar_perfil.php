<?php $validation = \Config\Services::validation(); ?>
<?php $id = $usuario['id_usuario']?>
<div class="container" style="max-width: 600px; margin: auto; background-color: rgb(255, 255, 255, 0.5); padding: 20px; border-radius: 20px; border-color: aqua; backdrop-filter: blur(10px);">
    <h1 class="text-bg-dark rounded-3 text-center text-info">Perfil de Usuario</h1>

    <form method="post" action="<?php echo base_url('actualizar-usuario/'.$id) ?>">
        <div class="input-group mb-1">
            <span class="input-group-text text-info bg-dark" style="text-shadow: none;" id="basic-addon3">Nombre:</span>
            <input name="nombre" type="text" class="form-control text-dark" value="<?php echo esc($usuario['nombre']); ?>">
            <?php if($validation->getError('nombre')) {?>
                <div class="py-1 alert alert-danger mt-0" style="color: red; text-shadow: none;">      
                  <?= $error = $validation->getError('nombre'); ?>
                </div>
            <?php }?>
        </div>
        <div class="input-group mb-1">
            <span class="input-group-text text-info bg-dark" style="text-shadow: none;" id="basic-addon3">Apellido:</span>
            <input name="apellido" type="text" class="form-control text-dark" value="<?php echo esc($usuario['apellido']); ?>">
            <?php if($validation->getError('apellido')) {?>
                <div class="py-1 alert alert-danger mt-0" style="color: red; text-shadow: none;">      
                  <?= $error = $validation->getError('apellido'); ?>
                </div>
            <?php }?>
        </div>
        <div class="input-group mb-1">
            <span class="input-group-text text-info bg-dark" style="text-shadow: none;" id="basic-addon3">Usuario:</span>
            <input name="usuario" type="text" class="form-control text-dark " value="<?php echo esc($usuario['usuario']); ?>">
            <?php if($validation->getError('usuario')) {?>
                <div class="py-1 alert alert-danger mt-0" style="color: red; text-shadow: none;">      
                  <?= $error = $validation->getError('usuario'); ?>
                </div>
            <?php }?>
        </div>
        <div class="input-group mb-1">
            <span class="input-group-text text-info bg-dark" style="text-shadow: none;" id="basic-addon3">Email:</span>
            <input name="email" type="text" class="form-control text-dark" value="<?php echo esc($usuario['email']); ?>">
            <?php if($validation->getError('email')) {?>
                <div class="py-1 alert alert-danger mt-0" style="color: red; text-shadow: none;">      
                  <?= $error = $validation->getError('email'); ?>
                </div>
            <?php }?>
        </div>
        
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="changePasswordCheckbox" name="pass-checkbox" onclick="togglePasswordFields()">
            <label class="form-check-label badge text-danger" for="changePasswordCheckbox">
                Cambiar contraseña
            </label>
        </div>

        <!-- Password Fields -->
        <div id="passwordFields" style="display: none;">
            <div class="input-group input-group-sm mb-0 mt-3">
                <span class="input-group-text text-info bg-dark" style="text-shadow: none;" id="basic-addon3">Contraseña anterior:</span>
                <input name="pass_old" type="password" class="form-control text-dark">
                <?php if ($validation->getError('pass_old')) { ?>
                    <div class="py-1 alert alert-danger mt-0" style="color: red; text-shadow: none;">
                        <?= $validation->getError('pass_old'); ?>
                    </div>
                <?php } ?>
            </div>
            <div class="input-group input-group-sm mb-0">
                <span class="input-group-text text-info bg-dark" style="text-shadow: none;" id="basic-addon3">Contraseña nueva:</span>
                <input name="pass" type="password" class="form-control text-dark">
                <?php if ($validation->getError('pass')) { ?>
                    <div class="py-1 alert alert-danger mt-0" style="color: red; text-shadow: none;">
                        <?= $validation->getError('pass'); ?>
                    </div>
                <?php } ?>
            </div>
            <div class="input-group input-group-sm mb-0">
                <span class="input-group-text text-info bg-dark" style="text-shadow: none;" id="basic-addon3">Repetir contraseña:</span>
                <input name="re_pass" type="password" class="form-control text-dark">
                <?php if ($validation->getError('re_pass')) { ?>
                    <div class="py-1 alert alert-danger mt-0" style="color: red; text-shadow: none;">
                        <?= $validation->getError('re_pass'); ?>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="container text-center">
            <button type="submit" class="btn btn-sm btn-success">Guardar Cambios</button>
            <a href="<?php echo base_url('perfil-usuario/'.$id); ?>" class="btn btn-sm btn-primary">Cancelar</a>
        </div>
    </form>
</div>

<script>
    function togglePasswordFields() {
        var checkbox = document.getElementById('changePasswordCheckbox');
        var passwordFields = document.getElementById('passwordFields');
        if (checkbox.checked) {
            passwordFields.style.display = 'block';
        } else {
            passwordFields.style.display = 'none';
        }
    }
</script>


