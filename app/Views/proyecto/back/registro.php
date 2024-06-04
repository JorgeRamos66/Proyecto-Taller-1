 <div class="container mt-2 mb-5 d-flex justify-content-center">
  <div class="card registro" style="border-color: blue; color: white ;text-shadow: 1px 1px 2px black; ;backdrop-filter: blur(10px); background-color: rgb(255, 255, 255, 0.2);">
    <div class="card-header text-center">
      <h2 style="color: red;">Registrarse</h2>
    </div>
		  
 <?php $validation = \Config\Services::validation(); ?>
   
   <form method="post" action="<?php echo base_url('enviar-form') ?>">
     	<?php if(!empty (session()->getFlashdata('fail'))):?>
     	<div class="alert alert-danger"><?=session()->getFlashdata('fail');?></div>
        <?php endif?>
           <?php if(!empty (session()->getFlashdata('success'))):?>
     	    <div class="alert alert-danger"><?=session()->getFlashdata('success');?></div>
          <?php endif?>    	
<div class ="card-body justify-content-center" media="(max-width:768px)">
	<div class="form">
 	 <label for="nombre_usuario" class="form-label">Nombre</label>
 	 <input name="nombre" type="text"  class="form-control" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?>" placeholder="Ingrese su nombre" >
   <div id="nameHelp" class="form-text fw-medium text mt-0 mb-2">Entre 3 y 25 letras.</div>
     <!-- Error -->
        <?php if($validation->getError('nombre')) {?>
            <div class='py-1 alert alert-danger mt-2' style="color: red; text-shadow: none;">
            El campo nombre es requerido.             
              <?= $error = $validation->getError(''); ?>
            </div>
        <?php }?>
	</div>
	<div class="mb-3">
 	 <label for="exampleFormControlTextarea1" class="form-label">Apellido</label>
 	  <input style="color: blue;" type="text" name="apellido" class="form-control"value="<?php echo isset($_POST['apellido']) ? $_POST['apellido'] : ''; ?>" placeholder="Ingrese su apellido">
     <div id="nameHelp" class="form-text fw-medium text mt-0 mb-2">Entre 3 y 25 letras.</div>
 	  <!-- Error -->
        <?php if($validation->getError('apellido')) {?>
            <div class='py-1 alert alert-danger  mt-2' style="color: red; text-shadow: none;">
            El campo apellido es requerido.
              <?= $error = $validation->getError(''); ?>
            </div>
        <?php }?>
    </div>
    <div class="mb-3">
    	 <label for="exampleFormControlInput1" class="form-label">Email</label>
 	 <input name="email"  type="femail" class="form-control" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" placeholder="Correo@algo.com">
    <div id="nameHelp" class="form-text fw-medium text mt-0 mb-2">Entre 4 y 100 letras.</div>
 	  <!-- Error -->
        <?php if($validation->getError('email')) {?>
            <div class='py-1 alert alert-danger mt-2' style="color: red; text-shadow: none;">
            El campo email es requerido.
              <?= $error = $validation->getError(''); ?>
            </div>
        <?php }?>
	</div>
 	  <div class="mb-3">
 	<label for="exampleFormControlInput1" class="form-label">Usuario</label>
 	 <input  tyupe="text" name="usuario" class="form-control" value="<?php echo isset($_POST['usuario']) ? $_POST['usuario'] : ''; ?>" placeholder="Usuario">
    <div id="nameHelp" class="form-text fw-medium text mt-0 mb-2">Entre 3 y 25 letras.</div>
 	 <!-- Error -->
        <?php if($validation->getError('usuario')) {?>
            <div class='py-1 alert alert-danger mt-2' style="color: red; text-shadow: none;">
            El campo usuario es requerido.
              <?= $error = $validation->getError(''); ?>
            </div>
        <?php }?>
	</div>
	
	<div class="mb-3">
 	 <label for="exampleFormControlInput1" class="form-label">Password</label>
 	 <input name="pass" type="password" class="form-control" value="<?php echo isset($_POST['pass']) ? $_POST['pass'] : ''; ?>" placeholder="Password">
    <div id="nameHelp" class="form-text fw-medium text mt-0 mb-2">Entre 3 y 10 letras.</div>
 	 <!-- Error -->
        <?php if($validation->getError('pass')) {?>
            <div class='py-1 alert alert-danger mt-2' style="color: red; text-shadow: none;">
            El campo password es requerido.
              <?= $error = $validation->getError(''); ?>
            </div>
        <?php }?>
 	</div>
          <div class="container text-center">
          <input type="submit" value="Guardar" class="btn btn-success">
          <a href="<?php echo base_url('registro'); ?>" class="btn btn-danger">Cancelar</a>
 	        <input type="reset" value="Borrar" class="btn btn-secondary" onclick="borrarTextArea()">
          </div>
 	         
          </div>
  </form>
 	
</div>
</div>
</div>
</div>
