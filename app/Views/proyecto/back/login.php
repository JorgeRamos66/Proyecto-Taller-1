
<div class="container mt-5 mb-5 d-flex justify-content-center">

  <div class="card login" style="border-color: red; color: white ;text-shadow: 1px 1px 2px black; backdrop-filter: blur(10px); background-color: rgb(255, 255, 255, 0.5);">
    <div class="card-header text-center">
      <h2 style="color: blue;">Iniciar sesion</h2>
    </div>
     <!-- Mensaje de Error -->
        <?php if(session()->getFlashdata('msg')):?>
                    <div class="alert alert-danger alert-dismissible fade show" style="color: blue; text-shadow: none;" role="alert">
                          <?= session()->getFlashdata('msg')?>
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
         <?php endif;?>
      <!-- Incio del formulario de login-->              
    <form method="post" action="<?php echo base_url('enviarlogin') ?>">
      <div class="card-body" media="(max-width:768px)">
        <div class="col-12 mb-2 form-floating">
          <input name="usuario" type="text" class="form-control" id="floatingUser" placeholder="Ingrese su nombre de usuario" >
          <label for="floatingUser">Usuario</label>
          <div id="nameHelp" class="form-text fw-medium text mt-0 mb-2">Ingrese su nombre de usuario.</div>
         </div>
        
        <div class="col-12 mb-2 form-floating">
          <input name="pass" type="password"  class="form-control" id="floatingPass" placeholder="Ingrese su contraseña">
          <label for="floatingPass">Contraseña</label>
          <div id="nameHelp" class="form-text fw-medium text mt-0 mb-2">Respete mayusculas y minusculas</div>
          
        </div>
        
        

        <div class="container text-center">
          <input type="submit" value="Ingresar" class="btn btn-success">
          <a href="<?php echo base_url('/'); ?>" class="btn btn-danger">Cancelar</a>
          <input type="reset" value="Borrar" class="btn btn-secondary" onclick="borrarTextArea()">
          <br>
        </div>
          <div class="container text-center" style="text-shadow: none;">
            <span>¿Aún no se registró? <a href="<?php echo base_url('registro'); ?>">Registrarse aquí</a></span>
          </div>
      </div>
    </form>
  </div>
</div>

