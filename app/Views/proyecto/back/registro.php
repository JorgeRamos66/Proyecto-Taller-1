 <div class="container mt-2 mb-5 d-flex justify-content-center">
  <div class="card registro" style="border-color: blue; color: white ;text-shadow: 1px 1px 2px black; ;backdrop-filter: blur(10px); background-color: rgb(255, 255, 255, 0.5);">
    <div class="card-header text-center">
      <h2 style="color: red;">Registrarse</h2>
    </div>
		  
    <?php $validation = \Config\Services::validation(); ?>
   
    <form method="post" action="<?php echo base_url('enviar-registro') ?>">
     	<?php if(!empty (session()->getFlashdata('fail'))):?>
     	<div class="alert alert-danger"><?=session()->getFlashdata('fail');?></div>
        <?php endif?>
           <?php if(!empty (session()->getFlashdata('success'))):?>
     	    <div class="alert alert-danger"><?=session()->getFlashdata('success');?></div>
          <?php endif?>    	
      <div class ="card-body justify-content-center" media="(max-width:768px)">
        <div class="form-floating">
          <input name="nombre" type="text"  class="form-control" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?>" placeholder="Ingrese su nombre" >
          <label style="color: blue;" for="nombre_usuario" class="form-label">Nombre</label>
          <div id="nameHelp" class="form-text fw-medium text mt-0 mb-2">Entre 3 y 25 letras.</div>
            <!-- Error -->
                <?php if($validation->getError('nombre')) {?>
                    <div class="py-1 alert alert-danger mt-2" style="color: red; text-shadow: none;">      
                      <?= $error = $validation->getError('nombre'); ?>
                    </div>
                <?php }?>
        </div>
        <div class="mb-3 form-floating">
          <input type="text" name="apellido" class="form-control"value="<?php echo isset($_POST['apellido']) ? $_POST['apellido'] : ''; ?>" placeholder="Ingrese su apellido">
          <label style="color: blue;" for="exampleFormControlTextarea1" class="form-label">Apellido</label>
          <div id="nameHelp" class="form-text fw-medium text mt-0 mb-2">Entre 3 y 25 letras.</div>
          <!-- Error -->
              <?php if($validation->getError('apellido')) {?>
                  <div class='py-1 alert alert-danger  mt-2' style="color: red; text-shadow: none;">
                    <?= $error = $validation->getError('apellido'); ?>
                  </div>
              <?php }?>
        </div>
          <div class="mb-3 form-floating">
            <input name="email"  type="email" class="form-control" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" placeholder="Correo@algo.com">
            <label style="color: blue;" for="exampleFormControlInput1" class="form-label">Email</label>
            <div id="nameHelp" class="form-text fw-medium text mt-0 mb-2">Entre 4 y 100 letras.</div>
            <!-- Error -->
            <?php if($validation->getError('email')) {?>
                <div class='py-1 alert alert-danger mt-2' style="color: red; text-shadow: none;">
                  <?= $error = $validation->getError('email'); ?>
                </div>
            <?php }?>
        </div>
        <div class="mb-3 form-floating">
          <input  type="text" name="usuario" class="form-control" value="<?php echo isset($_POST['usuario']) ? $_POST['usuario'] : ''; ?>" placeholder="Ingrese un nombre de usuario">
          <label style="color: blue;" for="exampleFormControlInput1" class="form-label">Usuario</label>
          <div id="nameHelp" class="form-text fw-medium text mt-0 mb-2">Entre 3 y 25 letras.</div>
          <!-- Error -->
          <?php if($validation->getError('usuario')) {?>
              <div class='py-1 alert alert-danger mt-2' style="color: red; text-shadow: none;">
                <?= $error = $validation->getError('usuario'); ?>
              </div>
          <?php }?>
        </div>
        
        <div class="mb-3 form-floating">
          <input name="pass" type="password" class="form-control" value="<?php echo isset($_POST['pass']) ? $_POST['pass'] : ''; ?>" placeholder="Contraseña">
          <label style="color: blue;" for="exampleFormControlInput1" class="form-label">Contraseña</label>
          <div id="nameHelp" class="form-text fw-medium text mt-0 mb-2">Entre 3 y 10 letras.</div>
          <!-- Error -->
          <?php if($validation->getError('pass')) {?>
              <div class='py-1 alert alert-danger mt-2' style="color: red; text-shadow: none;">
                <?= $error = $validation->getError('pass'); ?>
              </div>
          <?php }?>
        </div>
        <div class="mb-3 form-floating">
          <input name="re_pass" type="password" class="form-control" value="<?php echo isset($_POST['re_pass']) ? $_POST['re_pass'] : ''; ?>" placeholder="Repita la contraseña">
          <label style="color: blue;" for="exampleFormControlInput1" class="form-label">Repetir contraseña</label>
          <div id="nameHelp" class="form-text fw-medium text mt-0 mb-2">Entre 3 y 10 letras.</div>
          <!-- Error -->
          <?php if($validation->getError('re_pass')) {?>
              <div class='py-1 alert alert-danger mt-2' style="color: red; text-shadow: none;">
                <?= $error = $validation->getError('re_pass'); ?>
              </div>
          <?php }?>
        </div>
            <div class="container text-center">
              <input type="submit" value="Guardar" class="btn btn-success">
              <a href="<?php echo base_url('/'); ?>" class="btn btn-danger">Cancelar</a>
              <input type="reset" value="Borrar" class="btn btn-secondary" onclick="borrarTextArea()">
            </div>
            <div class="container text-center my-2" style="text-shadow: none;">
              <span>¿Ya tiene cuenta? <a href="<?php echo base_url('login'); ?>">Iniciar sesion aquí</a></span>
            </div>
          </div>
    </form>
  </div>
</div>