<?php $validation = \Config\Services::validation(); ?>
<div class="container mt-5 mb-5 d-flex justify-content-center">
  <div class="card login" style="border-color: red; color: white; text-shadow: 1px 1px 2px black; backdrop-filter: blur(10px); background-color: rgb(255, 255, 255, 0.5);">
    <div class="card-header text-center">
      <h2 style="color: blue;">Iniciar sesión</h2>
    </div>
    <!-- Mensaje de Error -->
    
    <?php if (session()->getFlashdata('msg')): ?>
      <div class="container col-auto alert alert-danger text-center fs-6 alert-dismissible fade show text-black" style="text-shadow: none;" role="alert">
          <?= session()->getFlashdata('msg') ?>
          <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif;?>

    <!-- Inicio del formulario de login-->              
    <form method="post" action="<?php echo base_url('enviarlogin') ?>">
      <div class="card-body" media="(max-width:768px)">
        <div class="mb-3">
          <div class="input-group">
            <span class="input-group-text text-primary" style="text-shadow: none;" id="basic-addon3">Usuario</span>
            <input name="usuario" type="text" class="form-control" value="<?= set_value('usuario') ?>">
          </div>
          <!-- Error -->
          <?php if($validation->getError('usuario')):?>
            <div class="py-1 alert alert-danger my-0" style="color: red; text-shadow: none;">
              <?= $validation->getError('usuario'); ?>
            </div>
          <?php endif;?>
          <div id="nameHelp" class="form-text fw-medium text mt-0 mb-2">Ingrese su nombre de usuario.</div>
        </div>

        <div class="mb-3">
          <div class="input-group">
            <span class="input-group-text text-primary" style="text-shadow: none;" id="basic-addon3">Contraseña</span>
            <input name="pass" type="password" class="form-control">
          </div>
          <!-- Error -->
          <?php if($validation->getError('pass')):?>
            <div class="py-1 alert alert-danger my-0" style="color: red; text-shadow: none;">
              <?= $validation->getError('pass'); ?>
            </div>
          <?php endif;?>
          <div id="nameHelp" class="form-text fw-medium text mt-0 mb-2">Respete mayúsculas y minúsculas.</div>
        </div>
        
        <div class="container text-center">
          <input type="submit" value="Ingresar" class="btn btn-success">
          <a href="<?php echo base_url('/'); ?>" class="btn btn-danger">Cancelar</a>
          <script>
            function borrarCampos() {
              document.querySelector('input[name="usuario"]').value = '';
              document.querySelector('input[name="pass"]').value = '';
              document.querySelectorAll('.alert-danger').forEach(alert => alert.remove());
            }
          </script>
          <input type="button" value="Borrar" class="btn btn-secondary" onclick="borrarCampos()">
          <br>
        </div>
        <div class="container text-center" style="text-shadow: none;">
          <span>¿Aún no se registró? <a href="<?php echo base_url('form-registro'); ?>">Registrarse aquí</a></span>
        </div>
      </div>
    </form>
  </div>
</div>